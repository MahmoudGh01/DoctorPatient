<?php

use Livewire\Component;

new class extends Component {

    public bool $open = false;

    public string $category = '';
    public string $source = '';
    public string $search = '';
    public int $limit = 10;
    public string $order_by = 'published_at';
    public string $order_direction = 'desc';
    public string $published_from = '';
    public string $published_to = '';

    public function mount()
    {
        // Collapse by default on mobile
        $this->open = request()->header('User-Agent')
            ? !str_contains(strtolower(request()->header('User-Agent')), 'mobile')
            : true;
    }

    public function toggle()
    {
        $this->open = ! $this->open;
    }

    public function updated()
    {
        $this->dispatch(
            'healthTipsFiltersUpdated',
            [
                'category'        => $this->category ?: null,
                'source'          => $this->source ?: null,
                'search'          => $this->search ?: null,
                'limit'           => $this->limit ?: null,
                'order_by'        => $this->order_by,
                'order_direction' => $this->order_direction,
                'published_from'  => $this->published_from ?: null,
                'published_to'    => $this->published_to ?: null,
            ]
        );
    }

};
?>
<div class="bg-white rounded-xl shadow border">

    {{-- HEADER (clickable) --}}
    <button
        wire:click="toggle"
        class="w-full flex items-center justify-between p-5 font-semibold text-gray-800 hover:bg-gray-50 rounded-t-xl"
    >
        <span>🔎 Filter Health Tips</span>

        <svg class="w-5 h-5 transition-transform duration-300
            {{ $open ? 'rotate-180' : '' }}"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    {{-- BODY --}}
    @if($open)
        <div class="p-5 space-y-4 border-t">

            <input
                wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="Search..."
                class="border p-2 w-full rounded"
            >

            <input
                wire:model.live="category"
                type="text"
                placeholder="Category (Mental Health, Nutrition...)"
                class="border p-2 w-full rounded"
            >

            <input
                wire:model.live="source"
                type="text"
                placeholder="Source (CDC, Mayo Clinic...)"
                class="border p-2 w-full rounded"
            >

            <div class="grid grid-cols-2 gap-3">
                <input wire:model.live="published_from" type="date" class="border p-2 rounded">
                <input wire:model.live="published_to" type="date" class="border p-2 rounded">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <select wire:model.live="order_by" class="border p-2 rounded">
                    <option value="published_at">Published date</option>
                    <option value="title">Title</option>
                </select>

                <select wire:model.live="order_direction" class="border p-2 rounded">
                    <option value="desc">Desc</option>
                    <option value="asc">Asc</option>
                </select>
            </div>

            <input
                wire:model.live="limit"
                type="number"
                min="1"
                class="border p-2 w-full rounded"
                placeholder="Limit"
            >

        </div>
    @endif

</div>
