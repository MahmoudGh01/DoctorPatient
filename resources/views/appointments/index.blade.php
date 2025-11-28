<x-site-layout title="Appointments">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Appointments
        </h2>
    </x-slot>
    {{ $appointments->links() }}

    <div class="max-w-5xl mx-auto mt-8">
        @foreach($appointments as $appointment)
            <a href="/appointments/{{ $appointment->id }}"
               class="block bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-4 hover:shadow-md hover:border-blue-400 transition">

                <div class="flex items-center justify-between">

                    <!-- LEFT SIDE: Doctor & Patient -->
                    <div class="flex items-center space-x-6">

                        <!-- DOCTOR PICTURE -->
                        <img
                            src="{{ $appointment->cabinet->doctor->getImageUrl('preview') ?: 'https://ui-avatars.com/api/?name=' . urlencode($appointment->cabinet->doctor->name) }}"
                            class="h-14 w-14 rounded-full object-cover border"
                        >

                        <div>
                            <p class="text-sm text-gray-500 mb-1">Doctor</p>
                            <p class="text-lg font-semibold text-gray-700">
                                {{ $appointment->cabinet->doctor->name }}
                            </p>
                            <p class="text-sm text-gray-500">{{ $appointment->cabinet->doctor->email }}</p>
                        </div>

                    </div>

                    <!-- MIDDLE: PATIENT -->
                    <div class="flex items-center space-x-4">

                        <!-- PATIENT PICTURE -->
                        <img
                            src="{{ $appointment->patient->getFirstMediaUrl('profile') ?: 'https://ui-avatars.com/api/?name=' . urlencode($appointment->patient->name) }}"
                            class="h-14 w-14 rounded-full object-cover border"
                        >

                        <div>
                            <p class="text-sm text-gray-500 mb-1">Patient</p>
                            <p class="text-lg font-semibold text-gray-700">
                                {{ $appointment->patient->name }}
                            </p>
                            <p class="text-sm text-gray-500">{{ $appointment->patient->email }}</p>
                        </div>

                    </div>

                    <!-- RIGHT SIDE: DATE -->
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Appointment</p>
                        <p class="font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($appointment->datetime)->format('d M Y') }}
                        </p>
                        <p class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($appointment->datetime)->format('H:i') }}
                        </p>

                        <span class="
                            text-xs px-2 py-1 mt-2 inline-block rounded-full text-white
                            {{ $appointment->status === 'scheduled' ? 'bg-blue-500' : '' }}
                            {{ $appointment->status === 'completed' ? 'bg-green-600' : '' }}
                            {{ $appointment->status === 'canceled' ? 'bg-red-600' : '' }}
                        ">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>

                </div>

            </a>
        @endforeach

    </div>

</x-site-layout>
