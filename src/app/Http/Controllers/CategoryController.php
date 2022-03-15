<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index()
    {
        $categories = Category::paginate();

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->validated());

        return response([
            'category' => new CategoryResource($category),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response([
            'category' => new CategoryResource($category),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryUpdateRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response([
            'category' => new CategoryResource($category->fresh()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->advertisements()->count()) {
            return response([
                'message' => __('messages.category_attached_to_ads'),
            ], 403);
        }

        $category->delete();

        return response([], 204);
    }
}
