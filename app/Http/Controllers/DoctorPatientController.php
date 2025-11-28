<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorPatientController extends Controller
{
    /**
     * Display a listing of the doctor's patients.
     */
    public function index()
    {
        $doctorId = Auth::user()->cabinet->id;

        // Get unique patients who had an appointment with the doctor
        $patients = User::where('role', 'patient')
            ->whereHas('appointments', function ($query) use ($doctorId) {
                $query->where('cabinet_id', $doctorId);
            })
            ->with('media')
            ->orderBy('name')
            ->paginate(20);

        return view('doctor.patients.index', compact('patients'));
    }

    /**
     * Display a single patient and their appointments with this doctor.
     */
    public function show(string $id)
    {
        $doctorId = Auth::user()->cabinet->id;;

        // Ensure the patient belongs to this doctor
        $patient = User::where('role', 'patient')
            ->whereHas('appointments', function ($query) use ($doctorId) {
                $query->where('cabinet_id', $doctorId);
            })
            ->with(['media'])
            ->findOrFail($id);

        // Load only the appointments between this doctor and this patient
        $appointments = $patient->appointments()
            ->where('cabinet_id', $doctorId)
            ->with(['cabinet', 'cabinet.doctor.media'])
            ->orderBy('datetime', 'desc')
            ->get();

        return view('doctor.patients.show', compact('patient', 'appointments'));
    }

}
