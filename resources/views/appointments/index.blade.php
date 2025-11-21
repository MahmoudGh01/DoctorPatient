<x-app-layout title="Appointments">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Appointments
        </h2>
    </x-slot>



    <ul>
        @foreach($appointments as $appointment)
            <li class="flex justify-between hover:bg-gray-200">
                <a href="/appointments/{{$appointment->id}}">{{ $appointment->id }}</a>


                <div class="flex gap-x-4">

                    <a href="/appointments/{{$appointment->id}}/edit">EDIT</a>

                    <form action="/appointments/{{$appointment->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>DELETE</button>
                    </form>

                </div>
            </li>
        @endforeach
    </ul>



</x-app-layout>

