<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; 
use App\Models\Recipe;    

class DashboardController extends Controller
{
    public function index(): View
    {
        $recipes = Recipe::with('user') 
                         ->withCount(['likedByUsers', 'savedByUsers'])
                         ->latest()
                         ->get();


        return view('dashboard', [
            'recipes' => $recipes
        ]);
    }
}