<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SongResource;
use App\Models\Audio;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SongController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $songs = Audio::with('category')
            ->where('status', true)
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%'.$request->string('search').'%';

                $query->where(function ($query) use ($term) {
                    $query->where('title', 'like', $term)
                        ->orWhere('artist', 'like', $term);
                });
            })
            ->inRandomOrder()
            ->paginate(20);

        return SongResource::collection($songs);
    }

    public function byCategory(Category $category): AnonymousResourceCollection
    {
        $category->loadCount(['audios as songs_count' => function ($query) {
            $query->where('status', true);
        }]);

        $songs = Audio::with('category')
            ->where('status', true)
            ->where('category_id', $category->id)
            ->inRandomOrder()
            ->paginate(20);

        return SongResource::collection($songs)->additional([
            'category' => new CategoryResource($category),
        ]);
    }

    public function show(string $audioId): SongResource
    {
        $song = Audio::with('category')
            ->where('audio_id', $audioId)
            ->where('status', true)
            ->firstOrFail();

        return new SongResource($song);
    }
}
