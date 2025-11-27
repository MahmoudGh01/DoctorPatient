<x-site-layout>


        <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2
                         2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Appointment Details
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- STATUS --}}
            <div class="bg-gray-50 rounded-lg p-4 border">
                <p class="text-sm text-gray-500">Status</p>
                <p class="text-lg font-semibold mt-1">
                    <span class="
                        px-3 py-1 rounded-full text-white text-sm
                        {{ $appointment->status === 'scheduled' ? 'bg-blue-500' : '' }}
                        {{ $appointment->status === 'completed' ? 'bg-green-600' : '' }}
                        {{ $appointment->status === 'cancelled' ? 'bg-red-600' : '' }}
                    ">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </p>
            </div>

            {{-- DATE & TIME --}}
            <div class="bg-gray-50 rounded-lg p-4 border">
                <p class="text-sm text-gray-500">Appointment Date</p>
                <p class="text-lg font-semibold mt-1 text-gray-700">
                    {{ \Carbon\Carbon::parse($appointment->datetime)->format('l, d M Y - H:i') }}
                </p>
            </div>

        </div>

        <hr class="my-8">

        {{-- PATIENT INFO --}}
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Patient Information</h2>

        <div class="bg-gray-50 rounded-lg p-4 border mb-6">
            <p class="text-sm text-gray-500">Name</p>
            <p class="text-lg font-semibold text-gray-700">{{ $appointment->patient->name }}</p>

            <p class="text-sm text-gray-500 mt-3">Email</p>
            <p class="text-md text-gray-700">{{ $appointment->patient->email }}</p>
        </div>

        {{-- DOCTOR INFO --}}
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Doctor Information</h2>

        <div class="bg-gray-50 rounded-lg p-4 border">
            <p class="text-sm text-gray-500">Doctor Name</p>
            <p class="text-lg font-semibold text-gray-700">{{ $appointment->cabinet->doctor->name }}</p>

            <p class="text-sm text-gray-500 mt-3">Doctor Email</p>
            <p class="text-md text-gray-700">{{ $appointment->cabinet->doctor->email }}</p>

            <p class="text-sm text-gray-500 mt-3">Cabinet</p>
            <p class="text-md text-gray-700">{{ $appointment->cabinet->name }}</p>
        </div>

        {{-- RETURN BUTTON --}}
        <div class="mt-10 text-center">
            <a href="{{ url()->previous() }}"
               class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                Go Back
            </a>
        </div>



</x-site-layout>
