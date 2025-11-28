<x-app-layout title="Appointments">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Appointments
        </h2>
    </x-slot>
    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $appointments->links() }}
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="bg-white shadow-md border border-gray-200 rounded-xl overflow-hidden">

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Doctor
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Patient
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Date & Time
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Status
                    </th>

                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">

                @foreach($appointments as $appointment)
                    <tr class="hover:bg-gray-50">

                        {{-- Doctor --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">

                                <img
                                    src="{{ $appointment->cabinet->doctor->getFirstMediaUrl('profile')
                                                ?: 'https://ui-avatars.com/api/?size=128&name=' . urlencode($appointment->cabinet->doctor->name) }}"
                                    class="w-10 h-10 rounded-full object-cover border"
                                >

                                <div>
                                    <a href="/admin/appointments/{{ $appointment->id }}" class="font-medium text-gray-800 hover:text-blue-600">
                                        Dr. {{ $appointment->cabinet->doctor->name }}
                                    </a>
                                    <p class="text-xs text-gray-500">
                                        {{ $appointment->cabinet->doctor->email }}
                                    </p>
                                </div>

                            </div>
                        </td>

                        {{-- Patient --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">

                                <img
                                    src="{{ $appointment->patient->getFirstMediaUrl('profile')
                                                ?: 'https://ui-avatars.com/api/?size=128&name=' . urlencode($appointment->patient->name) }}"
                                    class="w-10 h-10 rounded-full object-cover border"
                                >

                                <div>
                                    <p class="font-medium text-gray-800">
                                        {{ $appointment->patient->name }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $appointment->patient->email }}</p>
                                </div>

                            </div>
                        </td>

                        {{-- Date & Time --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <p class="font-medium text-gray-700">
                                {{ \Carbon\Carbon::parse($appointment->datetime)->format('d M Y') }}
                            </p>
                            <p class="text-gray-500 text-sm">
                                {{ \Carbon\Carbon::parse($appointment->datetime)->format('H:i') }}
                            </p>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 text-xs rounded-full text-white
                                    @if($appointment->status === 'scheduled') bg-blue-500
                                    @elseif($appointment->status === 'completed') bg-green-600
                                    @else bg-red-600 @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                            <div class="flex items-center justify-end space-x-4">

                                {{-- EDIT --}}
                                <a href="/admin/appointments/{{ $appointment->id }}/edit"
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    Edit
                                </a>

                                {{-- DELETE --}}
                                <form action="/admin/appointments/{{ $appointment->id }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 font-medium">
                                        Delete
                                    </button>
                                </form>

                            </div>

                        </td>

                    </tr>
                @endforeach

                </tbody>

            </table>

        </div>



    </div>

</x-app-layout>
