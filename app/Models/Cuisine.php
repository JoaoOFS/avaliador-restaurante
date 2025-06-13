<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Cuisine extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relacionamento com os restaurantes do tipo de culinária.
     */
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    /**
     * Retorna apenas os tipos de culinária ativos.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Auto-gerar slug antes de criar/atualizar
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cuisine) {
            $cuisine->slug = Str::slug($cuisine->name);
        });

        static::updating(function ($cuisine) {
            if ($cuisine->isDirty('name')) {
                $cuisine->slug = Str::slug($cuisine->name);
            }
        });
    }
}
