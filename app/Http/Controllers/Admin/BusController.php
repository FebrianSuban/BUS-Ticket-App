<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::latest()->get();
        return view('admin.buses.index', compact('buses'));
    }

    public function create()
    {
        return view('admin.buses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bus' => 'required|string|max:255',
            'nomor_polisi' => 'required|string|max:255|unique:buses,nomor_polisi',
            'kapasitas' => 'required|integer|min:1',
        ]);

        Bus::create([
            'nama_bus' => $request->nama_bus,
            'nomor_polisi' => $request->nomor_polisi,
            'kapasitas' => $request->kapasitas,
        ]);

        return redirect()->route('admin.buses.index')->with('success', 'Bus berhasil ditambahkan');
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();
        return back()->with('success', 'Bus berhasil dihapus');
    }
}
