<?php

namespace App\Http\Controllers;

use App\Models\PaymentProof;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PaymentProofController extends Controller
{
    public function show(PaymentProof $paymentProof): Response
    {
        $booking = $paymentProof->booking;

        if (Gate::denies('view', $booking) && !(auth()->check() && auth()->user()->isAdmin())) {
            abort(403);
        }

        if (!Storage::disk('public')->exists($paymentProof->path)) {
            abort(404);
        }

        return Storage::disk('public')->response($paymentProof->path);
    }
}


