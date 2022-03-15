<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::factory()->count(40)->create();

        Advertisement::get()->map(function ($ad) use ($tags) {
            $tagsIds = $tags->random(4)->pluck('id');

            $ad->tags()->sync($tagsIds);
        });
    }
}
