<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CuisineController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\RecommendationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Rotas do Painel Administrativo
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/restaurants', [AdminDashboardController::class, 'restaurants'])->name('restaurants');
    Route::get('/reviews', [AdminDashboardController::class, 'reviews'])->name('reviews');
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    Route::get('/categories', [AdminDashboardController::class, 'categories'])->name('categories');
    Route::get('/cuisines', [AdminDashboardController::class, 'cuisines'])->name('cuisines');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de Restaurantes
    Route::resource('restaurants', RestaurantController::class);
    Route::post('restaurants/{restaurant}/toggle-featured', [RestaurantController::class, 'toggleFeatured'])->name('restaurants.toggle-featured');
    Route::post('restaurants/{restaurant}/photos', [RestaurantController::class, 'storePhoto'])->name('restaurants.photos.store');
    Route::delete('restaurants/{restaurant}/photos/{photo}', [RestaurantController::class, 'destroyPhoto'])->name('restaurants.photos.destroy');

    // Rotas de Avaliações
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::resource('restaurants.reviews', ReviewController::class)->shallow();
    Route::post('reviews/{review}/toggle-helpful', [ReviewController::class, 'toggleHelpful'])->name('reviews.toggle-helpful');
    Route::post('reviews/{review}/toggle-featured', [ReviewController::class, 'toggleFeatured'])->name('reviews.toggle-featured');
    Route::post('reviews/{review}/helpful', [ReviewController::class, 'markAsHelpful'])->name('reviews.helpful');
    Route::post('reviews/{review}/comments', [ReviewController::class, 'storeComment'])->name('reviews.comments.store');
    Route::delete('reviews/{review}/comments/{comment}', [ReviewController::class, 'destroyComment'])->name('reviews.comments.destroy');

    // Rotas de Categorias
    Route::resource('categories', CategoryController::class);
    Route::post('categories/{category}/toggle-active', [CategoryController::class, 'toggleActive'])->name('categories.toggle-active');

    // Rotas de Culinárias
    Route::resource('cuisines', CuisineController::class);
    Route::post('cuisines/{cuisine}/toggle-active', [CuisineController::class, 'toggleActive'])->name('cuisines.toggle-active');

    // Rotas de Avaliações
    Route::post('/restaurants/{restaurant}/ratings', [RatingController::class, 'store'])->name('ratings.store');

    // Rotas para o mapa
    Route::get('/mapa', [RestaurantController::class, 'map'])->name('restaurants.map');

    // Rotas para recomendações
    Route::get('/recomendacoes', [RecommendationController::class, 'index'])->name('recommendations.index');
});

require __DIR__.'/auth.php';
