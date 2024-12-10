<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceData;
use App\Models\DeviceAttachment;
use Carbon\Carbon;

class PageController extends Controller
{
    /**
     * Display all the static pages when authenticated
     *
     * @param string $page
     * @return \Illuminate\View\View
     */
    public function index(string $page)
    {
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}");
        }

        return abort(404);
    }

    public function riwayat(Request $request){
        $tanggal_awal = $request->tanggal_awal ?? Carbon::now()->format('Y-m-d');
        $tanggal_akhir = $request->tanggal_akhir ?? Carbon::now()->addDays(7)->format('Y-m-d');
        
        $data = DeviceData::whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->selectRaw('DATE(tanggal) as tanggal, AVG(debit_air) as avg_debit_air, AVG(tinggi_air) as avg_tinggi_air, AVG(curah_hujan) as avg_curah_hujan')
            ->groupBy('tanggal') // Kelompokkan berdasarkan tanggal unik
            ->orderBy('tanggal', 'asc') // Urutkan berdasarkan tanggal
            ->get();

        // Format tanggal dan data lainnya
        $dataChart = $data->map(function ($item) {
            return [
                'tanggal' => Carbon::parse($item->tanggal)->format('Y M d'),
                'avg_debit_air' => round($item->avg_debit_air, 2),
                'avg_tinggi_air' => round($item->avg_tinggi_air, 2),
                'avg_curah_hujan' => round($item->avg_curah_hujan, 2),
            ];
        });
        $data = [
            'tanggalTinggi' => $dataChart->pluck('tanggal')->toArray(),
            'avg_debit_air' => $dataChart->pluck('avg_debit_air')->toArray(),
            'avg_tinggi_air' => $dataChart->pluck('avg_tinggi_air')->toArray(),
            'avg_curah_hujan' => $dataChart->pluck('avg_curah_hujan')->toArray(),
        ];
    
        if ($request->expectsJson()) {
            return response()->json($data);
        }
    
        return view('pages.riwayat', [
            'tanggalTinggi' => json_encode($data['tanggalTinggi']),
            'avg_debit_air' => json_encode($data['avg_debit_air']),
            'avg_tinggi_air' => json_encode($data['avg_tinggi_air']),
            'avg_curah_hujan' => json_encode($data['avg_curah_hujan']),
        ]);     
    }

    public function gambar(Request $request){
        $tanggal = $request->tanggal ?? Carbon::now()->format('Y-m-d');
        $data = DeviceAttachment::whereDate('tanggal',$tanggal)
            ->get();
        if ($request->expectsJson()) {
            return response()->json($data);
        }
        return view('pages.gambar',compact('data'));
    }

    public function vr()
    {
        return view("pages.virtual-reality");
    }

    public function rtl()
    {
        return view("pages.rtl");
    }

    public function profile()
    {
        return view("pages.profile-static");
    }

    public function signin()
    {
        return view("pages.sign-in-static");
    }

    public function signup()
    {
        return view("pages.sign-up-static");
    }
}
