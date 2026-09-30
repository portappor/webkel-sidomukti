<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\RukunWarga;
use Illuminate\Http\Request;

class DemographicController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $rukunWargas = RukunWarga::orderBy('nama_rw')->get();
        return view('dashboard.demographics.index', compact('settings', 'rukunWargas'));
    }
}
