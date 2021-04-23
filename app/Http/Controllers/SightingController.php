<?php

namespace App\Http\Controllers;

use App\Http\Resources\SightingIndexResource;
use App\Http\Resources\SightingShowResource;
use App\Models\Sighting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SightingController extends Controller
{
    public function index(Request $request)
    {
        return SightingIndexResource::collection(
            $request->state
                ? Sighting::where('state', $request->state)->get()
                : Sighting::all()
        );
    }

    public function show($id)
    {
        return new SightingShowResource(Sighting::findOrFail($id));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'date' => 'required|date_format:Y-m-d',
            'description' => 'required|min:3',
            'location' => 'required|regex:/^-?\d+.?\d*,{1}-?\d+.?\d*$/',
            'state' => 'required|min:2',
            'image' => 'sometimes|file|image|max:2048'
        ]);

        $user = Auth::user();

        if (
            $request->hasFile('image') &&
            $request->file('image')->isValid()
        ) {
            $img_path = $request->file('image')->store('public/images/user');
            $img_path = substr($img_path, 7);
        } else {
            $img_path = null;
        }

        $sighting = new Sighting();
        $sighting->id = Str::uuid();
        $sighting->title = $request->input('title');
        $sighting->date = $request->input('date');
        $sighting->description = $request->input('description');
        $sighting->location = $request->input('location');
        $sighting->state = $request->input('state');
        $sighting->img_path = $img_path;

        $user->sightings()->save($sighting);

        return new SightingShowResource($sighting);
    }
}
