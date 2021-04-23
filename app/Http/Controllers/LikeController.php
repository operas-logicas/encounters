<?php

namespace App\Http\Controllers;

use App\Http\Resources\SightingShowResource;
use App\Models\Like;
use App\Models\Sighting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Request  $request
     * @return SightingShowResource | \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'sighting_id' => 'required|exists:sightings,id'
        ]);

        $sighting = Sighting::findOrFail($request->sighting_id);
        $user = Auth::user();

        $record = Like::where('sighting_id', $sighting->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$record) {
            $like = new Like();
            $like->sighting_id = $sighting->id;
            $like->user_id = $user->id;

            $like->save();

            return new SightingShowResource($sighting);
        }

        if ($record->user_id === $user->id) {
            $record->delete();
            return response()->json();
        }

        return response()->json([], 401);
    }
}
