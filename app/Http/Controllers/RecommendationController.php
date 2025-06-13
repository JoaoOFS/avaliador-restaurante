<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $recommendations = $this->getPersonalizedRecommendations($user);

        return view('recommendations.index', [
            'recommendations' => $recommendations,
            'popularRestaurants' => Restaurant::with(['category', 'cuisine', 'photos'])
                ->withCount('reviews')
                ->orderBy('reviews_count', 'desc')
                ->take(6)
                ->get()
        ]);
    }

    private function getPersonalizedRecommendations($user)
    {
        if (!$user) {
            return Restaurant::with(['category', 'cuisine', 'photos'])
                ->withCount('reviews')
                ->orderBy('reviews_count', 'desc')
                ->take(6)
                ->get();
        }

        // Busca as categorias e cozinhas favoritas do usuário
        $favoriteCategories = Review::where('reviews.user_id', $user->id)
            ->where('reviews.rating', '>=', 4)
            ->join('restaurants', 'reviews.restaurant_id', '=', 'restaurants.id')
            ->join('categories', 'restaurants.category_id', '=', 'categories.id')
            ->select('categories.id')
            ->groupBy('categories.id')
            ->orderByRaw('COUNT(*) DESC')
            ->take(3)
            ->pluck('id');

        $favoriteCuisines = Review::where('reviews.user_id', $user->id)
            ->where('reviews.rating', '>=', 4)
            ->join('restaurants', 'reviews.restaurant_id', '=', 'restaurants.id')
            ->join('cuisines', 'restaurants.cuisine_id', '=', 'cuisines.id')
            ->select('cuisines.id')
            ->groupBy('cuisines.id')
            ->orderByRaw('COUNT(*) DESC')
            ->take(3)
            ->pluck('id');

        // Busca restaurantes que o usuário ainda não avaliou
        $recommendations = Restaurant::with(['category', 'cuisine', 'photos'])
            ->whereNotIn('id', function($query) use ($user) {
                $query->select('restaurant_id')
                    ->from('reviews')
                    ->where('user_id', $user->id);
            })
            ->where(function($query) use ($favoriteCategories, $favoriteCuisines) {
                $query->whereIn('category_id', $favoriteCategories)
                    ->orWhereIn('cuisine_id', $favoriteCuisines);
            })
            ->withCount(['reviews' => function($query) {
                $query->where('rating', '>=', 4);
            }])
            ->orderBy('reviews_count', 'desc')
            ->take(6)
            ->get();

        // Se não houver recomendações suficientes, adiciona restaurantes populares
        if ($recommendations->count() < 6) {
            $additionalRecommendations = Restaurant::with(['category', 'cuisine', 'photos'])
                ->whereNotIn('id', $recommendations->pluck('id'))
                ->withCount(['reviews' => function($query) {
                    $query->where('rating', '>=', 4);
                }])
                ->orderBy('reviews_count', 'desc')
                ->take(6 - $recommendations->count())
                ->get();

            $recommendations = $recommendations->concat($additionalRecommendations);
        }

        return $recommendations;
    }
}
