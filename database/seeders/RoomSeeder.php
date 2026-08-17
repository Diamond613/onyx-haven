<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use Illuminate\Support\Str;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'The Onyx Suite',
                'slug' => 'the-onyx-suite',
                'description' => 'Our signature suite draped in dark marble and warm gold accents. Floor-to-ceiling windows reveal a breathtaking panoramic city view.',
                'base_price' => 850.00,
                'price_modifier' => 1.20,
                'capacity' => 2,
                'view_type' => 'city',
                'amenities' => ['King Bed', 'Private Jacuzzi', 'Butler Service', 'Mini Bar', 'Rain Shower', 'Lounge Area'],
                'images' => [
                    ['path' => 'rooms/istockphoto-2184587687-612x612.jpg', 'caption' => 'Bedroom'],
                    ['path' => 'rooms/istockphoto-1284025718-612x612.jpg', 'caption' => 'Bathroom'],
                    ['path' => 'rooms/istockphoto-1084656062-612x612.jpg', 'caption' => 'Bathroom'],
                    ['path' => 'rooms/istockphoto-2168113044-612x612.jpg', 'caption' => 'Dining Area'],
                    ['path' => 'rooms/istockphoto-1082390010-612x612.jpg', 'caption' => 'Lounge'],
                ],
                'is_available' => true,
            ],
            [
                'name' => 'Haven Penthouse',
                'slug' => 'haven-penthouse',
                'description' => 'The pinnacle of luxury. A full-floor penthouse with a private rooftop terrace, plunge pool, and 360-degree views of the skyline.',
                'base_price' => 2500.00,
                'price_modifier' => 1.50,
                'capacity' => 4,
                'view_type' => 'panoramic',
                'amenities' => ['2 King Beds', 'Private Rooftop', 'Plunge Pool', 'Personal Chef', 'Home Cinema', 'Butler Service'],
                'images' => [
                    ['path' => 'rooms/istockphoto-2110310187-612x612.jpg', 'caption' => 'Terrace View'],
                    ['path' => 'rooms/istockphoto-1917539042-612x612.jpg', 'caption' => 'Dining Area'],
                    ['path' => 'rooms/istockphoto-1024173540-612x612.jpg', 'caption' => 'Bathroom'],
                    ['path' => 'rooms/istockphoto-1242215445-612x612.jpg', 'caption' => 'Lounge'],
                    ['path' => 'rooms/istockphoto-2132093423-612x612.jpg', 'caption' => 'Pool'],
                ],
                'is_available' => true,
            ],
            [
                'name' => 'Garden Serenity Room',
                'slug' => 'garden-serenity-room',
                'description' => 'A tranquil retreat overlooking our manicured zen gardens. Soft natural light, earthy tones, and a private terrace for morning meditation.',
                'base_price' => 420.00,
                'price_modifier' => 1.00,
                'capacity' => 2,
                'view_type' => 'garden',
                'amenities' => ['Queen Bed', 'Private Terrace', 'Soaking Tub', 'Nespresso Machine', 'Garden Access'],
                'images' => [
                    ['path' => 'rooms/istockphoto-2262929245-612x612.jpg', 'caption' => 'Bedroom'],
                    ['path' => 'rooms/istockphoto-2250030891-612x612.jpg', 'caption' => 'Bedroom'],
                    ['path' => 'rooms/istockphoto-682989942-612x612.jpg', 'caption' => 'Bedroom'],
                    ['path' => 'rooms/istockphoto-1357529683-612x612.jpg', 'caption' => 'Bathroom'],
                    ['path' => 'rooms/istockphoto-1355094373-612x612.jpg', 'caption' => 'Garden View'],
                ],
                'is_available' => true,
            ],
            [
                'name' => 'Obsidian Deluxe Room',
                'slug' => 'obsidian-deluxe-room',
                'description' => 'Sleek, modern, and meticulously designed. Dark obsidian finishes meet bespoke furnishings in this sophisticated deluxe room.',
                'base_price' => 320.00,
                'price_modifier' => 1.00,
                'capacity' => 2,
                'view_type' => 'city',
                'amenities' => ['King Bed', 'Walk-in Shower', 'Work Desk', 'Smart TV', 'Mini Bar'],
                'images' => [
                    ['path' => 'rooms/istockphoto-2250030746-612x612.jpg', 'caption' => 'Bedroom'],
                    ['path' => 'rooms/istockphoto-2250030867-612x612.jpg', 'caption' => 'Bedroom'],
                    ['path' => 'rooms/istockphoto-1304826235-612x612.jpg', 'caption' => 'Bathroom'],
                    ['path' => 'rooms/istockphoto-468404672-612x612.jpg', 'caption' => 'Dining Area'],
                    ['path' => 'rooms/istockphoto-2168113044-612x612.jpg', 'caption' => 'Lounge'],
                ],
                'is_available' => true,
            ],
            [
                'name' => 'Pearl Ocean Suite',
                'slug' => 'pearl-ocean-suite',
                'description' => 'Wake up to the sound of waves. This suite features a private balcony directly overlooking the ocean with soft pearl and ivory interiors.',
                'base_price' => 980.00,
                'price_modifier' => 1.30,
                'capacity' => 3,
                'view_type' => 'ocean',
                'amenities' => ['King Bed', 'Ocean Balcony', 'Freestanding Bath', 'Sunset Dining Setup', 'Butler Service'],
                'images' => [
                    ['path' => 'rooms/istockphoto-1765363686-612x612.jpg', 'caption' => 'Ocean View'],
                    ['path' => 'rooms/istockphoto-641448082-612x612.jpg', 'caption' => 'Pool'],
                    ['path' => 'rooms/istockphoto-464802594-612x612.jpg', 'caption' => 'Dining Area'],
                    ['path' => 'rooms/istockphoto-1490571634-612x612.jpg', 'caption' => 'Bathroom'],
                    ['path' => 'rooms/istockphoto-903417402-612x612.jpg', 'caption' => 'Resort View'],
                ],
                'is_available' => true,
            ],
            [
                'name' => 'Onyx Estate',
                'slug' => 'onyx-estate',
                'description' => 'An entire private estate for the ultimate gathering. Expansive living spaces, a grand dining hall, and resort-style grounds built for large groups and celebrations.',
                'base_price' => 2400.00,
                'price_modifier' => 1.00,
                'capacity' => 15,
                'view_type' => 'estate',
                'amenities' => ['Multiple Bedrooms', 'Grand Dining Hall', 'Private Pool', 'Event Space', 'Full Staff', 'Terrace Views'],
                'images' => [
                    ['path' => 'rooms/istockphoto-187945130-612x612.jpg', 'caption' => 'Dining Hall'],
                    ['path' => 'rooms/istockphoto-1242215445-612x612.jpg', 'caption' => 'Lounge'],
                    ['path' => 'rooms/istockphoto-1082390010-612x612.jpg', 'caption' => 'Living Room'],
                    ['path' => 'rooms/istockphoto-2132093423-612x612.jpg', 'caption' => 'Pool'],
                    ['path' => 'rooms/istockphoto-2110310187-612x612.jpg', 'caption' => 'Terrace View'],
                ],
                'is_available' => true,
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}