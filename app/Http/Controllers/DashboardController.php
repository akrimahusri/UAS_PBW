<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; // Penting untuk type hinting View

class DashboardController extends Controller
{
    public function index(): View
    {
        // Nanti di sini kamu akan mengambil data resep dari database.
        // Untuk sekarang, kita bisa gunakan data dummy seperti yang ada di dashboard.blade.php sebelumnya.
        $categories = [
            [
                'name' => 'Simple Breakfast',
                'recipes' => [
                    [
                        'image' => asset('images/placeholder/waffles.jpg'),
                        'title' => 'Waffles',
                        'description' => 'A recipe that\'s great to eat in the morning',
                        'rating' => 5
                    ],
                    [
                        'image' => asset('images/placeholder/pancakes.jpg'),
                        'title' => 'Pancakes',
                        'description' => 'A recipe that\'s great to eat in the morning',
                        'rating' => 4
                    ],
                    [
                        'image' => asset('images/placeholder/chocolate.jpg'),
                        'title' => 'Hot Chocolate',
                        'description' => 'A recipe that\'s great to eat in the morning',
                        'rating' => 5
                    ],
                ]
            ],
            // Tambahkan kategori dan resep lain jika perlu untuk tampilan awal
            [
                'name' => 'Simple Lunch',
                'recipes' => [
                     [
                        'image' => asset('images/placeholder/waffles.jpg'), // Ganti dengan gambar yang sesuai
                        'title' => 'Waffles Lunch',
                        'description' => 'A recipe that\'s great for lunch',
                        'rating' => 4
                    ],
                    // ... resep lunch lainnya
                ]
            ],
        ];

        return view('dashboard', [
            'categories' => $categories // Kirim data categories ke view
        ]);
    }
}