<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRestaurants = Restaurant::count();
        $totalReviews = Review::count();
        $activeUsers = User::count();

        $featuredRestaurants = Restaurant::withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->take(6)
            ->get();

        $latestReviews = Review::with(['user', 'restaurant'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalRestaurants',
            'totalReviews',
            'activeUsers',
            'featuredRestaurants',
            'latestReviews'
        ));
    }
}
