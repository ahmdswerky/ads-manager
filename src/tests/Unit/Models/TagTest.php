<?php

use App\Models\Tag;

test('can create tags', function () {
    $name = 'created';
    $tag = Tag::create(compact('name'));

    expect($tag->name)->toEqual($name);
});
