<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Cabinet;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with(['cabinet:id,doctor_id,patient_id,name','cabinet.doctor.media','patient.media'])->get();

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Load cabinet with doctor relationship
        $cabinet = Cabinet::with('doctor')
            ->where('id', $request->cabinet_id)
            ->firstOrFail();

        return view('appointments.create', compact('cabinet'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'datetime' => ['required'],
            'status' => ['required', 'string', 'in:scheduled,completed,cancelled'],
            'cabinet_id' => ['required', 'integer', 'exists:cabinets,id'], // FIXED
        ]);

        Appointment::create($validated + ['patient_id' => auth()->id()]);

        return redirect('/appointments');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::find($id);

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $appointment = Appointment::find($id);

        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $appointment = Appointment::find($id);


        $validated = $request->validate([
            'name' => ['required', 'string', 'min:10', 'max:40'],
            'location' => ['nullable', 'string', 'min:10', 'max:500'],

        ]);




        $appointment->update($validated);

        // add reference to your appointment
        return redirect('/appointments');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::find($id);


        $appointment->delete();

        return redirect('appointments');
    }
}
