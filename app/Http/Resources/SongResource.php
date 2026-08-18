<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'audio_id' => $this->audio_id,
            'title' => $this->title,
            'artist' => $this->artist,
            'year_of_publish' => $this->year_of_publish,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'thumbnail_url' => $this->thumbnail ? asset('uploads/thumbnails/'.$this->thumbnail) : null,
            'audio_url' => asset('uploads/audios/'.$this->audio_file),
        ];
    }
}
