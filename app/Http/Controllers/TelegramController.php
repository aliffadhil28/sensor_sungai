<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Api;
use App\Console\Commands\SubscribeChannel;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function setWebHook(Request $request)
    {
        // Telegram::addCommand(SubscribeChannel::class);
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $url = 'https://84cf-180-254-65-227.ngrok-free.app/api/telegram/webhook'; // Sesuaikan dengan domain kamu

        $response = $telegram->setWebhook(['url' => $url]);

        return response()->json($response);
    }

    public function webhook(Request $request)
    {
        Telegram::commandsHandler(true);
        
        return true;
    }
}
