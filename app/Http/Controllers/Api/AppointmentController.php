<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\StoreAppointmentRequest;
use App\Http\Requests\Appointment\UpdateAppointmentRequest;
use App\Http\Resources\Appointment\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $query = Appointment::with(['patient', 'cabinet', 'cabinet.doctor']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filter by patient
        if ($request->has('patient_id')) {
            $query->where('patient_id', $request->get('patient_id'));
        }

        // Filter by cabinet
        if ($request->has('cabinet_id')) {
            $query->where('cabinet_id', $request->get('cabinet_id'));
        }

        // Date range filter
        if ($request->has('date_from')) {
            $query->where('datetime', '>=', $request->get('date_from'));
        }
        if ($request->has('date_to')) {
            $query->where('datetime', '<=', $request->get('date_to'));
        }

        // Sorting
        $allowedSortFields = ['id', 'status', 'datetime', 'patient_id', 'cabinet_id', 'created_at', 'updated_at'];
        $sortBy = $request->get('sort', 'datetime');
        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'datetime';
        
        $direction = $request->get('direction', 'asc');
        $direction = in_array(strtolower($direction), ['asc', 'desc']) ? $direction : 'asc';
        
        $query->orderBy($sortBy, $direction);

        $appointments = $query->paginate($perPage);

        return AppointmentResource::collection($appointments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $validated = $request->validated();
        
        // If patient_id is not provided, use authenticated user
        if (!isset($validated['patient_id'])) {
            $validated['patient_id'] = auth()->id();
        }

        $appointment = Appointment::create($validated);
        $appointment->load(['patient', 'cabinet']);

        return new AppointmentResource($appointment);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::with(['patient', 'cabinet', 'cabinet.doctor'])
            ->findOrFail($id);
        
        return new AppointmentResource($appointment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $validated = $request->validated();

        $appointment->update($validated);
        $appointment->load(['patient', 'cabinet']);

        return new AppointmentResource($appointment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return response()->json(null, 204);
    }
}
