<x-app-layout title="Appointment Details">

    <div class="max-w-4xl mx-auto px-6 py-10 space-y-10">

        {{-- APPOINTMENT INFO --}}
        <div class="bg-white border border-gray-200 shadow rounded-xl p-8">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">Appointment Details</h1>

            <div class="space-y-4 text-gray-700">

                <p><strong>Date:</strong>
                    {{ \Carbon\Carbon::parse($appointment->datetime)->format('l, d M Y') }}
                </p>

                <p><strong>Time:</strong>
                    {{ \Carbon\Carbon::parse($appointment->datetime)->format('H:i') }}
                </p>

                <p><strong>Status:</strong>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold text-white
                        @if($appointment->status === 'scheduled') bg-blue-500
                        @elseif($appointment->status === 'completed') bg-green-600
                        @else bg-red-600 @endif">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </p>
            </div>

        </div>



        {{-- PATIENT INFO --}}
        <div class="bg-white border border-gray-200 shadow rounded-xl p-8">

            <h2 class="text-xl font-bold text-gray-800 mb-6">Patient Information</h2>

            <div class="flex items-center gap-6">

                <img
                    src="{{ $appointment->patient->getFirstMediaUrl('profile')
                        ?: 'https://ui-avatars.com/api/?size=200&name=' . urlencode($appointment->patient->name) }}"
                    class="w-24 h-24 rounded-full border object-cover shadow"
                >

                <div>
                    <p class="text-2xl font-semibold text-gray-800">
                        {{ $appointment->patient->name }}
                    </p>
                    <p class="text-gray-600">{{ $appointment->patient->email }}</p>
                </div>

            </div>

        </div>



        {{-- ACTIONS --}}
        <div class="bg-white border border-gray-200 shadow rounded-xl p-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Manage Appointment</h3>

            <div class="flex items-center gap-4">

                <a href="{{ route('doctor.appointments.edit', $appointment->id) }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
                    Edit Status
                </a>

            </div>
        </div>

    </div>

</x-app-layout>
