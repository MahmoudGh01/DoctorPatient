<x-app-layout title="Create cabinet">

    <form action="/cabinets" method="POST">
        @csrf

        <x-form-text name="name" label="Name" placeholder="Dr John Smith" />
        <x-form-text name="location" label="Location" placeholder="123 Lincoln Street" />


        <div class="mt-4">
            <button class="bg-gray-200 p-2" type="submit">Create</button>
        </div>
    </form>

</x-app-layout>
