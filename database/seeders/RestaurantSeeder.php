<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\User;
use App\Models\Category;
use App\Models\Cuisine;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();
        $cuisines = Cuisine::all();

        $restaurants = [
            [
                'name' => 'Restaurante do Chef',
                'description' => 'Culinária contemporânea com toques brasileiros.',
                'address' => 'Rua das Flores, 123',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01234-567',
                'phone' => '(11) 1234-5678',
                'email' => 'contato@chef.com',
                'website' => 'https://chef.com',
                'opening_hours' => 'Seg-Sex: 12h-15h, 19h-23h; Sáb-Dom: 12h-23h',
                'latitude' => -23.550520,
                'longitude' => -46.633308,
            ],
            [
                'name' => 'Sushi Master',
                'description' => 'Sushi e sashimi de alta qualidade.',
                'address' => 'Av. Paulista, 1000',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01310-100',
                'phone' => '(11) 2345-6789',
                'email' => 'contato@sushimaster.com',
                'website' => 'https://sushimaster.com',
                'opening_hours' => 'Seg-Dom: 12h-23h',
                'latitude' => -23.563090,
                'longitude' => -46.654390,
            ],
            [
                'name' => 'Pizzaria da Nonna',
                'description' => 'Pizzas tradicionais italianas.',
                'address' => 'Rua Augusta, 500',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01304-000',
                'phone' => '(11) 3456-7890',
                'email' => 'contato@nonna.com',
                'website' => 'https://nonna.com',
                'opening_hours' => 'Seg-Dom: 18h-23h',
                'latitude' => -23.550520,
                'longitude' => -46.633308,
            ],
            [
                'name' => 'Burger House',
                'description' => 'Hambúrgueres artesanais.',
                'address' => 'Rua Oscar Freire, 100',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01426-000',
                'phone' => '(11) 4567-8901',
                'email' => 'contato@burgerhouse.com',
                'website' => 'https://burgerhouse.com',
                'opening_hours' => 'Seg-Dom: 12h-23h',
                'latitude' => -23.563090,
                'longitude' => -46.654390,
            ],
            [
                'name' => 'Café da Manhã',
                'description' => 'Café da manhã completo e lanches.',
                'address' => 'Rua Haddock Lobo, 200',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zip_code' => '01414-000',
                'phone' => '(11) 5678-9012',
                'email' => 'contato@cafedamanha.com',
                'website' => 'https://cafedamanha.com',
                'opening_hours' => 'Seg-Dom: 7h-18h',
                'latitude' => -23.550520,
                'longitude' => -46.633308,
            ],
        ];

        foreach ($restaurants as $restaurant) {
            Restaurant::create([
                'name' => $restaurant['name'],
                'description' => $restaurant['description'],
                'address' => $restaurant['address'],
                'city' => $restaurant['city'],
                'state' => $restaurant['state'],
                'zip_code' => $restaurant['zip_code'],
                'phone' => $restaurant['phone'],
                'email' => $restaurant['email'],
                'website' => $restaurant['website'],
                'opening_hours' => $restaurant['opening_hours'],
                'latitude' => $restaurant['latitude'],
                'longitude' => $restaurant['longitude'],
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
                'cuisine_id' => $cuisines->random()->id,
                'is_active' => true,
            ]);
        }

        // Criar mais 20 restaurantes aleatórios
        Restaurant::factory(20)->create([
            'user_id' => fn() => $users->random()->id,
            'category_id' => fn() => $categories->random()->id,
            'cuisine_id' => fn() => $cuisines->random()->id,
        ]);
    }
}
