<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Device::all();
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
            'name' => $request['name'],
            'code' => $request['code'],
            'location' => $request['location'],
        ];

        try {
            $data = Device::create($payload);

            if ($data) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Data perangkat berhasil ditambahkan',
                    'data' => $data
                ],201);
            }
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
