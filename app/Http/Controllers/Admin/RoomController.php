<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Maximum number of gallery images allowed per room.
     */
    const MAX_IMAGES = 5;

    public function index()
    {
        $rooms = Room::latest()->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'base_price' => 'required|numeric|min:0',
            'price_modifier' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'view_type' => 'required|string',
            'amenities' => 'required|string',
            'images' => 'nullable|array|max:' . self::MAX_IMAGES,
            'images.*' => 'nullable|image|max:4096',
            'image_captions' => 'nullable|array',
            'image_captions.*' => 'nullable|string|max:100',
        ]);

        $data['slug'] = $this->generateUniqueSlug($data['name']);
        $data['amenities'] = array_map('trim', explode(',', $data['amenities']));
        $data['is_available'] = $request->has('is_available');

        $data['images'] = $this->uploadImages($request);

        unset($data['image_captions']);

        Room::create($data);

        return redirect('/admin/rooms')->with('success', 'Room created successfully!');
    }

    /**
     * Generate a slug from the given name, appending a numeric suffix
     * (e.g. "-2", "-3") if the base slug is already taken.
     */
    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $suffix = 2;

        while (
            Room::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'base_price' => 'required|numeric|min:0',
            'price_modifier' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'view_type' => 'required|string',
            'amenities' => 'required|string',
            'is_available' => 'nullable',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|max:4096',
            'image_captions' => 'nullable|array',
            'image_captions.*' => 'nullable|string|max:100',
            'removed_images' => 'nullable|array',
            'removed_images.*' => 'nullable|string',
        ]);

        $data['slug'] = $this->generateUniqueSlug($data['name'], $room->id);
        $data['amenities'] = array_map('trim', explode(',', $data['amenities']));
        $data['is_available'] = $request->has('is_available');

        // Start from the room's existing gallery, then remove anything the admin deleted.
        $existingImages = $room->images ?? [];
        $removedPaths = $request->input('removed_images', []);

        if (!empty($removedPaths)) {
            foreach ($removedPaths as $path) {
                Storage::disk('public')->delete($path);
            }
            $existingImages = array_values(array_filter(
                $existingImages,
                fn($img) => !in_array($img['path'], $removedPaths)
            ));
        }

        // Add any newly uploaded images, respecting the overall cap.
        $remainingSlots = self::MAX_IMAGES - count($existingImages);
        $newImages = $remainingSlots > 0 ? $this->uploadImages($request, $remainingSlots) : [];

        $data['images'] = array_merge($existingImages, $newImages);

        unset($data['image_captions'], $data['removed_images']);

        $room->update($data);

        return redirect('/admin/rooms')->with('success', 'Room updated successfully!');
    }

    public function destroy(Room $room)
    {
        foreach ($room->images ?? [] as $image) {
            Storage::disk('public')->delete($image['path']);
        }

        $room->delete();
        return redirect('/admin/rooms')->with('success', 'Room deleted!');
    }

    /**
     * Handle uploaded image files + their captions, storing them on the
     * public disk under rooms/ and returning the array structure we
     * persist in the room's `images` JSON column.
     */
    private function uploadImages(Request $request, ?int $limit = null): array
    {
        if (!$request->hasFile('images')) {
            return [];
        }

        $files = $request->file('images');
        $captions = $request->input('image_captions', []);
        $limit = $limit ?? self::MAX_IMAGES;

        $images = [];

        foreach (array_slice($files, 0, $limit) as $index => $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }

            $path = $file->store('rooms', 'public');

            $images[] = [
                'path' => $path,
                'caption' => trim($captions[$index] ?? ''),
            ];
        }

        return $images;
    }
}
