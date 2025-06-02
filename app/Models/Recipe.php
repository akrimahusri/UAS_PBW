<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; 

class Recipe extends Model
{
    use HasFactory; // Mengaktifkan fitur factory untuk testing atau seeding

    protected $fillable = [
        'user_id',          
        'title',            
        'description',      
        'ingredients',      
        'directions',       
        'cooking_duration', 
        'image_path',       
        'categories',    
    ];

    protected $casts = [
        'ingredients' => 'array', 
        'categories' => 'array', 
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); 
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating');
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function likedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes', 'recipe_id', 'user_id')->withTimestamps();
    }

     public function savedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'saves', 'recipe_id', 'user_id')->withTimestamps();
    }

}