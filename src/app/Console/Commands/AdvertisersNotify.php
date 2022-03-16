<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Advertisement;
use Illuminate\Console\Command;
use App\Mail\NotifyAdvertisersEmail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\AdvertisementResource;

class AdvertisersNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify advertisers about their next day\'s ads.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ads =  Advertisement::WhereDay('start_date', today()->addDay())->without('tags')->get()->groupBy('user_id');

        $ads->keys()->map(function ($userId) use ($ads) {
            $email = User::select(['email'])->find($userId)->email;
            $advertiserAds = $ads[$userId];

            Mail::to($email)->send(
                new NotifyAdvertisersEmail($advertiserAds)
            );
        });
    }
}
