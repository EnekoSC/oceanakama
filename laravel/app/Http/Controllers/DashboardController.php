<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $reservas = $user->reservas()
            ->with('curso')
            ->latest()
            ->get();

        $resenasHechas = $user->resenas()
            ->pluck('curso_id')
            ->toArray();

        return view('dashboard', compact('reservas', 'resenasHechas'));
    }
}
