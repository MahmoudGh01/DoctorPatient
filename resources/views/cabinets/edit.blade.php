<x-app-layout title="Edit {{$cabinet->title}}">

    <form action="/cabinets/{{$cabinet->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-form-text name="name" label="Name" placeholder="Dr Steven Strange" value="{{$cabinet->name}}" />
        <x-form-text name="location" label="Location" placeholder="123 Baker Street , New York" value="{{$cabinet->location}}" />

        <div class="mt-4">
            <button class="bg-gray-200 p-2" type="submit">Update</button>
        </div>
    </form>

</x-app-layout>
