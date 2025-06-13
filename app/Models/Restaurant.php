<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class Restaurant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'city',
        'state',
        'zip_code',
        'phone',
        'email',
        'website',
        'opening_hours',
        'latitude',
        'longitude',
        'average_rating',
        'total_reviews',
        'is_featured',
        'is_active',
        'user_id',
        'category_id',
        'cuisine_id'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'average_rating' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cuisine()
    {
        return $this->belongsTo(Cuisine::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    // Auto-gerar slug antes de criar/atualizar
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($restaurant) {
            Log::info('Criando novo restaurante', ['data' => $restaurant->toArray()]);

            if (empty($restaurant->slug)) {
                $restaurant->slug = Str::slug($restaurant->name);
            }

            if (empty($restaurant->user_id)) {
                $restaurant->user_id = auth()->id();
            }

            if (!isset($restaurant->is_active)) {
                $restaurant->is_active = true;
            }
        });

        static::created(function ($restaurant) {
            Log::info('Restaurante criado com sucesso', ['restaurant' => $restaurant->toArray()]);
        });

        static::updating(function ($restaurant) {
            Log::info('Atualizando restaurante', ['data' => $restaurant->toArray()]);

            if ($restaurant->isDirty('name')) {
                $restaurant->slug = Str::slug($restaurant->name);
            }
        });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByCuisine($query, $cuisineId)
    {
        return $query->where('cuisine_id', $cuisineId);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', 'like', "%{$city}%");
    }

    // Métodos
    public function updateAverageRating()
    {
        $this->average_rating = $this->reviews()->avg('rating') ?? 0;
        $this->total_reviews = $this->reviews()->count();
        $this->save();
    }

    /**
     * Retorna a foto em destaque do restaurante.
     */
    public function featuredPhoto()
    {
        return $this->photos()->where('is_featured', true)->first();
    }

    /**
     * Retorna a URL da foto em destaque ou uma imagem padrão.
     */
    public function getFeaturedPhotoUrlAttribute()
    {
        $photo = $this->featuredPhoto();
        return $photo ? asset('storage/' . $photo->url) : asset('images/restaurant-default.jpg');
    }
}
