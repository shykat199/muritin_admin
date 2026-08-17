<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use App\Models\Category;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'categoriesCount' => Category::count(),
            'audiosCount' => Audio::count(),
            'activeAudiosCount' => Audio::where('status', true)->count(),
            'latestAudios' => Audio::with('category')->latest()->take(5)->get(),
        ]);
    }
}
