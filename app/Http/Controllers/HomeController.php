<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{DataHistory,DeviceDataStream};
use Carbon\Carbon;
use Telegram\Bot\Api;

class HomeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = DeviceDataStream::latest()->first();
        return view('pages.dashboard', compact('data'));
    }

    public function updateStreamData(Request $request, $id)
    {
        try {
            DeviceDataStream::updateOrCreate(
                ['id' => $id],
                [
                    'device_id' => 1,
                    'battery' => $request->battery,
                    'curah_hujan' => $request->curah_hujan,
                    'curah_hujan_status' => $request->curah_hujan_status,
                    'tinggi_air' => $request->tinggi_air,
                    'tinggi_air_status' => $request->tinggi_air_status,
                    'debit_air' => $request->debit_air,
                    'debit_air_status' => $request->debit_air_status
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Stream data updated successfully'
            ], 200);
        } catch (\Exception $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function getStreamData(){
        try {
            $data = DeviceDataStream::find(1);
            return response()->json([
                'status' => 'success',
                'data' => $data
            ],200);
        } catch (\Exception $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ],500);
        }
    }

    public function saveHistoryData(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'status' => 'required|string'
            ]);

            $now = now();

            // Ambil data terakhir dengan status yang sama
            $data = DataHistory::where('status', $request->status)->latest()->first();

            if ($data) {
                $endTime = Carbon::parse($data->end_time);

                // Periksa apakah end_time kurang dari 15 detik dari waktu sekarang
                if ($endTime->diffInSeconds($now) < 15) {
                    $data->update(['end_time' => $now]);
                    return response()->json(['message' => 'Data diperbarui'], 200);
                }
            }

            // Jika tidak memenuhi kondisi, buat data baru
            DataHistory::create([
                'status' => $request->status,
                'start_time' => $now,
                'end_time' => $now,
            ]);

            return response()->json(['message' => 'Data baru berhasil disimpan'], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getHistoryData(){
        $data = DataHistory::orderBy('end_time', 'desc')->limit(10)->get();
        return response()->json($data);
    }

    public function sendMessageBot(Request $request){
        $data = DataHistory::orderBy('end_time', 'desc')->latest()->first();
        // $message = "";
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $chatId = '7694944233';
        $message = $request->input('pesan');

        $reponse = $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $message,
        ]);

        return response()->json([
            'message' => "Pesan $request->pesan berhasil dikirim ke bot"
        ],200);
    }
}
