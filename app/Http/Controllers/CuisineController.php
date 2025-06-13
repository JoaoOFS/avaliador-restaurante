<?php

namespace App\Http\Controllers;

use App\Models\Cuisine;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CuisineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cuisines = Cuisine::withCount('restaurants')
            ->orderBy('name')
            ->paginate(10);

        return view('cuisines.index', compact('cuisines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cuisines.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cuisines',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Cuisine::create($validated);

        return redirect()
            ->route('cuisines.index')
            ->with('success', 'Culinária criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cuisine $cuisine)
    {
        $cuisine->load(['restaurants' => function ($query) {
            $query->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->latest();
        }]);

        return view('cuisines.show', compact('cuisine'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cuisine $cuisine)
    {
        return view('cuisines.edit', compact('cuisine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cuisine $cuisine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cuisines,name,' . $cuisine->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $cuisine->update($validated);

        return redirect()
            ->route('cuisines.index')
            ->with('success', 'Culinária atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuisine $cuisine)
    {
        if ($cuisine->restaurants()->exists()) {
            return back()->with('error', 'Não é possível excluir uma culinária que possui restaurantes associados.');
        }

        $cuisine->delete();

        return redirect()
            ->route('cuisines.index')
            ->with('success', 'Culinária excluída com sucesso!');
    }

    public function toggleActive(Cuisine $cuisine)
    {
        $cuisine->update(['is_active' => !$cuisine->is_active]);

        return back()->with('success',
            $cuisine->is_active
                ? 'Culinária ativada com sucesso!'
                : 'Culinária desativada com sucesso!'
        );
    }
}
