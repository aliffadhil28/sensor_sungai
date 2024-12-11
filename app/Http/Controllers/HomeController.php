<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceData;

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
        $data = DeviceData::select('battery','curah_hujan','tinggi_air','debit_air')->latest()->first();
        return view('pages.dashboard', compact('data'));
    }
}
