<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $restaurants = Restaurant::all();

        $reviews = [
            [
                'rating' => 5,
                'comment' => 'Excelente restaurante! Comida deliciosa e atendimento impecável.',
                'food_ratings' => [
                    'prato_principal' => 5,
                    'sobremesa' => 5,
                    'bebidas' => 5,
                ],
                'service_ratings' => [
                    'atendimento' => 5,
                    'velocidade' => 5,
                    'cordialidade' => 5,
                ],
                'ambiance_ratings' => [
                    'decoracao' => 5,
                    'limpeza' => 5,
                    'conforto' => 5,
                ],
            ],
            [
                'rating' => 4,
                'comment' => 'Muito bom! Comida saborosa e ambiente agradável.',
                'food_ratings' => [
                    'prato_principal' => 4,
                    'sobremesa' => 5,
                    'bebidas' => 4,
                ],
                'service_ratings' => [
                    'atendimento' => 4,
                    'velocidade' => 3,
                    'cordialidade' => 5,
                ],
                'ambiance_ratings' => [
                    'decoracao' => 4,
                    'limpeza' => 5,
                    'conforto' => 4,
                ],
            ],
            [
                'rating' => 3,
                'comment' => 'Regular. Comida boa, mas o serviço poderia melhorar.',
                'food_ratings' => [
                    'prato_principal' => 4,
                    'sobremesa' => 3,
                    'bebidas' => 3,
                ],
                'service_ratings' => [
                    'atendimento' => 2,
                    'velocidade' => 3,
                    'cordialidade' => 3,
                ],
                'ambiance_ratings' => [
                    'decoracao' => 3,
                    'limpeza' => 4,
                    'conforto' => 3,
                ],
            ],
            [
                'rating' => 2,
                'comment' => 'Não recomendo. Comida fria e atendimento ruim.',
                'food_ratings' => [
                    'prato_principal' => 2,
                    'sobremesa' => 3,
                    'bebidas' => 2,
                ],
                'service_ratings' => [
                    'atendimento' => 1,
                    'velocidade' => 2,
                    'cordialidade' => 2,
                ],
                'ambiance_ratings' => [
                    'decoracao' => 3,
                    'limpeza' => 2,
                    'conforto' => 2,
                ],
            ],
            [
                'rating' => 1,
                'comment' => 'Péssimo! Comida ruim e atendimento horrível.',
                'food_ratings' => [
                    'prato_principal' => 1,
                    'sobremesa' => 2,
                    'bebidas' => 1,
                ],
                'service_ratings' => [
                    'atendimento' => 1,
                    'velocidade' => 1,
                    'cordialidade' => 1,
                ],
                'ambiance_ratings' => [
                    'decoracao' => 2,
                    'limpeza' => 1,
                    'conforto' => 1,
                ],
            ],
        ];

        foreach ($restaurants as $restaurant) {
            // Criar 2-5 avaliações para cada restaurante
            $numReviews = rand(2, 5);

            for ($i = 0; $i < $numReviews; $i++) {
                $review = $reviews[array_rand($reviews)];

                Review::create([
                    'restaurant_id' => $restaurant->id,
                    'user_id' => $users->random()->id,
                    'rating' => $review['rating'],
                    'comment' => $review['comment'],
                    'food_ratings' => $review['food_ratings'],
                    'service_ratings' => $review['service_ratings'],
                    'ambiance_ratings' => $review['ambiance_ratings'],
                    'is_verified' => true,
                    'is_featured' => rand(0, 1),
                    'helpful_votes' => rand(0, 10),
                ]);
            }

            // Atualizar média de avaliações do restaurante
            $restaurant->update([
                'average_rating' => $restaurant->reviews()->avg('rating'),
                'total_reviews' => $restaurant->reviews()->count(),
            ]);
        }
    }
}
