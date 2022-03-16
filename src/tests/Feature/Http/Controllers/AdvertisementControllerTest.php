<?php

use App\Models\Tag;
use App\Models\User;
use App\Models\Category;
use App\Models\Advertisement;
use function Pest\Laravel\get;
use function Pest\Laravel\put;
use App\Enum\AdvertisementType;
use function Pest\Laravel\post;
use App\Models\AdvertisementTag;
use function Pest\Laravel\delete;
use function PHPUnit\Framework\assertEquals;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Http\Controllers\AdvertisementController;

it('has advertisements data', function () {
    get(action([AdvertisementController::class, 'index']))
        ->assertOk()
        ->assertJson(function (AssertableJson $json) {
            $json->has('data', function (AssertableJson $json) {
                $json->each(
                    fn ($one) => $one
                        ->has('category')
                        ->has('tags')
                        ->etc(),
                );
            });
        });
});

it('validates creating an advertisement with falsy data', function () {
    $data = [
        'title' => 'Too long, Lorem, ipsum dolor sit amet consectetur adipisicing elit. Similique delectus doloremque quas expedita ex. Soluta culpa dolorem reprehenderit, numquam ipsam beatae architecto! Debitis magnam culpa esse alias hic illum porro error quos sapiente. Labore, assumenda consectetur. Et accusantium laudantium dignissimos earum, veniam molestiae atque expedita! Quam aspernatur reiciendis alias molestiae? Illo esse doloremque eaque dolor, doloribus rem aliquam quam soluta minus, libero incidunt odit iusto non accusamus labore quod, commodi excepturi corrupti officiis iste delectus. Voluptatem eos rem iure? Voluptate ratione temporibus earum distinctio blanditiis aspernatur, libero voluptatibus quisquam officia quia iste, necessitatibus porro est. Iusto odio facere repudiandae, quibusdam magni minima error earum eaque aspernatur provident culpa sed velit quasi ea delectus, vel molestias omnis, expedita architecto beatae? Vel tempore dolores at blanditiis eveniet error vero, id sapiente odit porro fugiat natus aspernatur ex culpa unde veniam dolorum impedit libero veritatis accusamus nihil atque iure. Quaerat rem aliquam voluptatem placeat vitae ex. Veritatis, omnis perspiciatis facere soluta, atque non ab cum odio dignissimos officiis, laudantium cupiditate numquam? Vero ut necessitatibus consectetur deserunt, eveniet nisi nam illo possimus nulla odit quam dignissimos quidem suscipit recusandae, cupiditate laudantium unde voluptatem eos quaerat cumque maiores odio impedit corrupti? Voluptas atque labore, deserunt beatae fuga sequi temporibus aspernatur minima quis, quaerat asperiores ipsum fugit sunt, eaque quod. Asperiores a omnis aliquam eveniet error nihil nemo alias reiciendis, doloribus ipsam vel, nesciunt incidunt sit. Consequatur, assumenda doloremque optio rem aliquid totam, sapiente vitae blanditiis provident aspernatur voluptatum minima, nulla asperiores? Saepe, tenetur eius. Aspernatur praesentium harum vero ipsa sunt illum non impedit asperiores quia, laborum eaque. Expedita amet necessitatibus id culpa quibusdam consequatur cumque tempora iure officiis, repellendus adipisci fugiat illo pariatur maiores ut quod, provident corrupti. Veritatis sed reiciendis molestiae enim nulla! Pariatur dolorum blanditiis nam voluptatem perspiciatis. Laborum recusandae in architecto aperiam!',
        'description' => 'Short',
        'type' => 'invalid',
        'user_id' => 10000, // doesn't exist
        'category_id' => 10000, // doesn't exist
        'tags_ids' => [],
        'start_date' => now()->subDay()->format('Y-m-d H:ia'),
    ];

    post(action([AdvertisementController::class, 'store']), $data)
        ->assertJsonValidationErrors([
            'title',
            'description',
            'type',
            'category_id',
            'user_id',
            'start_date',
        ]);
});

it('creates an advertisement', function () {
    $count = Advertisement::count();
    $data = [
        'title' => 'Today\'s ad',
        'description' => 'Lorem ipsum dolor.',
        'type' => AdvertisementType::FREE->value,
        'user_id' => User::first()->id,
        'category_id' => Category::first()->id,
        'tags_ids' => Tag::inRandomOrder()->take(4)->select('id')->get()->pluck('id')->toArray(),
        'start_date' => now()->addDay()->format('Y-m-d H:ia'),
    ];

    post(action([AdvertisementController::class, 'store']), $data)
        ->assertJson(function (AssertableJson $json) use ($data) {
            $json->where('ad.title', $data['title'])
                ->where('ad.description', $data['description'])
                ->where('ad.type', AdvertisementType::FREE->value)
                ->has('ad.category')
                ->has('ad.tags');
        })
        ->assertCreated();

    assertEquals($count + 1, Advertisement::count());
});

it('updates an advertisement', function () {
    $ad = Advertisement::inRandomOrder()->first();
    $data = [
        'title' => 'An updated Ad',
        'description' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit.',
        'type' => AdvertisementType::PAID->value,
        'user_id' => User::inRandomOrder()->first()->id,
        'category_id' => Category::inRandomOrder()->first()->id,
        'tags_ids' => Tag::inRandomOrder()->take(4)->select('id')->get()->pluck('id')->toArray(),
        'start_date' => now()->addDays(2)->format('Y-m-d H:ia'),
    ];

    put(action([AdvertisementController::class, 'update'], ['advertisement' => $ad->id]), $data)
        ->assertJson(function (AssertableJson $json) use ($data) {
            $json->where('ad.title', $data['title'])
                ->where('ad.description', $data['description'])
                ->where('ad.type', AdvertisementType::PAID->value)
                ->has('ad.category')
                ->has('ad.tags');
        })
        ->assertOk();
});

it('deletes an advertisement with it\'s associated relations', function () {
    $count = Advertisement::count();
    $ad = Advertisement::has('tags')->inRandomOrder()->first();
    $adId = $ad->id;

    delete(action([AdvertisementController::class, 'destroy'], [
        'advertisement' => $adId,
    ]))->assertNoContent();

    assertEquals(0, AdvertisementTag::where('advertisement_id', $adId)->count());

    assertEquals($count - 1, Advertisement::count());
});
