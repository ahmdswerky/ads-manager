<?php

use Illuminate\Support\Str;
use App\Models\Advertisement;

test('advertisement model has excerpt getter', function () {
    $ad = Advertisement::inRandomOrder()->first();
    $excerpt = strlen($ad->description) > 150 ?
        Str::limit($ad->description, 150, '...') : $ad->description;

    expect($ad->excerpt)->toEqual($excerpt);
});
