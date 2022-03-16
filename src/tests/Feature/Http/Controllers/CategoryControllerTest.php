<?php

use App\Models\Category;

use function Pest\Laravel\delete;
use App\Http\Controllers\CategoryController;

it('can\'t delete a category associated with Ads', function () {
    $category = Category::has('advertisements')->inRandomOrder()->first();

    delete(action([CategoryController::class, 'destroy'], [
        'category' => $category->id,
    ]))->assertForbidden();
});

it('can delete a category as long it\'s not associated with an Ad', function () {
    $category = Category::has('advertisements')->inRandomOrder()->first();
    $categoryId = Category::where('id', '!=', $category->id)->inRandomOrder()->first()->id;
    // dissociated the advertisements from the category, so that the category pass for a delete
    $category->advertisements->each(fn ($ad) => $ad->update(['category_id' => $categoryId]));

    delete(action([CategoryController::class, 'destroy'], [
        'category' => $category->id,
    ]))->assertNoContent();
});
