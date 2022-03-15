<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AdvertisementTag extends Pivot
{
    protected $fillable = [
        'tag_id',
        'advertisement_id',
    ];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
