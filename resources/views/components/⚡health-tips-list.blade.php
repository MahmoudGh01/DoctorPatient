<?php

use Livewire\Component;
use Illuminate\Support\Facades\Http;

new class extends Component {

    public array $tips = [];
    public bool $error = false;

    protected $listeners = [
        'healthTipsFiltersUpdated' => 'fetchTips'
    ];

    public function mount()
    {
        $this->fetchTips();
    }

    public function fetchTips(array $filters = [])
    {
        try {
            $response = Http::get(
                'https://docpat.app/v1/health-tips',
                array_filter($filters)
            );

            if ($response->successful() && $response->json('success')) {
                $this->tips = $response->json('data');
                $this->error = false;
            } else {
                $this->error = true;
            }

        } catch (\Throwable $e) {
            $this->error = true;
        }
    }

};
?>
<div class="space-y-4">

    <h3 class="font-bold text-lg">🩺 Health Tips</h3>

    @if($error)
        <p class="text-sm text-red-500">
            Failed to load health tips.
        </p>
    @endif

    @forelse($tips as $tip)
        <article class="bg-white p-5 rounded-xl shadow border">

            <h4 class="font-semibold text-gray-900 mb-1">
                {{ $tip['title'] }}
            </h4>

            <p class="text-sm text-gray-600 mb-2">
                {{ $tip['description'] }}
            </p>

            <div class="text-xs text-gray-500 flex gap-2">
                <span>{{ $tip['source'] }}</span>
                <span>•</span>
                <span>{{ \Carbon\Carbon::parse($tip['published_at'])->diffForHumans() }}</span>
            </div>

            <a href="{{ $tip['read_more_url'] }}"
               target="_blank"
               class="text-xs text-blue-600 hover:underline mt-2 inline-block">
                Read more →
            </a>

        </article>
    @empty
        <p class="text-gray-500 text-sm">
            No health tips found.
        </p>
    @endforelse

</div>
