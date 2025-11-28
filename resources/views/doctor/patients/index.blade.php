<x-app-layout title="My Patients">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Patients
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto px-6 py-8">

        <div class="bg-white shadow border border-gray-200 rounded-xl overflow-hidden">

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        Patient
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600">
                        Email
                    </th>

                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase text-gray-600">
                        Actions
                    </th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($patients as $patient)
                    <tr class="hover:bg-gray-50">

                        {{-- PATIENT --}}
                        <td class="px-6 py-4 flex items-center gap-3">
                            <img
                                src="{{ $patient->getFirstMediaUrl('profile')
                                        ?: 'https://ui-avatars.com/api/?name=' . urlencode($patient->name) }}"
                                class="w-10 h-10 rounded-full border object-cover"
                            >
                            <span class="font-semibold text-gray-800">
                                    {{ $patient->name }}
                                </span>
                        </td>

                        {{-- EMAIL --}}
                        <td class="px-6 py-4 text-gray-700">
                            {{ $patient->email }}
                        </td>

                        {{-- ACTION --}}
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('doctor.patients.show', $patient->id) }}"
                               class="text-blue-600 hover:text-blue-800 font-medium">
                                View
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center px-6 py-8 text-gray-500">
                            No patients found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>

        <div class="mt-6">
            {{ $patients->links() }}
        </div>

    </div>

</x-app-layout>
