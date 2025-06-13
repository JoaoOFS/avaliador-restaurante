<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Category;
use App\Models\Cuisine;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $recentRestaurants = Restaurant::with(['photos', 'category', 'cuisine'])
            ->latest()
            ->take(6)
            ->get();

        $popularCategories = Category::withCount('restaurants')
            ->orderBy('restaurants_count', 'desc')
            ->take(4)
            ->get();

        $featuredRestaurants = Restaurant::with(['photos', 'cuisine'])
            ->where('is_featured', true)
            ->where('is_active', true)
            ->orderBy('average_rating', 'desc')
            ->take(6)
            ->get();

        $latestReviews = Review::with(['user', 'restaurant'])
            ->where('is_verified', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $featuredCuisines = Cuisine::withCount('restaurants')
            ->where('is_active', true)
            ->orderBy('restaurants_count', 'desc')
            ->take(8)
            ->get();

        // Contagens para a seção de estatísticas
        $totalRestaurants = Restaurant::where('is_active', true)->count();
        $totalReviews = Review::where('is_verified', true)->count();
        $totalUsers = User::count();
        $totalCities = Restaurant::where('is_active', true)
            ->distinct('city')
            ->count('city');

        return view('home', compact(
            'recentRestaurants',
            'popularCategories',
            'featuredRestaurants',
            'latestReviews',
            'featuredCuisines',
            'totalRestaurants',
            'totalReviews',
            'totalUsers',
            'totalCities'
        ));
    }
}
