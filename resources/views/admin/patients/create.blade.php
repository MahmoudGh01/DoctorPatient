<x-app-layout title="Create Patient">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Patient
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-6 py-10">

        <div class="bg-white shadow border border-gray-200 rounded-xl p-8">

            <h3 class="text-xl font-bold text-gray-800 mb-6">Add New Patient</h3>

            <form action="{{ route('admin.patients.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <x-form-text name="name" label="Patient Name" placeholder="John Doe" />

                <x-form-text name="email" type="email" label="Email" placeholder="email@example.com" />

                <x-form-text name="password" type="password" label="Password" placeholder="******" />

                <x-file-upload name="photo" label="Profile Photo" />

                <button class="w-full bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 shadow transition">
                    Create Patient
                </button>
            </form>

        </div>

    </div>

</x-app-layout>
