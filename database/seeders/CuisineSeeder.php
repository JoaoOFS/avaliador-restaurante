<?php

namespace Database\Seeders;

use App\Models\Cuisine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CuisineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cuisines = [
            [
                'name' => 'Brasileira',
                'description' => 'Culinária tradicional brasileira.',
                'icon' => 'fa-flag',
            ],
            [
                'name' => 'Italiana',
                'description' => 'Culinária tradicional italiana.',
                'icon' => 'fa-pizza-slice',
            ],
            [
                'name' => 'Japonesa',
                'description' => 'Culinária tradicional japonesa.',
                'icon' => 'fa-fish',
            ],
            [
                'name' => 'Chinesa',
                'description' => 'Culinária tradicional chinesa.',
                'icon' => 'fa-dragon',
            ],
            [
                'name' => 'Mexicana',
                'description' => 'Culinária tradicional mexicana.',
                'icon' => 'fa-pepper-hot',
            ],
            [
                'name' => 'Indiana',
                'description' => 'Culinária tradicional indiana.',
                'icon' => 'fa-pepper-hot',
            ],
            [
                'name' => 'Árabe',
                'description' => 'Culinária tradicional árabe.',
                'icon' => 'fa-moon',
            ],
            [
                'name' => 'Francesa',
                'description' => 'Culinária tradicional francesa.',
                'icon' => 'fa-wine-glass-alt',
            ],
            [
                'name' => 'Alemã',
                'description' => 'Culinária tradicional alemã.',
                'icon' => 'fa-beer',
            ],
            [
                'name' => 'Vegetariana',
                'description' => 'Culinária baseada em vegetais.',
                'icon' => 'fa-leaf',
            ],
        ];

        foreach ($cuisines as $cuisine) {
            Cuisine::create([
                'name' => $cuisine['name'],
                'slug' => Str::slug($cuisine['name']),
                'description' => $cuisine['description'],
                'icon' => $cuisine['icon'],
                'is_active' => true,
            ]);
        }
    }
}
