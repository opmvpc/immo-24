<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, House $house)
    {
        $validated = $request->validate([
            "files" => "required|array",
            "files.*" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ]);

        foreach ($validated["files"] as $photo) {
            $path = $photo->store("houses/{$house->id}", "public");

            $house->photos()->create([
                "path" => $path,
                "alt" => $photo->getClientOriginalName(),
            ]);
        }

        return redirect()
            ->back()
            ->banner("Photos ajoutées avec succès");
    }

    /**
     * Display the specified resource.
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photo $photo)
    {
        Storage::disk("public")->delete($photo->path);

        $photo->delete();

        return redirect()
            ->back()
            ->banner("Photo supprimée avec succès");

    }
}
