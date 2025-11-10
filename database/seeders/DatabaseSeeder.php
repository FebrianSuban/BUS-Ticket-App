<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Bus;
use App\Models\Route;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '081234567890',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Regular user
        User::create([
            'name' => 'User Test',
            'email' => 'user@user.com',
            'phone' => '081111111111',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Buses
        Bus::create(['nama_bus' => 'Sinar Jaya', 'nomor_polisi' => 'B 1234 AB', 'kapasitas' => 40]);
        Bus::create(['nama_bus' => 'Harapan Jaya', 'nomor_polisi' => 'D 5678 CD', 'kapasitas' => 35]);
        Bus::create(['nama_bus' => 'Budiman Express', 'nomor_polisi' => 'B 9012 EF', 'kapasitas' => 45]);

        // Routes
        Route::create([
            'kota_asal' => 'Jakarta',
            'kota_tujuan' => 'Bandung',
            'harga' => 150000,
            'jam_berangkat' => '08:00:00',
            'jam_tiba' => '11:00:00',
        ]);

        Route::create([
            'kota_asal' => 'Jakarta',
            'kota_tujuan' => 'Surabaya',
            'harga' => 350000,
            'jam_berangkat' => '20:00:00',
            'jam_tiba' => '08:00:00',
        ]);

        Route::create([
            'kota_asal' => 'Bandung',
            'kota_tujuan' => 'Yogyakarta',
            'harga' => 250000,
            'jam_berangkat' => '19:00:00',
            'jam_tiba' => '05:00:00',
        ]);
    }
}
