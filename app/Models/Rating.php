<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['user_id', 'restaurant_id', 'score', 'comment'];

        public function user()
    {
        return $this->belongsTo(User::class);
    }

        public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
