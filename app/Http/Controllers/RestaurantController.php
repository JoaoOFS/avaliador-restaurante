<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Cuisine;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the restaurants.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Restaurant::with(['category', 'cuisine'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        // Filtros
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('cuisine')) {
            $query->where('cuisine_id', $request->cuisine);
        }

        if ($request->has('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Ordenação
        $query->when($request->sort, function($q, $sort) {
            switch ($sort) {
                case 'rating':
                    return $q->orderBy('average_rating', 'desc');
                case 'reviews':
                    return $q->orderBy('total_reviews', 'desc');
                case 'name':
                    return $q->orderBy('name');
                default:
                    return $q->latest();
            }
        }, function($q) {
            return $q->latest();
        });

        $restaurants = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();
        $cuisines = Cuisine::where('is_active', true)->get();

        return view('restaurants.index', compact('restaurants', 'categories', 'cuisines'));
    }

    /**
     * Show the form for creating a new restaurant.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $cuisines = Cuisine::where('is_active', true)->get();

        return view('restaurants.create', compact('categories', 'cuisines'));
    }

    /**
     * Store a newly created restaurant in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            \Log::info('Iniciando criação de restaurante', [
                'request' => $request->all(),
                'user_id' => auth()->id(),
                'has_files' => $request->hasFile('photos')
            ]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|size:2',
                'zip_code' => 'required|string|max:9',
                'phone' => 'required|string|max:15',
                'email' => 'nullable|email|max:255',
                'website' => 'nullable|url|max:255',
                'opening_hours' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'cuisine_id' => 'required|exists:cuisines,id',
                'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            \Log::info('Dados validados com sucesso', ['validated' => $validated]);

            // Prepara os dados para criação
            $data = $validated;
            $data['user_id'] = auth()->id();
            $data['is_active'] = true;
            $data['slug'] = Str::slug($validated['name']);

            \Log::info('Dados preparados para criação', ['data' => $data]);

            DB::beginTransaction();
            try {
                // Cria o restaurante
                $restaurant = Restaurant::create($data);
                \Log::info('Restaurante criado com sucesso', ['restaurant' => $restaurant->toArray()]);

                // Processa as fotos
                if ($request->hasFile('photos')) {
                    foreach ($request->file('photos') as $index => $photo) {
                        $path = $photo->store('restaurants', 'public');
                        $restaurant->photos()->create([
                            'url' => $path,
                            'is_featured' => $index === 0 // Primeira foto é a principal
                        ]);
                    }
                    \Log::info('Fotos processadas com sucesso');
                }

                DB::commit();
                \Log::info('Transação concluída com sucesso');

                return redirect()
                    ->route('restaurants.show', $restaurant)
                    ->with('success', 'Restaurante criado com sucesso!');

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Erro durante a transação', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erro de validação ao criar restaurante', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Erro ao criar restaurante', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            return back()
                ->withInput()
                ->with('error', 'Ocorreu um erro ao criar o restaurante. Por favor, tente novamente.');
        }
    }

    /**
     * Display the specified restaurant.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\View\View
     */
    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['category', 'cuisine', 'photos', 'reviews.user']);

        return view('restaurants.show', [
            'restaurant' => $restaurant,
            'reviews' => $restaurant->reviews()->with('user')->latest()->paginate(5)
        ]);
    }

    /**
     * Show the form for editing the specified restaurant.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\View\View
     */
    public function edit(Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $categories = Category::where('is_active', true)->get();
        $cuisines = Cuisine::where('is_active', true)->get();

        return view('restaurants.edit', compact('restaurant', 'categories', 'cuisines'));
    }

    /**
     * Update the specified restaurant in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:2',
            'zip_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'opening_hours' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'cuisine_id' => 'required|exists:cuisines,id',
            'is_active' => 'boolean',
            'photos.*' => 'nullable|image|max:2048'
        ]);

        $restaurant->update($validated);

        // Upload de novas fotos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('restaurants', 'public');

                $restaurant->photos()->create([
                    'url' => $path,
                    'user_id' => auth()->id()
                ]);
            }
        }

        return redirect()
            ->route('restaurants.show', $restaurant)
            ->with('success', 'Restaurante atualizado com sucesso!');
    }

    /**
     * Remove the specified restaurant from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Restaurant $restaurant)
    {
        $this->authorize('delete', $restaurant);

        // Excluir fotos do storage
        foreach ($restaurant->photos as $photo) {
            Storage::disk('public')->delete($photo->url);
        }

        $restaurant->delete();

        return redirect()
            ->route('restaurants.index')
            ->with('success', 'Restaurante excluído com sucesso!');
    }

    public function toggleFeatured(Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $restaurant->update(['is_featured' => !$restaurant->is_featured]);

        return back()->with('success',
            $restaurant->is_featured
                ? 'Restaurante destacado com sucesso!'
                : 'Restaurante removido dos destaques!'
        );
    }

    public function map()
    {
        $restaurants = Restaurant::with(['category', 'cuisine', 'photos', 'reviews'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('restaurants.map', compact('restaurants'));
    }
}
