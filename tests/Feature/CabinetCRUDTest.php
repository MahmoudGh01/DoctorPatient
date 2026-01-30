<?php

use App\Models\Cabinet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('cabinets index displays to all users', function () {
    $doctor = User::factory()->doctor()->create();
    Cabinet::factory()->count(3)->create(['doctor_id' => $doctor->id]);

    $response = $this->get('/cabinets');

    $response->assertStatus(200);
    $response->assertViewIs('cabinets.index');
});

test('cabinets index displays to authenticated patients', function () {
    $patient = User::factory()->patient()->create();
    $doctor = User::factory()->doctor()->create();
    $this->actingAs($patient);

    Cabinet::factory()->count(3)->create(['doctor_id' => $doctor->id]);

    $response = $this->get('/cabinets');

    $response->assertStatus(200);
    $response->assertViewIs('cabinets.index');
});

test('cabinets index displays to authenticated doctors', function () {
    $doctor = User::factory()->doctor()->create();
    $this->actingAs($doctor);

    Cabinet::factory()->count(3)->create(['doctor_id' => $doctor->id]);

    $response = $this->get('/cabinets');

    $response->assertStatus(200);
    $response->assertViewIs('cabinets.index');
});

test('cabinets create requires authentication', function () {
    $response = $this->get('/admin/cabinets/create');

    $response->assertRedirect('/login');
});

test('cabinets create displays to admins', function () {
    $admin = User::factory()->admin()->create();
    $this->actingAs($admin);

    $response = $this->get('/admin/cabinets/create');

    $response->assertStatus(200);
    $response->assertViewIs('admin.cabinets.create');
});

test('patients cannot access cabinet create form', function () {
    $patient = User::factory()->patient()->create();
    $this->actingAs($patient);

    $response = $this->get('/admin/cabinets/create');

    $response->assertStatus(403);
});

test('cabinets store requires authentication', function () {
    $cabinetData = [
        'name' => 'Test Cabinet',
        'location' => '123 Test Street',
    ];

    $response = $this->post('/cabinets', $cabinetData);

    $response->assertRedirect('/login');
});

test('admins can create new cabinets', function () {
    $admin = User::factory()->admin()->create();
    $this->actingAs($admin);

    $cabinetData = [
        'name' => 'Test Cabinet',
        'location' => '123 Test Street',
    ];

    $response = $this->post('/cabinets', $cabinetData);

    $response->assertRedirect('/cabinets');
    $this->assertDatabaseHas('cabinets', $cabinetData);
});

test('patients cannot create new cabinets', function () {
    $patient = User::factory()->patient()->create();
    $this->actingAs($patient);

    $cabinetData = [
        'name' => 'Test Cabinet',
        'location' => '123 Test Street',
    ];

    $response = $this->post('/cabinets', $cabinetData);

    $response->assertStatus(403);
});

test('cabinets show displays to all users', function () {
    $cabinet = Cabinet::factory()->create();

    $response = $this->get("/cabinets/{$cabinet->id}");

    $response->assertStatus(200);
    $response->assertViewIs('cabinets.show');
});

test('cabinets edit requires authentication', function () {
    $cabinet = Cabinet::factory()->create();

    $response = $this->get("/cabinets/{$cabinet->id}/edit");

    $response->assertRedirect('/login');
});

test('admins can access cabinet edit form', function () {
    $admin = User::factory()->admin()->create();
    $this->actingAs($admin);
    $cabinet = Cabinet::factory()->create();

    $response = $this->get("/cabinets/{$cabinet->id}/edit");

    $response->assertStatus(200);
    $response->assertViewIs('cabinets.edit');
});

test('patients cannot access cabinet edit form', function () {
    $patient = User::factory()->patient()->create();
    $this->actingAs($patient);
    $cabinet = Cabinet::factory()->create();

    $response = $this->get("/cabinets/{$cabinet->id}/edit");

    $response->assertStatus(403);
});

test('cabinets update requires authentication', function () {
    $cabinet = Cabinet::factory()->create();

    $updateData = [
        'name' => 'Updated Cabinet Name',
    ];

    $response = $this->put("/cabinets/{$cabinet->id}", $updateData);

    $response->assertRedirect('/login');
});

test('admins can update cabinets', function () {
    $admin = User::factory()->admin()->create();
    $this->actingAs($admin);
    $cabinet = Cabinet::factory()->create();

    $updateData = [
        'name' => 'Updated Cabinet Name',
    ];

    $response = $this->put("/cabinets/{$cabinet->id}", $updateData);

    $response->assertRedirect('/cabinets');
    $this->assertDatabaseHas('cabinets', ['name' => 'Updated Cabinet Name', 'id' => $cabinet->id]);
});

test('patients cannot update cabinets', function () {
    $patient = User::factory()->patient()->create();
    $this->actingAs($patient);
    $cabinet = Cabinet::factory()->create();

    $updateData = [
        'name' => 'Updated Cabinet Name',
    ];

    $response = $this->put("/cabinets/{$cabinet->id}", $updateData);

    $response->assertStatus(403);
});

test('cabinets delete requires authentication', function () {
    $cabinet = Cabinet::factory()->create();

    $response = $this->delete("/cabinets/{$cabinet->id}");

    $response->assertRedirect('/login');
});

test('admins can delete cabinets', function () {
    $admin = User::factory()->admin()->create();
    $this->actingAs($admin);
    $cabinet = Cabinet::factory()->create();

    $response = $this->delete("/cabinets/{$cabinet->id}");

    $response->assertRedirect('/cabinets');
    $this->assertDatabaseMissing('cabinets', ['id' => $cabinet->id]);
});

test('patients cannot delete cabinets', function () {
    $patient = User::factory()->patient()->create();
    $this->actingAs($patient);
    $cabinet = Cabinet::factory()->create();

    $response = $this->delete("/cabinets/{$cabinet->id}");

    $response->assertStatus(403);
});

test('cabinets validation works', function () {
    $admin = User::factory()->admin()->create();
    $this->actingAs($admin);

    $response = $this->post('/cabinets', [
        'name' => '', // Required field missing
    ]);

    $response->assertSessionHasErrors('name');
});

test('cabinets index paginates correctly', function () {
    Cabinet::factory()->count(15)->create();

    $response = $this->get('/cabinets');

    $response->assertViewIs('cabinets.index');
    $response->assertViewHas('cabinets');
});
