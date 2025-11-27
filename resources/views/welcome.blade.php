    <x-site-layout title="Welcome">

        {{-- HERO SECTION --}}
        <section class="bg-gradient-to-r from-teal-600 to-blue-600 text-white py-20 mb-10">
            <div class="max-w-5xl mx-auto text-center px-4">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4">
                    Welcome to Your Medical Appointment System
                </h1>
                <p class="text-lg md:text-xl text-teal-100">
                    Find top-rated doctors, explore trusted medical cabinets, and book your appointment in seconds.
                </p>
            </div>
        </section>

        {{-- POPULAR CABINETS SECTION --}}
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                ⭐ Most Popular Cabinets
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                @foreach($popularCabinets as $cabinet)
                    <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden hover:shadow-xl transition">

                        {{-- Doctor Picture --}}
                        <div class="p-5 flex items-center">
                            <img
                                src="{{ $cabinet->doctor->getFirstMediaUrl('profile')
                                ?: 'https://ui-avatars.com/api/?size=128&name=' . urlencode($cabinet->doctor->name) }}"
                                class="h-20 w-20 rounded-full object-cover border shadow-sm"
                            >

                            <div class="ml-4">
                                <p class="text-gray-500 text-sm">Doctor</p>
                                <p class="text-lg font-semibold text-gray-800">
                                    {{ $cabinet->doctor->name }}
                                </p>
                                <p class="text-sm text-gray-600">{{ $cabinet->doctor->email }}</p>
                            </div>
                        </div>

                        {{-- Cabinet Content --}}
                        <div class="px-5 pb-5">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                {{ $cabinet->name }}
                            </h3>

                            @if($cabinet->location)
                                <p class="text-gray-600 text-sm mb-4">
                                    📍 {{ Str::limit($cabinet->location, 70) }}
                                </p>
                            @endif

                            {{-- Popularity Badge --}}
                            <span class="inline-block bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full mb-4">
                            {{ $cabinet->appointments_count }} appointments this month
                        </span>

                            {{-- Buttons --}}
                            <div class="flex justify-between mt-4">
                                <a href="/cabinets/{{ $cabinet->id }}"
                                   class="text-blue-600 font-medium hover:underline">
                                    View Cabinet
                                </a>

                                <a href="/appointments/create?cabinet_id={{ $cabinet->id }}"
                                   class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition">
                                    Book Now
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>

    </x-site-layout>


