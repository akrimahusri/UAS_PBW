<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; // Penting untuk type hinting View
use App\Models\Recipe;    // 1. IMPORT MODEL RECIPE

class DashboardController extends Controller
{
    public function index(): View
    {
        // Ambil semua resep, diurutkan dari yang terbaru, dan sertakan data user pembuatnya
        $recipes = Recipe::with('user') 
                         ->withCount(['likedByUsers', 'savedByUsers'])
                         ->latest()
                         ->get();


        return view('dashboard', [
            'recipes' => $recipes
        ]);
    }
}