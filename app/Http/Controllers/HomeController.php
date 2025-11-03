<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with(['bus', 'route'])
            ->where('tanggal_berangkat', '>=', now()->toDateString())
            ->where('kursi_tersedia', '>', 0);

        if ($request->kota_asal) {
            $query->whereHas('route', function($q) use ($request) {
                $q->where('kota_asal', 'like', '%' . $request->kota_asal . '%');
            });
        }

        if ($request->kota_tujuan) {
            $query->whereHas('route', function($q) use ($request) {
                $q->where('kota_tujuan', 'like', '%' . $request->kota_tujuan . '%');
            });
        }

        if ($request->tanggal) {
            $query->where('tanggal_berangkat', $request->tanggal);
        }

        $schedules = $query->orderBy('tanggal_berangkat')->get();

        return view('home', compact('schedules'));
    }
}
