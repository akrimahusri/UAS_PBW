<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; // Penting untuk type hinting View
use App\Models\Recipe;    // 1. IMPORT MODEL RECIPE

class DashboardController extends Controller
{
    public function index(): View
    {
        // Ambil semua resep, diurutkan dari yang terbaru, DAN sertakan data user pembuatnya
        $recipes = Recipe::with('user') 
                         ->latest()
                         ->get();

        // Alternatif jika paginasi
        // $recipes = Recipe::with('user')->latest()->paginate(9);

        return view('dashboard', [
            'recipes' => $recipes
        ]);
    }
}