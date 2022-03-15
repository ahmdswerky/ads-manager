<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Filters\TagFilter;
use App\Http\Resources\TagResource;
use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param TagFilter  $filters
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index(TagFilter $filters)
    {
        $tags = Tag::filter($filters)->paginate();

        return TagResource::collection($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TagStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagStoreRequest $request)
    {
        $tag = Tag::create($request->validated());

        return response([
            'tag' => new TagResource($tag),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return response([
            'tag' => new TagResource($tag),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TagUpdateRequest  $request
     * @param  Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagUpdateRequest $request, Tag $tag)
    {
        $tag->update($request->validated());

        return response([
            'tag' => new TagResource($tag->fresh()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->advertisements()->detach();

        return response([], 204);
    }
}
