<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function scopeByName($query, $name)
    {
        return $query->where('name', 'LIKE', "%{$name}%");
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }
}
