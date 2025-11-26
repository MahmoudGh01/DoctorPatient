<x-app-layout>

    <div>Dr .  {{$cabinet->name}}</div>
    <div>located at  {{$cabinet->location}}</div>
    <div>Doctor Mail {{$cabinet->doctor->email}}</div>



</x-app-layout>
