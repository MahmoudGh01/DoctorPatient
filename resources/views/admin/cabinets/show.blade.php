<x-app-layout title="Cabinet Details">

    <div class="max-w-6xl mx-auto px-6 py-10 space-y-10">

        {{-- PAGE TITLE --}}
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Cabinet: {{ $cabinet->name }}
            </h1>
            <p class="text-gray-600">Overview of doctor and scheduled appointments</p>
        </div>



        {{-- DOCTOR & CABINET INFO --}}
        <div class="bg-white border border-gray-200 shadow rounded-xl p-8">

            <div class="flex flex-col md:flex-row md:items-center gap-8">

                {{-- Doctor Photo --}}
                <img
                    src="{{ $cabinet->doctor->getFirstMediaUrl('profile')
                        ?: 'https://ui-avatars.com/api/?size=200&name=' . urlencode($cabinet->doctor->name) }}"
                    class="w-36 h-36 rounded-full object-cover shadow border"
                >

                {{-- Doctor Details --}}
                <div class="flex-1">

                    <h2 class="text-2xl font-bold text-gray-800">
                        Dr. {{ $cabinet->doctor->name }}
                    </h2>

                    <p class="text-gray-600">{{ $cabinet->doctor->email }}</p>

                    @if($cabinet->doctor->specialty ?? false)
                        <p class="mt-2 inline-block bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-sm">
                            🩺 {{ $cabinet->doctor->specialty }}
                        </p>
                    @endif

                    <div class="mt-6 space-y-2 text-gray-700">
                        <p><strong>Cabinet:</strong> {{ $cabinet->name }}</p>
                        <p><strong>Location:</strong> {{ $cabinet->location }}</p>
                        <p><strong>Doctor since:</strong> {{ $cabinet->doctor->created_at->format('d M Y') }}</p>
                    </div>

                </div>

            </div>

        </div>



        {{-- APPOINTMENTS LIST --}}
        <div class="bg-white border border-gray-200 shadow rounded-xl p-8">

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    Appointments
                </h2>

                <span class="text-sm text-gray-500">
                    {{ $cabinet->appointments->count() }} total
                </span>
            </div>

            @if($cabinet->appointments->isEmpty())
                <p class="text-gray-500 italic">No appointments for this cabinet.</p>
            @else

                <div class="divide-y divide-gray-200">

                    @foreach($cabinet->appointments as $appointment)
                        <div class="py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                            {{-- LEFT: Patient Info --}}
                            <div class="flex items-center gap-4">

                                {{-- Patient Photo --}}
                                <img
                                    src="{{ $appointment->patient->getFirstMediaUrl('profile')
                                        ?: 'https://ui-avatars.com/api/?size=120&name=' . urlencode($appointment->patient->name) }}"
                                    class="w-12 h-12 rounded-full border object-cover"
                                >

                                {{-- Patient Name --}}
                                <div>
                                    <p class="font-semibold text-gray-800">
                                        {{ $appointment->patient->name }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        {{ $appointment->patient->email }}
                                    </p>
                                </div>

                            </div>

                            {{-- MIDDLE: Date --}}
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

                                {{-- Status Badge --}}
                                <span class="px-3 py-1 rounded-full text-xs font-semibold text-white
                                    @if($appointment->status === 'scheduled') bg-blue-500
                                    @elseif($appointment->status === 'completed') bg-green-600
                                    @else bg-red-600 @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>

                                <a href="{{ route('admin.appointments.show', $appointment->id) }}"
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
