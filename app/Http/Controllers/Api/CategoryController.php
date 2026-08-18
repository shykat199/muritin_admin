<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::withCount(['audios as songs_count' => function ($query) {
                $query->where('status', true);
            }])
            ->where('status', true)
            ->orderBy('name')
            ->get();

        return CategoryResource::collection($categories);
    }
}
