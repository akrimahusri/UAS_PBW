<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // <--- IMPORT HasMany jika belum ada

// Jika Anda memiliki model Recipe, pastikan juga di-import jika perlu, contoh:
// use App\Models\Recipe;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all of the recipes for the User.
     */
    public function recipes(): HasMany // Tipe return disesuaikan dengan relasi
    {
        // Ganti App\Models\Recipe::class dengan path yang benar ke model Recipe Anda
        // Jika nama foreign key di tabel recipes bukan 'user_id', Anda perlu menentukannya sebagai argumen kedua
        // return $this->hasMany(Recipe::class, 'foreign_key_di_tabel_recipes', 'local_key_di_tabel_users');
        return $this->hasMany(Recipe::class); // Asumsi model Recipe ada di App\Models\Recipe dan foreign key 'user_id'
    }
}