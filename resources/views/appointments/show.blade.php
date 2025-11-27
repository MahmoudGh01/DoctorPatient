<x-site-layout>


    <div>Appointment Status:  {{$appointment->status}}</div>
    <div>Appointment DateTime:  {{$appointment->datetime}}</div>
    <div>Patient Name:  {{$appointment->patient->name}}</div>
    <div>Doctor Name:  {{$appointment->cabinet->doctor->name}}</div>
    <div>Doctor Mail:  {{$appointment->cabinet->doctor->email}}</div>




</x-site-layout>
