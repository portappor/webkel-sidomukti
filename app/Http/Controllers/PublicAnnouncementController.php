<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class PublicAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::where('is_active', true)->latest()->paginate(12);
        return view('announcements.index', compact('announcements'));
    }
}
