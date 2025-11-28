<x-app-layout title="My Appointments">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Appointments
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 py-8">

        <div class="bg-white shadow-md border border-gray-200 rounded-xl overflow-hidden">

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        Patient
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        Date & Time
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        Status
                    </th>

                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase text-gray-600">
                        Actions
                    </th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($appointments as $appointment)
                    <tr class="hover:bg-gray-50">

                        {{-- PATIENT --}}
                        <td class="px-6 py-4 whitespace-nowrap flex items-center gap-3">
                            <img
                                src="{{ $appointment->patient->getFirstMediaUrl('profile')
                                    ?: 'https://ui-avatars.com/api/?name=' . urlencode($appointment->patient->name) }}"
                                class="w-10 h-10 rounded-full object-cover border"
                            >
                            <div>
                                <p class="font-semibold text-gray-800">
                                    {{ $appointment->patient->name }}
                                </p>
                                <p class="text-xs text-gray-500">{{ $appointment->patient->email }}</p>
                            </div>
                        </td>

                        {{-- DATE --}}
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($appointment->datetime)->format('d M Y') }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($appointment->datetime)->format('H:i') }}
                            </p>
                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold text-white
                                @if($appointment->status === 'scheduled') bg-blue-500
                                @elseif($appointment->status === 'completed') bg-green-600
                                @else bg-red-600 @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>

                        {{-- ACTIONS --}}
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('doctor.appointments.show', $appointment->id) }}"
                               class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                View
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            No appointments found.
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>

        <div class="mt-6">
            {{ $appointments->links() }}
        </div>

    </div>

</x-app-layout>
