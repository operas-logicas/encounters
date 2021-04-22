<?php

namespace App\Http\Resources;

use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class SightingIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->date,
            'description' => $this->description,
            'location' => $this->location,
            'state' => $this->state,
            'img_path' => $this->img_path,
            'user_handle' => User::findOrFail($this->user_id)->handle,
            'likes' => Like::where('sighting_id', $this->id)->count()
        ];
    }
}
