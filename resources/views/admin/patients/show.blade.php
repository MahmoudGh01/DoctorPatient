<x-app-layout title="Patient Details">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Patient Details
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-6 py-10 space-y-8">

        {{-- PATIENT CARD --}}
        <div class="bg-white shadow border border-gray-200 rounded-xl p-8">

            <div class="flex items-center space-x-6 mb-6">

                <img
                    src="{{ $patient->getFirstMediaUrl('profile')
                        ?: 'https://ui-avatars.com/api/?size=200&name=' . urlencode($patient->name) }}"
                    class="w-28 h-28 rounded-full border object-cover shadow"
                >

                <div>
                    <h3 class="text-3xl font-bold text-gray-800">
                        {{ $patient->name }}
                    </h3>
                    <p class="text-gray-600">{{ $patient->email }}</p>
                </div>

            </div>

            <div class="border-t border-gray-200 pt-6 space-y-2">
                <p class="text-gray-700"><strong>Role:</strong> Patient</p>
                <p class="text-gray-700"><strong>Registered:</strong> {{ $patient->created_at->format('d M Y') }}</p>
            </div>

        </div>

        {{-- PATIENT APPOINTMENTS --}}
        <div class="bg-white shadow border border-gray-200 rounded-xl p-8">

            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-800">
                    Appointments
                </h3>
                {{-- optional: count --}}
                <span class="text-sm text-gray-500">
                    {{ $patient->appointments->count() }} total
                </span>
            </div>

            @if($patient->appointments->isEmpty())
                <p class="text-gray-500 italic">This patient has no appointments yet.</p>
            @else
                <div class="divide-y divide-gray-200">

                    @foreach($patient->appointments as $appointment)
                        <div class="py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                            {{-- LEFT: Doctor & Cabinet --}}
                            <div class="flex items-center gap-4">
                                <img
                                    src="{{ $appointment->cabinet->doctor->getFirstMediaUrl('profile')
                                        ?: 'https://ui-avatars.com/api/?size=120&name=' . urlencode($appointment->cabinet->doctor->name) }}"
                                    class="w-12 h-12 rounded-full object-cover border"
                                >

                                <div>
                                    <p class="font-semibold text-gray-800">
                                        Dr. {{ $appointment->cabinet->doctor->name }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        {{ $appointment->cabinet->name }}
                                    </p>
                                    @if($appointment->cabinet->location)
                                        <p class="text-xs text-gray-500">
                                            📍 {{ Str::limit($appointment->cabinet->location, 50) }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- MIDDLE: Date & Time --}}
                            <div class="text-sm text-gray-700">
                                <p class="font-semibold">
                                    {{ \Carbon\Carbon::parse($appointment->datetime)->format('d M Y') }}
                                </p>
                                <p class="text-gray-500">
                                    {{ \Carbon\Carbon::parse($appointment->datetime)->format('H:i') }}
                                </p>
                            </div>

                            {{-- RIGHT: Status + Link --}}
                            <div class="flex flex-col items-start md:items-end gap-2">

                                <span class="px-3 py-1 rounded-full text-xs font-semibold text-white
                                    @if($appointment->status === 'scheduled') bg-blue-500
                                    @elseif($appointment->status === 'completed') bg-green-600
                                    @else bg-red-600 @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>

                                <a href="{{ route('admin.appointments.show', $appointment->id ?? $appointment->id) }}"
                                   class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    View appointment
                                </a>
                            </div>

                        </div>
                    @endforeach

                </div>
            @endif

        </div>

    </div>

</x-app-layout>
