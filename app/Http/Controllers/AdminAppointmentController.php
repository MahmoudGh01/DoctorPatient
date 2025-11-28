<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminAppointmentController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with([
            'cabinet:id,doctor_id,name',
            'cabinet.doctor:id,name,email',
            'cabinet.doctor.media',
            'patient:id,name,email',
            'patient.media'
        ])->paginate(10);
        return view('admin.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('admin.appointments.create', [
            'cabinet_id' => $request->cabinet_id,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'datetime' => ['required', 'date'],
            'status' => ['required', 'string', 'in:scheduled,completed,cancelled'],
            'cabinet_id' => ['required', 'integer', 'exists:cabinets,id'], // FIXED
        ]);

        Appointment::create($validated + ['patient_id' => auth()->id()]);

        return redirect('/admin/appointments');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::find($id);

        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $appointment = Appointment::find($id);

        return view('admin.appointments.edit', compact('appointment'));
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
        return redirect('/admin/appointments');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::find($id);


        $appointment->delete();

        return redirect('admin.appointments');
    }
}
