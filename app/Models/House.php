<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    /** @use HasFactory<\Database\Factories\HouseFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'address',
        'price',
        'bedrooms_count',
        'space',
        'description',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
