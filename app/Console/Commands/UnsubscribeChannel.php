<?php

namespace App\Console\Commands;

use Telegram\Bot\Commands\Command;
use App\Models\MemberTelegram;

class UnsubscribeChannel extends Command
{
    protected string $name = 'unsubscribe';
    protected string $description = 'Unsubscribe from this service';

    public function handle()
    {
        try {
            $update = $this->getUpdate();
            $message = $update->getMessage();

            // Pastikan message dan chat tidak null sebelum mengakses propertinya
            if (!$message || !$message->getChat()) {
                $this->replyWithMessage([
                    'text' => "Gagal mendapatkan informasi chat. Coba lagi nanti.",
                ]);
                return;
            }

            $chatId = $message->getChat()->getId();

            // Cek apakah pengguna sudah terdaftar
            $existingUser = MemberTelegram::where('chat_id', $chatId)->first();

            if (!$existingUser) {
                $this->replyWithMessage([
                    'text' => "Anda belum berlangganan layanan ini.",
                ]);
                return;
            }

            // Hapus pengguna dari database
            $existingUser->delete();

            // Kirim konfirmasi ke pengguna
            $this->replyWithMessage([
                'text' => "Anda telah berhenti berlangganan dari layanan ini. Jika ingin berlangganan kembali, gunakan perintah /subscribe.",
            ]);
        } catch (\Exception $e) {
            \Log::error("Gagal melakukan unsubscribe: " . $e->getMessage());

            $this->replyWithMessage([
                'text' => "Terjadi kesalahan saat memproses permintaan Anda. Silakan coba lagi nanti.",
            ]);
        }
    }
}
