<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Untuk relasi ke User

class Recipe extends Model
{
    use HasFactory; // Mengaktifkan fitur factory untuk testing atau seeding

    /**
     * Atribut-atribut yang bisa diisi secara massal (mass assignable).
     *
     * Sesuaikan ini dengan kolom-kolom yang ada di tabel 'recipes' Anda
     * dan yang ingin Anda izinkan untuk diisi melalui Recipe::create() atau $recipe->fill().
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',          // ID pengguna yang membuat resep
        'title',            // Judul resep
        'description',      // Deskripsi singkat resep
        'ingredients',      // Bahan-bahan (bisa disimpan sebagai JSON)
        'directions',       // Langkah-langkah pembuatan
        'cooking_duration', // Durasi memasak (misalnya "30 minutes")
        'image_path',       // Path ke file gambar resep yang diupload
        // 'category_ids'    // Jika Anda menyimpan ID kategori sebagai array JSON atau string terpisah
                            // atau Anda akan menggunakan tabel pivot untuk relasi many-to-many dengan kategori
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     *
     * Ini sangat berguna jika Anda menyimpan 'ingredients' atau 'categories' sebagai JSON di database,
     * Laravel akan otomatis mengubahnya menjadi array PHP saat diambil, dan sebaliknya saat disimpan.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ingredients' => 'array', // Otomatis konversi JSON <-> array PHP
        // 'categories' => 'array', // Jika Anda menyimpan daftar kategori sebagai JSON
    ];

    /**
     * Mendefinisikan relasi bahwa sebuah Recipe dimiliki oleh (belongs to) satu User.
     *
     * Ini memungkinkan Anda untuk mudah mengambil data user dari sebuah resep,
     * misalnya: $recipe->user->name
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // Asumsi model User Anda ada di App\Models\User
    }

    /**
     * Opsional: Relasi Many-to-Many dengan Kategori.
     *
     * Jika Anda memiliki tabel 'categories' dan tabel pivot 'category_recipe'
     * untuk menghubungkan resep dengan banyak kategori.
     *
     * public function categories(): BelongsToMany
     * {
     * return $this->belongsToMany(Category::class, 'category_recipe');
     * }
     */
}