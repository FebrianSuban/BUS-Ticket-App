<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class BusController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('home');
    }
}


