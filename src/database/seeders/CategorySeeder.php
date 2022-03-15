<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()
            ->count(10)
            ->hasAdvertisements(30)
            ->create();
    }
}
