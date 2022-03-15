<?php

namespace App\Traits;

use App\Http\Filters\QueryFilter;

trait Filterable
{
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
