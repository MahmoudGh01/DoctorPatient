<?php

use App\Models\Appointment;
use App\Models\Cabinet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('calendar appointments requires authentication', function () {
    $response = $this->get('/api/calendar/appointments');

    $response->assertRedirect('/login');
});

test('calendar appointments returns empty list when no appointments exist for patient', function () {
    $patient = User::factory()->patient()->create();
    $this->actingAs($patient);

    $response = $this->get('/api/calendar/appointments');

    $response->assertStatus(200);
    $response->assertJsonCount(0);
});

test('calendar appointments returns empty list when no appointments exist for doctor', function () {
    $doctor = User::factory()->doctor()->create();
    $this->actingAs($doctor);

    $response = $this->get('/api/calendar/appointments');

    $response->assertStatus(200);
    $response->assertJsonCount(0);
});

test('calendar appointments returns empty list when no appointments exist for admin', function () {
    $admin = User::factory()->admin()->create();
    $this->actingAs($admin);

    $response = $this->get('/api/calendar/appointments');

    $response->assertStatus(200);
    $response->assertJsonCount(0);
});

test('calendar appointments returns patient appointments json structure', function () {
    $patient = User::factory()->patient()->create();
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $this->actingAs($patient);

    Appointment::factory()->count(3)->create([
        'patient_id' => $patient->id,
        'cabinet_id' => $cabinet->id,
    ]);

    $response = $this->get('/api/calendar/appointments');

    $response->assertStatus(200);
    $response->assertJsonCount(3);

    // Test JSON structure
    $response->assertJsonStructure([
        '*' => [
            'id',
            'title',
            'start',
            'color',
        ],
    ]);
});

test('calendar appointments returns doctor cabinet appointments json structure', function () {
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $patient = User::factory()->patient()->create();
    $this->actingAs($doctor);

    Appointment::factory()->count(3)->create([
        'cabinet_id' => $cabinet->id,
        'patient_id' => $patient->id,
    ]);

    $response = $this->get('/api/calendar/appointments');

    $response->assertStatus(200);
    $response->assertJsonCount(3);

    // Test JSON structure
    $response->assertJsonStructure([
        '*' => [
            'id',
            'title',
            'start',
            'color',
        ],
    ]);
});

test('calendar appointments returns all appointments for admin', function () {
    $admin = User::factory()->admin()->create();
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $patient = User::factory()->patient()->create();
    $this->actingAs($admin);

    Appointment::factory()->count(3)->create([
        'cabinet_id' => $cabinet->id,
        'patient_id' => $patient->id,
    ]);

    $response = $this->get('/api/calendar/appointments');

    $response->assertStatus(200);
    $response->assertJsonCount(3);

    // Test JSON structure
    $response->assertJsonStructure([
        '*' => [
            'id',
            'title',
            'start',
            'color',
        ],
    ]);
});

test('calendar appointments filters by cabinet_id for doctor', function () {
    $doctor = User::factory()->doctor()->create();
    $cabinet1 = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $cabinet2 = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $patient = User::factory()->patient()->create();
    $this->actingAs($doctor);

    Appointment::factory()->create([
        'cabinet_id' => $cabinet1->id,
        'patient_id' => $patient->id,
    ]);
    Appointment::factory()->count(2)->create([
        'cabinet_id' => $cabinet2->id,
        'patient_id' => $patient->id,
    ]);

    // Test with cabinet1 filter
    $response = $this->get("/calendar/appointments?cabinet_id={$cabinet1->id}");
    $response->assertStatus(200);
    $response->assertJsonCount(1);

    // Test with cabinet2 filter
    $response = $this->get("/calendar/appointments?cabinet_id={$cabinet2->id}");
    $response->assertStatus(200);
    $response->assertJsonCount(2);
});

test('calendar appointments filters by cabinet_id for admin', function () {
    $admin = User::factory()->admin()->create();
    $doctor = User::factory()->doctor()->create();
    $cabinet1 = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $cabinet2 = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $patient = User::factory()->patient()->create();
    $this->actingAs($admin);

    Appointment::factory()->create([
        'cabinet_id' => $cabinet1->id,
        'patient_id' => $patient->id,
    ]);
    Appointment::factory()->count(2)->create([
        'cabinet_id' => $cabinet2->id,
        'patient_id' => $patient->id,
    ]);

    // Test with cabinet1 filter
    $response = $this->get("/calendar/appointments?cabinet_id={$cabinet1->id}");
    $response->assertStatus(200);
    $response->assertJsonCount(1);

    // Test with cabinet2 filter
    $response = $this->get("/calendar/appointments?cabinet_id={$cabinet2->id}");
    $response->assertStatus(200);
    $response->assertJsonCount(2);
});

test('calendar appointments returns proper datetime format', function () {
    $patient = User::factory()->patient()->create();
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $this->actingAs($patient);

    $appointment = Appointment::factory()->create([
        'datetime' => '2024-01-15 10:30:00',
        'patient_id' => $patient->id,
        'cabinet_id' => $cabinet->id,
    ]);

    $response = $this->get('/api/calendar/appointments');

    $response->assertStatus(200);
    $data = $response->json();

    // Should return datetime in FullCalendar format
    expect($data[0]['start'])->toBe('2024-01-15T10:30:00');
});

test('patients cannot see appointments for other patients', function () {
    $patient1 = User::factory()->patient()->create();
    $patient2 = User::factory()->patient()->create();
    $doctor = User::factory()->doctor()->create();
    $cabinet = Cabinet::factory()->create(['doctor_id' => $doctor->id]);
    $this->actingAs($patient1);

    Appointment::factory()->count(3)->create([
        'patient_id' => $patient2->id,
        'cabinet_id' => $cabinet->id,
    ]);

    $response = $this->get('/api/calendar/appointments');

    $response->assertStatus(200);
    $response->assertJsonCount(0);
});

test('doctors cannot see appointments for other cabinets', function () {
    $doctor1 = User::factory()->doctor()->create();
    $doctor2 = User::factory()->doctor()->create();
    $cabinet1 = Cabinet::factory()->create(['doctor_id' => $doctor1->id]);
    $cabinet2 = Cabinet::factory()->create(['doctor_id' => $doctor2->id]);
    $patient = User::factory()->patient()->create();
    $this->actingAs($doctor1);

    Appointment::factory()->count(3)->create([
        'cabinet_id' => $cabinet2->id,
        'patient_id' => $patient->id,
    ]);

    $response = $this->get('/api/calendar/appointments');

    $response->assertStatus(200);
    $response->assertJsonCount(0);
});
