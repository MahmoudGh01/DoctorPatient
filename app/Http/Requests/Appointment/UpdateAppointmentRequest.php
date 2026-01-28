<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Admins and doctors can update any appointment
        // Patients can only update their own appointments
        $user = auth()->user();
        if ($user->isAdmin() || $user->isDoctor()) {
            return true;
        }
        
        // For patients, check if they own the appointment
        $appointment = \App\Models\Appointment::find($this->route('id'));
        return $appointment && $appointment->patient_id == $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'datetime' => ['sometimes', 'date'],
            'status' => ['sometimes', 'string', 'in:scheduled,completed,cancelled'],
            'cabinet_id' => ['sometimes', 'integer', 'exists:cabinets,id'],
            'patient_id' => ['sometimes', 'integer', 'exists:users,id'],
        ];
    }
}
