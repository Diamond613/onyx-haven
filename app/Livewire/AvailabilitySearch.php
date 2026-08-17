<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Room;

class AvailabilitySearch extends Component
{
    #[Url(as: 'check_in', history: true)]
    public string $check_in = '';

    #[Url(as: 'check_out', history: true)]
    public string $check_out = '';

    #[Url(as: 'guests', history: true)]
    public int $guests = 1;

    public bool $searched = false;
    public array $availableRooms = [];

    public function mount(): void
    {
        // If the guest arrived with search params already in the URL
        // (e.g. navigating back from a room they viewed), restore results
        // immediately instead of showing an empty search box.
        if ($this->check_in !== '' && $this->check_out !== '') {
            $this->runSearch();
        }
    }

    public function updated($property): void
    {
        // Re-run the search live as any field changes, once both dates
        // are present. No "Search" button click required.
        if (in_array($property, ['check_in', 'check_out', 'guests'])) {
            $this->search();
        }
    }

    public function search(): void
    {
        if ($this->check_in === '' || $this->check_out === '') {
            $this->searched = false;
            $this->availableRooms = [];
            return;
        }

        $this->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:10',
        ]);

        $this->runSearch();
    }

    /**
     * Find rooms that are marked available, fit the guest count, and have
     * no overlapping (non-cancelled) booking for the requested date range.
     */
    private function runSearch(): void
    {
        $checkIn = $this->check_in;
        $checkOut = $this->check_out;

        $this->availableRooms = Room::where('is_available', true)
            ->where('capacity', '>=', $this->guests)
            ->whereDoesntHave('bookings', function ($query) use ($checkIn, $checkOut) {
                $query->where('status', '!=', 'cancelled')
                    ->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
            })
            ->get()
            ->toArray();

        $this->searched = true;
    }

    public function render()
    {
        return view('livewire.availability-search');
    }
}