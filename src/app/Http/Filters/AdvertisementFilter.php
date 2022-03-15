<?php

namespace App\Http\Filters;

class AdvertisementFilter extends QueryFilter
{
    public function user($userId)
    {
        return $this->builder->byUser($userId);
    }

    public function category($categoryId)
    {
        return $this->builder->byCategory($categoryId);
    }

    public function tags($tags)
    {
        $tags = array_map('trim', explode(',', $tags));

        return $this->builder->byTags($tags);
    }
}
