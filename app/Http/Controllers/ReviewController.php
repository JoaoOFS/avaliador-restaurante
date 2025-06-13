<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Restaurant;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Review::with(['restaurant', 'user', 'photos'])
            ->latest();

        if ($request->has('restaurant')) {
            $query->where('restaurant_id', $request->restaurant);
        }

        if ($request->has('user')) {
            $query->where('user_id', $request->user);
        }

        if ($request->has('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->paginate(10);

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Restaurant $restaurant)
    {
        return view('reviews.create', compact('restaurant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'food_ratings' => 'required|array',
            'food_ratings.prato_principal' => 'required|integer|min:1|max:5',
            'service_ratings' => 'required|array',
            'service_ratings.atendimento' => 'required|integer|min:1|max:5',
            'ambiance_ratings' => 'required|array',
            'ambiance_ratings.decoracao' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
            'photos.*' => 'nullable|image|max:2048'
        ]);

        $review = $restaurant->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'food_ratings' => $validated['food_ratings'],
            'service_ratings' => $validated['service_ratings'],
            'ambiance_ratings' => $validated['ambiance_ratings'],
            'comment' => $validated['comment'],
        ]);

        // Upload das fotos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reviews', 'public');
                $review->photos()->create([
                    'path' => $path,
                    'user_id' => auth()->id()
                ]);
            }
        }

        // Atualizar média de avaliações do restaurante
        $restaurant->update([
            'average_rating' => $restaurant->reviews()->avg('rating'),
            'total_reviews' => $restaurant->reviews()->count()
        ]);

        return redirect()
            ->route('restaurants.show', $restaurant)
            ->with('success', 'Avaliação enviada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $review->load(['restaurant', 'user', 'photos']);
        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        $this->authorize('update', $review);
        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
            'food_ratings' => 'nullable|array',
            'food_ratings.*' => 'nullable|integer|min:1|max:5',
            'service_ratings' => 'nullable|array',
            'service_ratings.*' => 'nullable|integer|min:1|max:5',
            'ambiance_ratings' => 'nullable|array',
            'ambiance_ratings.*' => 'nullable|integer|min:1|max:5',
            'photos.*' => 'nullable|image|max:2048'
        ]);

        $review->update($validated);

        // Upload de novas fotos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reviews', 'public');

                $review->photos()->create([
                    'url' => $path,
                    'user_id' => auth()->id()
                ]);
            }
        }

        // Atualizar média de avaliações do restaurante
        $restaurant = $review->restaurant;
        $restaurant->update([
            'average_rating' => $restaurant->reviews()->avg('rating'),
            'total_reviews' => $restaurant->reviews()->count()
        ]);

        return redirect()
            ->route('restaurants.show', $review->restaurant)
            ->with('success', 'Avaliação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $restaurant = $review->restaurant;

        // Excluir fotos do storage
        foreach ($review->photos as $photo) {
            Storage::disk('public')->delete($photo->url);
        }

        $review->delete();

        // Atualizar média de avaliações do restaurante
        $restaurant->update([
            'average_rating' => $restaurant->reviews()->avg('rating'),
            'total_reviews' => $restaurant->reviews()->count()
        ]);

        return redirect()
            ->route('restaurants.show', $restaurant)
            ->with('success', 'Avaliação excluída com sucesso!');
    }

    public function toggleHelpful(Review $review)
    {
        $user = auth()->user();

        if ($review->helpfulVotes()->where('user_id', $user->id)->exists()) {
            $review->helpfulVotes()->detach($user->id);
            $message = 'Voto removido com sucesso!';
        } else {
            $review->helpfulVotes()->attach($user->id);
            $message = 'Voto registrado com sucesso!';
        }

        $review->update([
            'helpful_votes' => $review->helpfulVotes()->count()
        ]);

        return back()->with('success', $message);
    }

    public function toggleFeatured(Review $review)
    {
        $this->authorize('update', $review->restaurant);

        $review->update(['is_featured' => !$review->is_featured]);

        return back()->with('success',
            $review->is_featured
                ? 'Avaliação destacada com sucesso!'
                : 'Avaliação removida dos destaques!'
        );
    }
}
