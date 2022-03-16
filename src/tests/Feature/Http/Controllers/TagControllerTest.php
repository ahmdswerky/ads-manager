<?php

use App\Models\Tag;
use App\Models\AdvertisementTag;
use function Pest\Laravel\delete;
use App\Http\Controllers\TagController;
use function PHPUnit\Framework\assertEquals;

it('deletes a tag with it\'s associated relations', function () {
    $count = Tag::count();
    $tag = Tag::has('advertisements')->inRandomOrder()->first();
    $tagId = $tag->id;

    delete(action([TagController::class, 'destroy'], [
        'tag' => $tagId,
    ]))->assertNoContent();

    assertEquals(0, AdvertisementTag::where('tag_id', $tagId)->count());

    assertEquals($count - 1, Tag::count());
});
