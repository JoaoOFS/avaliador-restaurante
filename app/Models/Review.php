<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'rating',
        'food_ratings',
        'service_ratings',
        'ambiance_ratings',
        'comment',
        'is_verified',
        'helpful_count',
        'is_featured'
    ];

    protected $casts = [
        'food_ratings' => 'array',
        'service_ratings' => 'array',
        'ambiance_ratings' => 'array',
        'is_verified' => 'boolean',
        'is_featured' => 'boolean'
    ];

    // Relacionamentos
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(ReviewPhoto::class);
    }

    public function helpfulVotes()
    {
        return $this->hasMany(HelpfulVote::class);
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    // Métodos
    public function incrementHelpfulVotes()
    {
        $this->increment('helpful_votes');
    }

    public function decrementHelpfulVotes()
    {
        $this->decrement('helpful_votes');
    }

    // Eventos
    protected static function boot()
    {
        parent::boot();

        static::created(function ($review) {
            $review->restaurant->updateAverageRating();
        });

        static::updated(function ($review) {
            $review->restaurant->updateAverageRating();
        });

        static::deleted(function ($review) {
            $review->restaurant->updateAverageRating();
        });
    }
}
