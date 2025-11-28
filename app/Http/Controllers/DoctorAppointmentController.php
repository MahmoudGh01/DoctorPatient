<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorAppointmentController extends Controller
{
    /**
     * Display a listing of the doctor's appointments.
     */
    public function index()
    {
        $doctorId = Auth::user()->cabinet->id;

        $appointments = Appointment::where('cabinet_id', $doctorId)
            ->with([
                'patient.media',
                'cabinet:id,name,location',
            ])
            ->orderBy('datetime', 'asc')
            ->paginate(15);

        return view('doctor.appointments.index', compact('appointments'));
    }

    /**
     * Display a single appointment.
     */
    public function show(string $id)
    {
        $doctorId = Auth::user()->cabinet->id;

        $appointment = Appointment::where('cabinet_id', $doctorId)
            ->with([
                'patient.media',
                'cabinet:id,name,location',
            ])
            ->findOrFail($id);

        return view('doctor.appointments.show', compact('appointment'));
    }

    /**
     * Show form for editing an appointment (status only).
     */
    public function edit(string $id)
    {
        $doctorId = Auth::user()->cabinet->id;;

        $appointment = Appointment::where('cabinet_id', $doctorId)
            ->with(['patient'])
            ->findOrFail($id);

        return view('doctor.appointments.edit', compact('appointment'));
    }

    /**
     * Update an appointment (status only).
     */
    public function update(Request $request, string $id)
    {
        $doctorId = Auth::user()->cabinet->id;;

        $appointment = Appointment::where('cabinet_id', $doctorId)->findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:scheduled,completed,cancelled'],
        ]);

        $appointment->update($validated);

        return redirect()
            ->route('doctor.appointments.index')
            ->with('success', 'Appointment updated!');
    }

    /**
     * Doctors cannot destroy appointments (admin-only).
     */
    public function destroy(string $id)
    {
        return abort(403, 'Not allowed.');
    }
}
