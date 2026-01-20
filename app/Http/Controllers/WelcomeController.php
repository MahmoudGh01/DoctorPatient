<?php

namespace App\Http\Controllers;

use App\Models\Cabinet;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    function __invoke()
    {
        $popularCabinets = cache()->remember(
            'welcome_page_popular_cabinets',
            now()->addMinutes(config('app.cache_ttl')),
            function () {
                return Cabinet::query()
                    ->with([
                        'doctor:id,name,email',
                        'doctor.media'
                    ])
                    ->withCount('appointments')
                    ->orderByDesc('appointments_count')
                    ->take(6)
                    ->first(); // 🔥 FIX
            }
        );



        return view('welcome', compact('popularCabinets'));



    }
}
