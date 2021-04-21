<?php

namespace App\Http\Controllers;

use App\Http\Resources\SightingIndexResource;
use App\Http\Resources\SightingShowResource;
use App\Models\Sighting;
use App\Models\User;
use Illuminate\Http\Request;
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
            'file' => 'nullable|file|image|max:2048'
        ]);

        $user = User::all()->random();

        $sighting = new Sighting();
        $sighting->id = Str::uuid();
        $sighting->title = $request->input('title');
        $sighting->date = $request->input('date');
        $sighting->description = $request->input('description');
        $sighting->location = $request->input('location');
        $sighting->state = $request->input('state');
        $sighting->img_path =
            $request->hasFile('file') && $request->file('file')->isValid()
                ? $request->file('file')->store('images/user')
                : null;

        $user->sightings()->save($sighting);

        return new SightingShowResource($sighting);
    }
}
