<x-app-layout title="Edit Patient">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Patient
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-6 py-10">

        <div class="bg-white shadow border border-gray-200 rounded-xl p-8">

            <h3 class="text-xl font-bold text-gray-800 mb-6">Edit Patient Information</h3>

            <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <x-form-text name="name" label="Patient Name" value="{{ $patient->name }}" />

                <x-form-text name="email" type="email" label="Email" value="{{ $patient->email }}" />

                <x-form-text name="password" type="password" label="Password (leave empty to keep current)" />

                {{-- Current photo preview --}}
                <div>
                    <p class="text-sm font-semibold text-gray-700 mb-1">Current Photo</p>
                    <img
                        src="{{ $patient->getFirstMediaUrl('profile')
                            ?: 'https://ui-avatars.com/api/?name=' . urlencode($patient->name) }}"
                        class="w-20 h-20 rounded-full border object-cover"
                    >
                </div>

                <x-file-upload name="photo" label="New Profile Photo" />

                <button class="w-full bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 shadow transition">
                    Update Patient
                </button>
            </form>

        </div>

    </div>

</x-app-layout>
