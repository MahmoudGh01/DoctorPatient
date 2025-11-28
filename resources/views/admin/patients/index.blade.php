<x-app-layout title="Patients">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Patients
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 py-8">

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">All Patients</h3>

            <a href="{{ route('admin.patients.create') }}"
               class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition shadow">
                + Add Patient
            </a>
        </div>

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

                @foreach($patients as $patient)
                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4 flex items-center space-x-3">
                            <img
                                src="{{ $patient->getFirstMediaUrl('profile')
                                        ?: 'https://ui-avatars.com/api/?name=' . urlencode($patient->name) }}"
                                class="w-10 h-10 rounded-full border object-cover"
                            >
                            <a href="{{ route('admin.patients.show', $patient->id) }}"
                               class="font-semibold text-gray-800 hover:text-blue-600">
                                {{ $patient->name }}
                            </a>
                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            {{ $patient->email }}
                        </td>

                        <td class="px-6 py-4 text-right space-x-4">

                            <a href="{{ route('admin.patients.edit', $patient->id) }}"
                               class="text-blue-600 hover:text-blue-800">
                                Edit
                            </a>

                            <form action="{{ route('admin.patients.destroy', $patient->id) }}"
                                  method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Delete this patient?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800">
                                    Delete
                                </button>
                            </form>

                        </td>

                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>

        <div class="mt-6">
            {{ $patients->links() }}
        </div>
    </div>

</x-app-layout>
