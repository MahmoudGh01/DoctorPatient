<?php

use Livewire\Component;
use App\Models\Cabinet;

new class extends Component {

    public array $cabinets = [];
    public string $search = '';

    public function updatedSearch()
    {
        if (strlen($this->search) < 2) {
            $this->cabinets = [];
            return;
        }

        $this->cabinets = Cabinet::with('doctor')
            ->whereHas('doctor', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->withCount('appointments')
            ->orderByDesc('appointments_count')
            ->take(6)
            ->get()
            ->toArray();
    }

};
?>

<div class="max-w-6xl mx-auto px-4 border border-gray-300 p-6 rounded-xl">

    {{-- SEARCH INPUT --}}
    <input
        wire:model.live="search"
        type="text"
        placeholder="Search doctor name or email..."
        class="border p-3 w-full rounded-lg mb-4"
    />

    {{-- DEBUG (like your example) --}}
    <div class="text-sky-600 mb-4">
        {{ $search }}
    </div>

    {{-- RESULTS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($cabinets as $cabinet)
            <div class="bg-white shadow rounded-xl border p-4">

                {{-- Doctor --}}
                <p class="text-sm text-gray-500">Doctor</p>
                <p class="font-semibold text-gray-800">
                    {{ $cabinet['doctor']['name'] }}
                </p>
                <p class="text-sm text-gray-600">
                    {{ $cabinet['doctor']['email'] }}
                </p>

                {{-- Cabinet --}}
                <h3 class="mt-3 font-bold text-lg">
                    {{ $cabinet['name'] }}
                </h3>

                @if(!empty($cabinet['location']))
                    <p class="text-sm text-gray-600">
                        📍 {{ $cabinet['location'] }}
                    </p>
                @endif

                <span class="inline-block mt-3 bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full">
                    {{ $cabinet['appointments_count'] }} appointments this month
                </span>

            </div>
        @endforeach

    </div>

</div>
