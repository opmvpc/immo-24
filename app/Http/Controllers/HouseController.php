<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render("Houses/Index", [
            "houses" => House::query()->with(["photos" => function (Builder $query) {
                $query->take(4);
            }])->paginate(12),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("Houses/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => "required|string|max:255",
            "description" => "required|string",
            "price" => "required|integer|min:1",
            "address" => "required|string|max:255",
            "bedrooms_count" => "required|integer|min:1",
            "space" => "required|integer|min:1",
        ]);

        House::create($validated);

        return redirect()
            ->route("houses.index")
            ->banner("Maison créée avec succès");
    }

    /**
     * Display the specified resource.
     */
    public function show(House $house)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(House $house)
    {
        return Inertia::render("Houses/Edit", [
            'house' => $house->load("photos"),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, House $house)
    {
        $validated = $request->validate([
            "title" => "required|string|max:255",
            "description" => "required|string",
            "price" => "required|integer|min:1",
            "address" => "required|string|max:255",
            "bedrooms_count" => "required|integer|min:1",
            "space" => "required|integer|min:1",
        ]);

        $house->update($validated);

        return redirect()
            ->back()
            ->banner("Maison modifiée avec succès");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(House $house)
    {
        //
    }
}
