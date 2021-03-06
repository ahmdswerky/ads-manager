<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Support\Str;
use App\Enum\AdvertisementType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advertisement extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'type',
        'title',
        'description',
        'category_id',
        'user_id',
        'start_date',
    ];

    protected $with = [
        'category',
        'tags',
    ];

    protected $casts = [
        'type' => AdvertisementType::class,
        'start_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeValid($query)
    {
        return $query->where('start_date', '>=', now());
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByTags($query, $tags)
    {
        return $query->whereHas('tags', function ($q) use ($tags) {
            $q->whereIn('name', $tags);
        });
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->using(AdvertisementTag::class);
    }

    protected function excerpt(): Attribute
    {
        return new Attribute(
            get: fn () => strlen($this->description) > 150 ?
                Str::limit($this->description, 150, '...') : $this->description,
        );
    }
}
