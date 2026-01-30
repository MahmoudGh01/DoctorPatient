<?php

use Livewire\Component;

new class extends Component
{
    public array $articles = [];

    public bool $error = false;

    public function mount()
    {
        try {
            $response = Http::timeout(5)->get(
                'https://newsapi.org/v2/top-headlines',
                [
                    'country'  => 'us',
                    'category' => 'health',
                    'apiKey'   => config('services.news_api.key'),
                ]
            );

            if ($response->successful()) {
                $this->articles = $response->json('articles') ?? [];
            } else {
                $this->error = true;
            }

        } catch (\Exception $e) {
            $this->error = true;
        }
    }

};
?>
<div class="space-y-5">
    @foreach($articles as $article)

        <article class="border-b border-gray-100 pb-5 last:border-none">

            <a href="{{ $article['url'] }}"
               target="_blank"
               class="flex gap-4 items-start hover:bg-gray-50 rounded-xl p-3 -m-3 transition">

                {{-- IMAGE (LEFT) --}}
                <div class="flex-shrink-0">
                    @if(!empty($article['urlToImage']))
                        <img
                            src="{{ $article['urlToImage'] }}"
                            alt="{{ $article['title'] }}"
                            class="w-24 h-24 object-cover rounded-lg shadow-sm bg-gray-100"
                            onerror="this.src='https://picsum.photos/seed/medical-{{ $loop->index }}/120/120.jpg'"
                        >
                    @else
                        <div class="w-24 h-24 rounded-lg bg-gradient-to-br from-teal-100 to-blue-100 flex items-center justify-center">
                            <svg class="w-10 h-10 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- CONTENT (RIGHT) --}}
                <div class="flex-1 min-w-0">

                    {{-- TITLE --}}
                    <h4 class="text-sm font-semibold text-gray-900 leading-snug mb-2 line-clamp-3">
                        {{ $article['title'] }}
                    </h4>

                    {{-- SOURCE + DATE --}}
                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                        <span class="font-medium text-gray-700">
                            {{ $article['source']['name'] ?? 'Unknown source' }}
                        </span>
                        <span>•</span>
                        <span>
                            {{ \Carbon\Carbon::parse($article['publishedAt'])->diffForHumans() }}
                        </span>
                    </div>

                    {{-- DESCRIPTION --}}
                    @if(!empty($article['description']))
                        <p class="text-xs text-gray-600 leading-relaxed line-clamp-2">
                            {{ $article['description'] }}
                        </p>
                    @endif

                </div>

            </a>

        </article>

    @endforeach
</div>
