<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{DeviceData,DeviceDataStream};

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
}
