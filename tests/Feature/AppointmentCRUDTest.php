<?php

use App\Models\Appointment;
use App\Models\Cabinet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('appointments index requires authentication', function () {
    $response = $this->get('/appointments');

    $response->assertRedirect('/login');
});

test('patients can view their appointments', function () {
    $patient = User::factory()->patient()->create();
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $this->actingAs($patient);

    Appointment::factory()->count(3)->create([
        'patient_id' => $patient->id,
        'cabinet_id' => $cabinet->id,
    ]);

    $response = $this->get('/appointments');

    $response->assertStatus(200);
    $response->assertViewIs('appointments.index');
});

test('doctors can view appointments related to their cabinet', function () {
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $otherDoctor = User::factory()->doctor()->create();
    $otherCabinet = Cabinet::factory()->create(['doctor_id' => $otherDoctor->id]);
    $patient = User::factory()->patient()->create();
    $this->actingAs($doctor);

    Appointment::factory()->count(2)->create([
        'cabinet_id' => $cabinet->id,
        'patient_id' => $patient->id,
    ]);
    Appointment::factory()->count(1)->create([
        'cabinet_id' => $otherCabinet->id,
        'patient_id' => $patient->id,
    ]); // Different cabinet

    $response = $this->get('/appointments');

    $response->assertStatus(200);
    $response->assertViewIs('appointments.index');
});

test('admins can view all appointments', function () {
    $admin = User::factory()->admin()->create();
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $patient = User::factory()->patient()->create();
    $this->actingAs($admin);

    Appointment::factory()->count(5)->create([
        'cabinet_id' => $cabinet->id,
        'patient_id' => $patient->id,
    ]);

    $response = $this->get('/appointments');

    $response->assertStatus(200);
    $response->assertViewIs('appointments.index');
});

test('patients can create appointments for themselves', function () {
    $patient = User::factory()->patient()->create();
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $this->actingAs($patient);

    $appointmentData = [
        'datetime' => now()->addDays(1)->toDateTimeString(),
        'cabinet_id' => $cabinet->id,
    ];

    $response = $this->post('/appointments', $appointmentData);

    $response->assertRedirect('/appointments');
    $this->assertDatabaseHas('appointments', $appointmentData + ['patient_id' => $patient->id]);
});

test('doctors cannot create appointments for patients', function () {
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $this->actingAs($doctor);

    $appointmentData = [
        'datetime' => now()->addDays(1)->toDateTimeString(),
        'cabinet_id' => $cabinet->id,
    ];

    $response = $this->post('/appointments', $appointmentData);

    // Should either redirect or forbidden based on controller logic
    $response->assertStatus(403);
});

test('patients can only view their own appointments', function () {
    $patient1 = User::factory()->patient()->create();
    $patient2 = User::factory()->patient()->create();
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $this->actingAs($patient1);

    $appointment1 = Appointment::factory()->create([
        'patient_id' => $patient1->id,
        'cabinet_id' => $cabinet->id,
    ]);
    $appointment2 = Appointment::factory()->create([
        'patient_id' => $patient2->id,
        'cabinet_id' => $cabinet->id,
    ]);

    // Can view own appointment
    $response = $this->get("/appointments/{$appointment1->id}");
    $response->assertStatus(200);
    $response->assertViewIs('appointments.show');

    // Cannot view other patient's appointment
    $response = $this->get("/appointments/{$appointment2->id}");
    $response->assertStatus(403);
});

test('doctors can view appointments for their cabinet', function () {
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $patient = User::factory()->patient()->create();
    $this->actingAs($doctor);

    $appointment = Appointment::factory()->create([
        'cabinet_id' => $cabinet->id,
        'patient_id' => $patient->id,
    ]);

    $response = $this->get("/appointments/{$appointment->id}");
    $response->assertStatus(200);
    $response->assertViewIs('appointments.show');
});

test('doctors cannot view appointments for other cabinets', function () {
    $doctor1 = User::factory()->doctor()->create();
    $doctor2 = User::factory()->doctor()->create();
    $cabinet1 = Cabinet::factory()->create(['doctor_id' => $doctor1->id]);
    $cabinet2 = Cabinet::factory()->create(['doctor_id' => $doctor2->id]);
    $patient = User::factory()->patient()->create();
    $this->actingAs($doctor1);

    $appointment = Appointment::factory()->create([
        'cabinet_id' => $cabinet2->id,
        'patient_id' => $patient->id,
    ]);

    $response = $this->get("/appointments/{$appointment->id}");
    $response->assertStatus(403);
});

test('admins can view any appointment', function () {
    $admin = User::factory()->admin()->create();
    $patient = User::factory()->patient()->create();
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $this->actingAs($admin);

    $appointment = Appointment::factory()->create([
        'patient_id' => $patient->id,
        'cabinet_id' => $cabinet->id,
    ]);

    $response = $this->get("/appointments/{$appointment->id}");
    $response->assertStatus(200);
    $response->assertViewIs('appointments.show');
});

test('appointments create requires authentication', function () {
    $response = $this->get('/appointments/create');

    $response->assertRedirect('/login');
});

test('appointments create form displays for patients', function () {
    $patient = User::factory()->patient()->create();
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $this->actingAs($patient);

    $response = $this->get("/appointments/create?cabinet_id={$cabinet->id}");

    $response->assertStatus(200);
    $response->assertViewIs('appointments.create');
});

test('calendar endpoint requires authentication', function () {
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $patient = User::factory()->patient()->create();

    Appointment::factory()->count(3)->create([
        'cabinet_id' => $cabinet->id,
        'patient_id' => $patient->id,
    ]);

    $response = $this->get('/api/calendar/appointments');

    $response->assertRedirect('/login');
});

test('authenticated users can access calendar endpoint', function () {
    $user = User::factory()->patient()->create();
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $this->actingAs($user);

    Appointment::factory()->count(3)->create([
        'patient_id' => $user->id,
        'cabinet_id' => $cabinet->id,
    ]);

    $response = $this->get('/api/calendar/appointments');

    $response->assertStatus(200);
    $response->assertJsonCount(3);
});

test('appointment validation works', function () {
    $patient = User::factory()->patient()->create();
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $this->actingAs($patient);

    $response = $this->post('/appointments', [
        'datetime' => '', // Required field missing
        'cabinet_id' => $cabinet->id,
    ]);

    $response->assertSessionHasErrors('datetime');
});
