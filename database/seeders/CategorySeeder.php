<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Restaurante',
                'description' => 'Estabelecimentos que servem refeições completas.',
                'icon' => 'fa-utensils',
            ],
            [
                'name' => 'Café',
                'description' => 'Estabelecimentos que servem café, chá e lanches leves.',
                'icon' => 'fa-coffee',
            ],
            [
                'name' => 'Bar',
                'description' => 'Estabelecimentos que servem bebidas alcoólicas e petiscos.',
                'icon' => 'fa-glass-martini-alt',
            ],
            [
                'name' => 'Pizzaria',
                'description' => 'Estabelecimentos especializados em pizzas.',
                'icon' => 'fa-pizza-slice',
            ],
            [
                'name' => 'Hamburgueria',
                'description' => 'Estabelecimentos especializados em hambúrgueres.',
                'icon' => 'fa-hamburger',
            ],
            [
                'name' => 'Sushi',
                'description' => 'Estabelecimentos especializados em comida japonesa.',
                'icon' => 'fa-fish',
            ],
            [
                'name' => 'Churrascaria',
                'description' => 'Estabelecimentos especializados em carnes assadas.',
                'icon' => 'fa-drumstick-bite',
            ],
            [
                'name' => 'Fast Food',
                'description' => 'Estabelecimentos que servem comida rápida.',
                'icon' => 'fa-running',
            ],
            [
                'name' => 'Sobremesas',
                'description' => 'Estabelecimentos especializados em doces e sobremesas.',
                'icon' => 'fa-ice-cream',
            ],
            [
                'name' => 'Vegetariano',
                'description' => 'Estabelecimentos que servem comida vegetariana.',
                'icon' => 'fa-leaf',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'icon' => $category['icon'],
                'is_active' => true,
            ]);
        }
    }
}
