<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'name',
    ];

    public function advertisements()
    {
        return $this->belongsToMany(Advertisement::class)->using(AdvertisementTag::class);
    }
}
