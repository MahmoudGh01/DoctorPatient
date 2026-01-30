<?php

use Livewire\Component;
use Illuminate\Support\Facades\Http;

new class extends Component {

    public ?array $tip = null;
    public bool $error = false;

    public function mount()
    {
        $this->loadTip();
    }

    public function loadTip()
    {
        try {
            $response = Http::get(
                'https://docpat.app/v1/health-tips/random',
                []
            );

            if ($response->successful() && $response->json('success')) {
                $this->tip = $response->json('data') ?? null;
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
<div class="bg-white rounded-lg border shadow-sm p-4">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-2">
        <h3 class="text-sm font-semibold text-gray-800">
            💡 Health Tip
        </h3>

        @if($tip)
            <span class="text-[10px] bg-teal-100 text-teal-700 px-2 py-0.5 rounded-full">
                {{ $tip['category'] }}
            </span>
        @endif
    </div>

    {{-- ERROR --}}
    @if($error)
        <p class="text-xs text-red-500">
            Failed to load health tip.
        </p>
    @endif

    {{-- EMPTY --}}
    @if(!$error && !$tip)
        <p class="text-xs text-gray-500">
            No health tip available.
        </p>
    @endif

    {{-- TIP --}}
    @if($tip)
        <article class="space-y-2">

            {{-- TITLE --}}
            <h4 class="text-sm font-medium text-gray-900 leading-snug line-clamp-2">
                {{ $tip['title'] }}
            </h4>

            {{-- DESCRIPTION --}}
            <p class="text-xs text-gray-600 line-clamp-3">
                {{ $tip['description'] }}
            </p>

            {{-- META --}}
            <div class="flex items-center justify-between text-[11px] text-gray-500">

                <span>
                    {{ $tip['source'] }}
                </span>

                <span>
                    {{ \Carbon\Carbon::parse($tip['published_at'])->diffForHumans() }}
                </span>

            </div>

            {{-- LINK --}}
            <a href="{{ $tip['read_more_url'] }}"
               target="_blank"
               class="inline-block text-xs font-medium text-blue-600 hover:underline">
                Read more →
            </a>

        </article>
    @endif

</div>
