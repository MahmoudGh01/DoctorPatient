<x-site-layout title="Cabinets">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Cabinets
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">

        @foreach($cabinets as $cabinet)
            <div class="bg-white rounded-xl shadow-md p-5 border border-gray-200 hover:shadow-lg transition">

                <!-- Cabinet Name -->
                <h3 class="text-lg font-semibold text-gray-800 mb-2">
                    <a href="/cabinets/{{$cabinet->id}}" class="hover:text-teal-600 transition">
                        {{ $cabinet->name }}
                    </a>
                </h3>

                <!-- Optional Location -->
                @if($cabinet->location)
                    <p class="text-sm text-gray-600 mb-4">
                        📍 {{ Str::limit($cabinet->location, 60) }}
                    </p>
                @endif

                <!-- Actions -->
                <!-- Make Appointment -->
                <div class="mt-4">
                    <a href="/appointments/create?cabinet_id={{$cabinet->id}}" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700 transition">
                        Make Appointment
                    </a>


            </div>
            </div>
        @endforeach

    </div>

</x-site-layout>
