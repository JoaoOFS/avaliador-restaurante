<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\User;
use App\Models\Category;
use App\Models\Cuisine;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRestaurants = Restaurant::count();
        $totalReviews = Review::count();
        $totalUsers = User::count();
        $totalCategories = Category::count();
        $totalCuisines = Cuisine::count();

        $recentRestaurants = Restaurant::with(['category', 'cuisine'])
            ->latest()
            ->take(5)
            ->get();

        $recentReviews = Review::with(['user', 'restaurant'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRestaurants',
            'totalReviews',
            'totalUsers',
            'totalCategories',
            'totalCuisines',
            'recentRestaurants',
            'recentReviews'
        ));
    }

    public function restaurants()
    {
        $restaurants = Restaurant::with(['category', 'cuisine'])
            ->latest()
            ->paginate(10);

        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function reviews()
    {
        $reviews = Review::with(['user', 'restaurant'])
            ->latest()
            ->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function users()
    {
        $users = User::latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function categories()
    {
        $categories = Category::latest()
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function cuisines()
    {
        $cuisines = Cuisine::latest()
            ->paginate(10);

        return view('admin.cuisines.index', compact('cuisines'));
    }
}
