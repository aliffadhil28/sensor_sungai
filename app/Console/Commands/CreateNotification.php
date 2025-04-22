<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\DataHistory;
use App\Models\DeviceDataStream;
use App\Models\MemberTelegram;
use Telegram\Bot\Api;
use Carbon\Carbon;

class CreateNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes sensor data and creates notifications based on detection status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Fetch the latest sensor data
            $data = DeviceDataStream::latest()->first();
            
            if (!$data) {
                $this->error('No sensor data available');
                return 1;
            }
            
            // Process battery status
            $batteryMonitor = $this->getBatteryStatus($data->battery);
            
            // Process water level status
            $waterLevelMonitor = $this->getWaterLevelStatus($data->tinggi_air);
            
            // Process water flow status
            $waterFlowMonitor = $this->getWaterFlowStatus($data->debit_air);
            
            // Process rainfall status
            $rainfallMonitor = $this->getRainfallStatus($data->curah_hujan);
            
            // Dalam method handle()
            // Setelah mendapatkan detection status
            $detectionStatus = $this->getDetectionStatus(
                $data->curah_hujan,
                $data->tinggi_air,
                $data->debit_air
            );

            // Cek apakah status adalah Waspada atau Bahaya
            if ($detectionStatus === 'Waspada' || $detectionStatus === 'Bahaya') {
                // Ambil data history terakhir dengan status yang sama
                $lastAlert = DataHistory::where('status', $detectionStatus)
                                    ->latest()
                                    ->first();
                
                $now = now();
                
                if ($lastAlert) {
                    $endTime = Carbon::parse($lastAlert->end_time);
                    
                    // Periksa apakah end_time kurang dari 15 detik dari waktu sekarang
                    if ($endTime->diffInSeconds($now) < 15) {
                        // Update waktu akhir jika status masih sama dan dalam 15 detik terakhir
                        $lastAlert->update([
                            'end_time' => $now,
                            'updated_at' => $now
                        ]);
                        
                        $this->info("Updated existing alert end time for status: {$detectionStatus}");
                    } else {
                        // Buat history baru karena sudah lebih dari 15 detik
                        $historyData = $this->saveHistoryData($detectionStatus, $data);
                        
                        if ($historyData) {
                            // Kirim notifikasi Telegram
                            $this->sendTelegramNotification($detectionStatus, $data, $historyData);
                            $this->info("Created new alert and sent notification for status: {$detectionStatus}");
                        }
                    }
                } else {
                    // Belum ada history dengan status tersebut, buat baru
                    $historyData = $this->saveHistoryData($detectionStatus, $data);
                    
                    if ($historyData) {
                        // Kirim notifikasi Telegram
                        $this->sendTelegramNotification($detectionStatus, $data, $historyData);
                        $this->info("Created first alert and sent notification for status: {$detectionStatus}");
                    }
                }
            }
            
            // Output current status
            $this->info("Battery: {$batteryMonitor['text']} ({$batteryMonitor['status']})");
            $this->info("Water Level: {$waterLevelMonitor['text']} ({$waterLevelMonitor['status']})");
            $this->info("Water Flow: {$waterFlowMonitor['text']} ({$waterFlowMonitor['status']})");
            $this->info("Rainfall: {$rainfallMonitor['text']} ({$rainfallMonitor['status']})");
            $this->info("Overall Detection Status: {$detectionStatus}");
            
            return 0;
        } catch (\Exception $e) {
            $this->error("Error processing notifications: {$e->getMessage()}");
            Log::error("Notification command error: {$e->getMessage()}", [
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }
    
    /**
     * Get battery status based on percentage
     */
    private function getBatteryStatus($data)
    {
        if ($data >= 75 && $data <= 100) {
            return [
                'color' => 'success',
                'text' => 'Aman',
                'status' => '> 75%'
            ];
        } elseif ($data >= 50 && $data < 75) {
            return [
                'color' => 'warning',
                'text' => 'Siaga',
                'status' => '> 50%'
            ];
        } elseif ($data >= 25 && $data < 50) {
            return [
                'color' => 'danger',
                'text' => 'Waspada',
                'status' => '> 25%'
            ];
        } else {
            return [
                'color' => 'danger',
                'text' => 'Bahaya',
                'status' => '< 25%'
            ];
        }
    }
    
    /**
     * Get water level status based on height in cm
     */
    private function getWaterLevelStatus($data)
    {
        if ($data >= 0 && $data <= 100) {
            return [
                'color' => 'danger',
                'text' => 'Bahaya',
                'status' => '< 100'
            ];
        } elseif ($data > 100 && $data <= 120) {
            return [
                'color' => 'danger',
                'text' => 'Siaga',
                'status' => '> 100'
            ];
        } elseif ($data > 120 && $data <= 130) {
            return [
                'color' => 'warning',
                'text' => 'Waspada',
                'status' => '> 120'
            ];
        } else {
            return [
                'color' => 'success',
                'text' => 'Aman',
                'status' => '> 130'
            ];
        }
    }
    
    /**
     * Get water flow status based on L/s
     */
    private function getWaterFlowStatus($data)
    {
        if ($data >= 0 && $data <= 10) {
            return [
                'color' => 'success',
                'text' => 'Lambat',
                'status' => '< 10'
            ];
        } elseif ($data > 10 && $data <= 20) {
            return [
                'color' => 'warning',
                'text' => 'Siaga',
                'status' => '< 20'
            ];
        } elseif ($data > 20 && $data <= 30) {
            return [
                'color' => 'danger',
                'text' => 'Waspada',
                'status' => '< 30'
            ];
        } else {
            return [
                'color' => 'danger',
                'text' => 'Bahaya',
                'status' => '> 30'
            ];
        }
    }
    
    /**
     * Get rainfall status based on mm
     */
    private function getRainfallStatus($data)
    {
        if ($data >= 2800 && $data <= 4056) {
            return [
                'color' => 'success',
                'text' => 'Aman',
                'status' => '< 4056'
            ];
        } elseif ($data >= 1800 && $data < 2800) {
            return [
                'color' => 'warning',
                'text' => 'Siaga',
                'status' => '< 2800'
            ];
        } elseif ($data >= 800 && $data < 1800) {
            return [
                'color' => 'danger',
                'text' => 'Waspada',
                'status' => '< 1800'
            ];
        } else {
            return [
                'color' => 'danger',
                'text' => 'Bahaya',
                'status' => '< 800'
            ];
        }
    }
    
    /**
     * Get overall detection status based on sensor statuses
     */
    private function getDetectionStatus($curah_hujan, $tinggi_air, $debit_air)
    {
        // Kategorisasi curah hujan
        $kategori_hujan = '';
        if ($curah_hujan >= 2800) {
            $kategori_hujan = 't'; // Tidak hujan / Aman
        } elseif ($curah_hujan >= 1800 && $curah_hujan < 2800) {
            $kategori_hujan = 'r'; // Ringan
        } elseif ($curah_hujan >= 800 && $curah_hujan < 1800) {
            $kategori_hujan = 'sd'; // Sedang
        } else {
            $kategori_hujan = 'l'; // Lebat / Bahaya
        }

        // Kategorisasi ketinggian air
        $kategori_air = '';
        if ($tinggi_air >= 130) {
            $kategori_air = 'r'; // Rendah / Aman
        } elseif ($tinggi_air >= 120 && $tinggi_air < 130) {
            $kategori_air = 'sd'; // Sedang
        } elseif ($tinggi_air >= 100 && $tinggi_air < 120) {
            $kategori_air = 't'; // Tinggi
        } else {
            $kategori_air = 'st'; // Sangat tinggi / Bahaya
        }

        // Kategorisasi debit air
        $kategori_debit = '';
        if ($debit_air >= 0 && $debit_air <= 10) {
            $kategori_debit = 'lm'; // Lambat / Aman
        } elseif ($debit_air > 10 && $debit_air <= 20) {
            $kategori_debit = 'sd'; // Sedang
        } elseif ($debit_air > 20 && $debit_air <= 30) {
            $kategori_debit = 'cp'; // Cepat
        } else {
            $kategori_debit = 'sl'; // Sangat Lambat / Bahaya
        }

        // Define detection rules based on the JavaScript logic
        $rules = [
            't' => [
                'r' => [
                    'lm' => 'Aman',
                    'sd' => 'Siaga',
                    'cp' => 'Waspada',
                    'sl' => 'Bahaya'
                ],
                'sd' => [
                    'lm' => 'Siaga',
                    'sd' => 'Waspada',
                    'cp' => 'Bahaya',
                    'sl' => 'Bahaya'
                ],
                't' => [
                    'lm' => 'Waspada',
                    'sd' => 'Bahaya',
                    'cp' => 'Bahaya',
                    'sl' => 'Bahaya'
                ],
                'st' => [
                    'lm' => 'Bahaya',
                    'sd' => 'Bahaya',
                    'cp' => 'Bahaya',
                    'sl' => 'Bahaya'
                ]
            ],
            'r' => [
                'r' => [
                    'lm' => 'Aman',
                    'sd' => 'Siaga',
                    'cp' => 'Siaga',
                    'sl' => 'Waspada'
                ],
                'sd' => [
                    'lm' => 'Siaga',
                    'sd' => 'Waspada',
                    'cp' => 'Waspada',
                    'sl' => 'Bahaya'
                ],
                't' => [
                    'lm' => 'Waspada',
                    'sd' => 'Bahaya',
                    'cp' => 'Bahaya',
                    'sl' => 'Bahaya'
                ],
                'st' => [
                    'lm' => 'Bahaya',
                    'sd' => 'Bahaya',
                    'cp' => 'Bahaya',
                    'sl' => 'Bahaya'
                ]
            ],
            'sd' => [
                'r' => [
                    'lm' => 'Siaga',
                    'sd' => 'Waspada',
                    'cp' => 'Waspada',
                    'sl' => 'Bahaya'
                ],
                'sd' => [
                    'lm' => 'Waspada',
                    'sd' => 'Waspada',
                    'cp' => 'Bahaya',
                    'sl' => 'Bahaya'
                ],
                't' => [
                    'lm' => 'Bahaya',
                    'sd' => 'Bahaya',
                    'cp' => 'Bahaya',
                    'sl' => 'Bahaya'
                ],
                'st' => [
                    'lm' => 'Bahaya',
                    'sd' => 'Bahaya',
                    'cp' => 'Bahaya',
                    'sl' => 'Bahaya'
                ]
            ],
            'l' => [
                'r' => [
                    'lm' => 'Siaga',
                    'sd' => 'Waspada',
                    'cp' => 'Bahaya',
                    'sl' => 'Bahaya'
                ],
                'sd' => [
                    'lm' => 'Waspada',
                    'sd' => 'Bahaya',
                    'cp' => 'Bahaya',
                    'sl' => 'Bahaya'
                ],
                't' => [
                    'lm' => 'Bahaya',
                    'sd' => 'Bahaya',
                    'cp' => 'Bahaya',
                    'sl' => 'Bahaya'
                ],
                'st' => [
                    'lm' => 'Bahaya',
                    'sd' => 'Bahaya',
                    'cp' => 'Bahaya',
                    'sl' => 'Bahaya'
                ]
            ]
        ];

        // Check if all keys exist and return the status
        if (isset($rules[$kategori_hujan][$kategori_air][$kategori_debit])) {
            return $rules[$kategori_hujan][$kategori_air][$kategori_debit];
        }
        
        return 'data tidak valid';
    }
    
    /**
     * Save history data when alert status is triggered
     */
    private function saveHistoryData($status, $data)
    {
        try {
            $history = DataHistory::create([
                'status' => $status,
                'start_time' => now(),
                'end_time' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            $this->info("History data saved with status: {$status}");
            return $history;
        } catch (\Exception $e) {
            $this->error("Failed to save history data: {$e->getMessage()}");
            Log::error("History data save error: {$e->getMessage()}", [
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }
    
    /**
     * Send notification to Telegram
     */
    private function sendTelegramNotification($status, $data, $historyData)
    {
        try {
            // Initialize Telegram API
            $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
            $chatIds = MemberTelegram::pluck('chat_id')->toArray();

            if (empty($chatIds)) {
                Log::warning("Tidak ada chat_id yang terdaftar untuk menerima notifikasi.");
                return false;
            }

            // Format date/time
            $timestamp = now()->format('d/m/Y H:i:s');

            // Create message
            $message = "⚠️ *PERINGATAN DINI* ⚠️\n\n";
            $message .= "Status: *" . strtoupper($status) . "*\n";
            $message .= "Waktu: {$timestamp}\n\n";
            $message .= "📊 *Data Sensor:*\n";
            $message .= "🌊 Ketinggian Air: {$data->tinggi_air} cm\n";
            $message .= "💧 Debit Air: {$data->debit_air} L/s\n";
            $message .= "☔ Curah Hujan: {$data->curah_hujan} mm\n";
            $message .= "🔋 Baterai: {$data->battery}%\n\n";

            // Add instructions based on status
            if ($status === 'Bahaya') {
                $message .= "🚨 *TINDAKAN SEGERA:* Segera evakuasi ke tempat yang lebih tinggi. Ikuti petunjuk dari petugas berwenang.\n";
            } else if ($status === 'Waspada') {
                $message .= "⚠️ *TINDAKAN:* Persiapkan dokumen penting dan barang berharga. Pantau perkembangan situasi.\n";
            }

            // Add alert ID for reference
            if ($historyData) {
                $message .= "\nID Peringatan: #{$historyData->id}";
            }

            // Send message to all chat_ids
            $successCount = 0;
            foreach ($chatIds as $chatId) {
                try {
                    $telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => $message,
                        'parse_mode' => 'Markdown'
                    ]);
                    $successCount++;
                } catch (\Exception $e) {
                    Log::error("Gagal mengirim notifikasi ke chat_id: {$chatId}. Error: {$e->getMessage()}");
                }
            }

            if ($successCount > 0) {
                Log::info("Notifikasi berhasil dikirim ke {$successCount} pengguna.");
                return true;
            } else {
                Log::error("Gagal mengirim notifikasi ke semua pengguna.");
                return false;
            }

        } catch (\Exception $e) {
            Log::error("Kesalahan umum dalam mengirim notifikasi Telegram: {$e->getMessage()}", [
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

}
