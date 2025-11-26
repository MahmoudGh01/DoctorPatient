<x-app-layout title="Edit {{$appointment->title}}">

    <form action="/admin/appointments/{{$appointment->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-form-text name="status" label="Status" placeholder="Pending" value="{{$appointment->status}}" />

        <x-form-text name="datetime" label="DateTime" placeholder="01/01/1999" value="{{$appointment->datetime}}" />

        <div class="mt-4">
            <button class="bg-gray-200 p-2" type="submit">Update</button>
        </div>
    </form>

</x-app-layout>
