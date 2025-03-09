<?php

namespace App\Console\Commands;

use Telegram\Bot\Commands\Command;
use App\Models\MemberTelegram;

class SubscribeChannel extends Command
{
    protected string $name = 'subscribe';
    protected string $description = 'Subscribe to this service';

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
            $from = $message->from;

            // Ambil username, jika tidak ada gunakan first_name dan last_name
            $username = $from->username ?? trim(($from->first_name ?? '') . ' ' . ($from->last_name ?? ''));

            // Cek apakah chat_id sudah terdaftar
            $existingUser = MemberTelegram::where('chat_id', $chatId)->first();
            if ($existingUser) {
                $this->replyWithMessage([
                    'text' => "Anda sudah berlangganan, $username! Tidak perlu subscribe lagi.",
                ]);
                return;
            }

            // Simpan data ke database
            MemberTelegram::create([
                'chat_id' => $chatId,
                'username' => $username
            ]);

            // Kirim konfirmasi ke pengguna
            $this->replyWithMessage([
                'text' => "Terima kasih telah berlangganan layanan kami, $username! Anda akan menerima update pemberitahuan dari layanan ini.",
            ]);
        } catch (\Exception $e) {
            \Log::error("Gagal melakukan subscribe: " . $e->getMessage());

            $this->replyWithMessage([
                'text' => "Terjadi kesalahan saat memproses permintaan Anda. Silakan coba lagi nanti.",
            ]);
        }
    }
}
