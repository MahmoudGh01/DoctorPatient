<x-site-layout title="Cabinets">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Cabinets
        </h2>
    </x-slot>
    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $cabinets->links() }}
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">

        @foreach($cabinets as $cabinet)

            <div class="bg-white rounded-xl shadow-md border border-gray-200 p-5 hover:shadow-lg transition">

                {{-- Doctor Photo --}}
                <div class="flex items-center mb-4">
                    <img
                        src="{{ $cabinet->doctor->getFirstMediaUrl('profile')
                              ?: 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($cabinet->doctor->name) }}"
                        class="h-16 w-16 rounded-full object-cover border shadow-sm"
                        alt="Doctor Photo"
                    >

                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Doctor</p>
                        <p class="font-semibold text-gray-800 text-lg">
                            {{ $cabinet->doctor->name }}
                        </p>
                        <p class="text-sm text-gray-600">
                            {{ $cabinet->doctor->email }}
                        </p>
                    </div>
                </div>

                {{-- Cabinet Name --}}
                <h3 class="text-lg font-semibold text-gray-800">
                    <a href="/cabinets/{{ $cabinet->id }}" class="hover:text-teal-600 transition">
                        {{ $cabinet->name }}
                    </a>
                </h3>

                {{-- Cabinet Location --}}
                @if($cabinet->location)
                    <p class="text-sm text-gray-600 mt-2">
                        📍 {{ Str::limit($cabinet->location, 70) }}
                    </p>
                @endif

                {{-- Actions --}}
                <div class="mt-5 pt-4 border-t">
                    <a href="/appointments/create?cabinet_id={{ $cabinet->id }}"
                       class="inline-block w-full bg-teal-600 text-center text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition">
                        Make Appointment
                    </a>
                </div>

            </div>

        @endforeach

    </div>

</x-site-layout>
