<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function edit()
    {
        $setting = PaymentSetting::first();
        return view('admin.payment_settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'bank_name' => 'nullable|string|max:100',
            'account_number' => 'required|string|max:100',
        ]);

        $setting = PaymentSetting::first();
        if ($setting) {
            $setting->update($data);
        } else {
            $setting = PaymentSetting::create($data);
        }

        return back()->with('success', 'Pengaturan pembayaran berhasil disimpan');
    }
}


