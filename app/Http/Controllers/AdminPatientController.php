<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AdminPatientController extends Controller
{
    /**
     * Display a listing of the patients.
     */
    public function index()
    {
        $patients = User::where('role', 'patient')
            ->with(['media'])
            ->orderBy('name')
            ->paginate(15);

        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new patient.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created patient in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'photo'    => ['nullable', 'image', 'max:2048'],
        ]);

        $patient = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'patient',
        ]);

        if ($request->hasFile('photo')) {
            $patient->addMediaFromRequest('photo')->toMediaCollection('profile');
        }

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient created successfully.');
    }

    /**
     * Display the specified patient.
     */
    public function show(string $id)
    {
        $patient = User::where('role', 'patient')
            ->with([

                'media',
                'appointments.cabinet.doctor.media',
            ])
            ->findOrFail($id);

        return view('admin.patients.show', compact('patient'));
    }


    /**
     * Show the form for editing the specified patient.
     */
    public function edit(string $id)
    {
        $patient = User::where('role', 'patient')
            ->with('media')
            ->findOrFail($id);

        return view('admin.patients.edit', compact('patient'));
    }

    /**
     * Update the specified patient in storage.
     */
    public function update(Request $request, string $id)
    {
        $patient = User::where('role', 'patient')->findOrFail($id);

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', Rule::unique('users')->ignore($patient->id)],
            'password' => ['nullable', 'min:6'],
            'photo'    => ['nullable', 'image', 'max:2048'],
        ]);

        $patient->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (!empty($validated['password'])) {
            $patient->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        if ($request->hasFile('photo')) {
            $patient->clearMediaCollection('profile');
            $patient->addMediaFromRequest('photo')->toMediaCollection('profile');
        }

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified patient from storage.
     */
    public function destroy(string $id)
    {
        $patient = User::where('role', 'patient')->findOrFail($id);

        $patient->clearMediaCollection('profile');
        $patient->delete();

        return redirect()->route('admin.patients.index')
            ->with('success', 'Patient deleted successfully.');
    }
}
