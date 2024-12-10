<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeviceData;
use App\Models\DeviceAttachment;
use App\Models\Device;
use Carbon\Carbon;

class DeviceDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DeviceData::all();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $payload = [
                'device_id' => $request['device_id'],
                'tanggal' => $request['tanggal'],
                'waktu' => $request['waktu'],
                'debit_air' => $request['debit_air'],
                'tinggi_air' => $request['tinggi_air'],
                'curah_hujan' => $request['curah_hujan'],
                'battery' => $request['battery'],
            ];

        try {
            $device = Device::find($request['device_id']);
            if($device){
                $data = DeviceData::create($payload);
                if ($data) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Data berhasil ditambahkan',
                        'data' => $data
                    ],201);
                }
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Device tidak ditemukan',
            ],404); 
        } catch (\Exception $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ],500);
        }
    }

    public function storeAttachment(Request $request)
    {

        if (isset($request->attachment)) {
            $file = $request->file('attachment');
            $fileName = strtotime(Carbon::now()) . '.' . $file->getClientOriginalExtension();
            if (!file_exists(public_path('attachment'))) {
                mkdir(public_path('attachment'), 0777, true);
            }
            $file->move(public_path('attachment'), $fileName);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'File wajib diisi',
            ],404);
        }

        $payload = [
            'device_id' => $request->device_id,
            'file' => "attachment/$fileName",
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu
        ];

        try {
            $data = DeviceAttachment::create($payload);
            if (!$data) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Data gagal ditambahkan',
                ],400);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan',
                'data' => $data
            ],201);
        } catch (\Exception $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage(),
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
