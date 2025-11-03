<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = ['kota_asal', 'kota_tujuan', 'harga', 'jam_berangkat', 'jam_tiba'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
