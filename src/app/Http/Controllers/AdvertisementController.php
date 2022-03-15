<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Http\Filters\AdvertisementFilter;
use App\Http\Resources\AdvertisementResource;
use App\Http\Requests\AdvertisementStoreRequest;
use App\Http\Requests\AdvertisementUpdateRequest;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param AdvertisementFilter  $filters
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index(AdvertisementFilter $filters)
    {
        $ads = Advertisement::filter($filters)->valid()->paginate();

        return AdvertisementResource::collection($ads);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AdvertisementStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertisementStoreRequest $request)
    {
        $ad = Advertisement::create($request->validated());

        if ($request->has('tags_ids')) {
            $ad->tags()->attach($request->tags_ids);
        }

        return response([
            'ad' => new AdvertisementResource($ad),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show(Advertisement $advertisement)
    {
        return response([
            'ad' => new AdvertisementResource($advertisement),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AdvertisementUpdateRequest  $request
     * @param  Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(AdvertisementUpdateRequest $request, Advertisement $advertisement)
    {
        $advertisement->update($request->validated());

        if ($request->has('tags_ids')) {
            $advertisement->tags()->sync($request->tags_ids);
        }

        return response([
            'ad' => new AdvertisementResource($advertisement->fresh()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertisement $advertisement)
    {
        $advertisement->tags()->detach();
        $advertisement->delete();

        return response([], 204);
    }
}
