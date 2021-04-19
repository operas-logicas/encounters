<?php

namespace App\Http\Controllers;

use App\Http\Resources\SightingIndexResource;
use App\Models\Sighting;
use Illuminate\Http\Request;

class SightingController extends Controller
{
    public function index(Request $request) {
        return SightingIndexResource::collection(
            $request->state
                ? Sighting::where('state', $request->state)->get()
                : Sighting::all()
        );
    }

    public function show($id) {
        return Sighting::findOrFail($id)->likes();
    }

    public function store(Request $request) {

    }
}
