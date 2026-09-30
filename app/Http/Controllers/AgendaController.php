<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Setting;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        if (class_exists(\App\Models\Agenda::class)) { \App\Models\Agenda::cleanupExpired(); }

        $settings = Setting::pluck('value', 'key')->toArray();
        $agendas = Agenda::where('is_active', true)->orderBy('date', 'desc')->get();
        return view('agendas.index', compact('agendas', 'settings'));
    }
}
