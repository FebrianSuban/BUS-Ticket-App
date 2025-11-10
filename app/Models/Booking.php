<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'kode_booking',
        'user_id',
        'schedule_id',
        'nama_penumpang',
        'no_telepon',
        'jumlah_tiket',
        'total_harga',
        'status',
        'payment_status',
        'payment_notified_at',
        'payment_proof_path',
    ];

    public function paymentProofs()
    {
        return $this->hasMany(PaymentProof::class);
    }

    public function latestPaymentProof()
    {
        return $this->hasOne(PaymentProof::class)->latestOfMany();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
