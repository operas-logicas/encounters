<?php

namespace App\Http\Controllers;

use App\Http\Resources\SightingIndexResource;
use App\Models\Sighting;
use Illuminate\Http\Request;

class SightingController extends Controller
{
    public function index() {
        return SightingIndexResource::collection(
            Sighting::all()
        )->sortByDesc('likes');
    }

    public function show($id) {
        return Sighting::findOrFail($id)->likes();
    }

    public function store(Request $request) {

    }
}
