<x-app-layout title="Cabinets">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Cabinets
        </h2>
    </x-slot>



    <ul>
        @foreach($cabinets as $cabinet)
            <li class="flex justify-between hover:bg-gray-200">
                <a href="/cabinets/{{$cabinet->id}}">{{ $cabinet->name }}</a>


                <div class="flex gap-x-4">

                    <a href="/cabinets/{{$cabinet->id}}/edit">EDIT</a>

                    <form action="/cabinets/{{$cabinet->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>DELETE</button>
                    </form>

                </div>
            </li>
        @endforeach
    </ul>



</x-app-layout>

