<x-app-layout title="Cabinets">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Cabinets
        </h2>
    </x-slot>
    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $cabinets->links() }}
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
                        Cabinet
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Location
                    </th>

                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($cabinets as $cabinet)
                    <tr class="hover:bg-gray-50">

                        {{-- DOCTOR --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">

                                <img
                                    src="{{ $cabinet->doctor->getFirstMediaUrl('profile')
                                        ?: 'https://ui-avatars.com/api/?size=128&name=' . urlencode($cabinet->doctor->name) }}"
                                    class="w-10 h-10 rounded-full object-cover border"
                                >

                                <div>
                                    <p class="font-medium text-gray-800">
                                        Dr. {{ $cabinet->doctor->name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $cabinet->doctor->email }}
                                    </p>
                                </div>

                            </div>
                        </td>

                        {{-- CABINET NAME --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="/admin/cabinets/{{ $cabinet->id }}"
                               class="text-gray-800 font-semibold hover:text-teal-600">
                                {{ $cabinet->name }}
                            </a>
                        </td>

                        {{-- CABINET LOCATION --}}
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                            {{ Str::limit($cabinet->location, 40) }}
                        </td>

                        {{-- ACTIONS --}}
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-4">

                                {{-- EDIT --}}
                                <a href="/admin/cabinets/{{ $cabinet->id }}/edit"
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    Edit
                                </a>

                                {{-- DELETE --}}
                                <form action="/admin/cabinets/{{ $cabinet->id }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure?');">
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
