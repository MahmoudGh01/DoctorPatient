<x-app-layout title="Create appointment">

    <form action="/appointments" method="POST">
        @csrf

        <x-form-text name="status" label="Status" placeholder="Pending" />
        <x-form-text name="datetime" label="DateTime" placeholder="01/01/1999" />


        <div class="mt-4">
            <button class="bg-gray-200 p-2" type="submit">Create</button>
        </div>
    </form>

</x-app-layout>
