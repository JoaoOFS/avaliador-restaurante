<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Cuisine;
use Illuminate\Support\Str;

class CategoryAndCuisineSeeder extends Seeder
{
    public function run(): void
    {
        // Categorias
        $categories = [
            [
                'name' => 'Restaurante',
                'description' => 'Estabelecimentos que servem refeições completas',
                'icon' => 'fa-solid fa-utensils'
            ],
            [
                'name' => 'Café',
                'description' => 'Cafeterias e casas de café',
                'icon' => 'fa-solid fa-mug-hot'
            ],
            [
                'name' => 'Bar',
                'description' => 'Bares e pubs',
                'icon' => 'fa-solid fa-wine-glass'
            ],
            [
                'name' => 'Fast Food',
                'description' => 'Restaurantes de comida rápida',
                'icon' => 'fa-solid fa-burger'
            ],
            [
                'name' => 'Pizzaria',
                'description' => 'Restaurantes especializados em pizzas',
                'icon' => 'fa-solid fa-pizza-slice'
            ],
            [
                'name' => 'Sobremesas',
                'description' => 'Docerias e sorveterias',
                'icon' => 'fa-solid fa-ice-cream'
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'icon' => $category['icon'],
                'is_active' => true
            ]);
        }

        // Cozinhas
        $cuisines = [
            [
                'name' => 'Brasileira',
                'description' => 'Culinária tradicional brasileira',
                'icon' => 'fa-solid fa-flag'
            ],
            [
                'name' => 'Italiana',
                'description' => 'Culinária italiana tradicional',
                'icon' => 'fa-solid fa-pizza-slice'
            ],
            [
                'name' => 'Japonesa',
                'description' => 'Culinária japonesa e sushi',
                'icon' => 'fa-solid fa-fish'
            ],
            [
                'name' => 'Mexicana',
                'description' => 'Culinária mexicana tradicional',
                'icon' => 'fa-solid fa-pepper-hot'
            ],
            [
                'name' => 'Chinesa',
                'description' => 'Culinária chinesa tradicional',
                'icon' => 'fa-solid fa-drumstick-bite'
            ],
            [
                'name' => 'Indiana',
                'description' => 'Culinária indiana tradicional',
                'icon' => 'fa-solid fa-pepper-hot'
            ],
            [
                'name' => 'Mediterrânea',
                'description' => 'Culinária mediterrânea',
                'icon' => 'fa-solid fa-fish'
            ],
            [
                'name' => 'Vegana',
                'description' => 'Culinária vegana e vegetariana',
                'icon' => 'fa-solid fa-leaf'
            ]
        ];

        foreach ($cuisines as $cuisine) {
            Cuisine::create([
                'name' => $cuisine['name'],
                'slug' => Str::slug($cuisine['name']),
                'description' => $cuisine['description'],
                'icon' => $cuisine['icon'],
                'is_active' => true
            ]);
        }
    }
}
