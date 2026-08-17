<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_price',
        'price_modifier',
        'capacity',
        'view_type',
        'amenities',
        'images',
        'is_available',
    ];

    protected $casts = [
        'amenities' => 'array',
        'images' => 'array',
        'is_available' => 'boolean',
        'base_price' => 'decimal:2',
        'price_modifier' => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getFinalPriceAttribute()
    {
        return $this->base_price * $this->price_modifier;
    }

    /**
     * The first image in the gallery, used as the cover/thumbnail.
     * Returns null if the room has no images yet.
     */
    public function getCoverImageAttribute()
    {
        return $this->images[0]['path'] ?? null;
    }
}