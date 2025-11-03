<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = ['nama_bus', 'nomor_polisi', 'kapasitas'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
