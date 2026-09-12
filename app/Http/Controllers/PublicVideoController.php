<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class PublicVideoController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'all');

        $query = Video::latest();
        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $videos = $query->paginate(12);

        return view('videos.index', compact('videos', 'category'));
    }
}
