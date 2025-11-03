<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::latest()->get();
        return view('admin.routes.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.routes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kota_asal' => 'required|string|max:255',
            'kota_tujuan' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'jam_berangkat' => 'required|date_format:H:i',
            'jam_tiba' => 'required|date_format:H:i',
        ]);

        Route::create([
            'kota_asal' => $request->kota_asal,
            'kota_tujuan' => $request->kota_tujuan,
            'harga' => $request->harga,
            'jam_berangkat' => $request->jam_berangkat,
            'jam_tiba' => $request->jam_tiba,
        ]);

        return redirect()->route('admin.routes.index')->with('success', 'Rute berhasil ditambahkan');
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return back()->with('success', 'Rute berhasil dihapus');
    }
}
