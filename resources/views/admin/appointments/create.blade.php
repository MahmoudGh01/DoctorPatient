<x-app-layout title="Create appointment">

    <form action="/admin/appointments" method="POST">
        @csrf

        <!-- Hidden cabinet id -->
        <input type="hidden" name="cabinet_id" value="{{ $cabinet_id }}" />

        <x-form-text name="status" label="Status" placeholder="Pending" />
        <x-form-text name="datetime" label="DateTime" placeholder="01/01/1999" />

        <div class="mt-4">
            <button class="bg-gray-200 p-2" type="submit">Create</button>
        </div>
    </form>

</x-app-layout>
