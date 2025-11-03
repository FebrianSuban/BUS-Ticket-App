<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Bus;
use App\Models\Route;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['bus', 'route'])->latest()->get();
        return view('admin.bookings.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $buses = Bus::all();
        $routes = Route::all();
        return view('admin.bookings.schedules.create', compact('buses', 'routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'tanggal_berangkat' => 'required|date',
        ]);

        $bus = Bus::findOrFail($request->bus_id);

        Schedule::create([
            'bus_id' => $request->bus_id,
            'route_id' => $request->route_id,
            'tanggal_berangkat' => $request->tanggal_berangkat,
            'kursi_tersedia' => $bus->kapasitas,
        ]);

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal berhasil dihapus');
    }
}
