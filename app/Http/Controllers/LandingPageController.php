<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; // <--- TAMBAHKAN BARIS INI

class LandingPageController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index(): View // Sekarang 'View' akan merujuk ke 'Illuminate\View\View'
    {
        return view('landing');
    }
}