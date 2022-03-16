<?php

use App\Models\Tag;

test('creates a tags', function () {
    $name = 'created';
    $tag = Tag::create(compact('name'));

    expect($tag->name)->toEqual($name);
});
