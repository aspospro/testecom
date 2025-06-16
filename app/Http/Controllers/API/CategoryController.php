<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;

class CategoryController extends Controller
{
    /**
     * Return all categories, each with its groups and subgroups.
     */
    public function index()
    {
        // Eager‐load groups and subgroups in one query:
        $categories = ProductCategory::with([
            'groups.subgroups'   // “groups” → then each group’s “subgroups”
        ])->get();

        return response()->json($categories);
    }

    public function products(Category $category)
{
    return response()->json(
      $category->products()->with('prices')->get()
    );
}

}
