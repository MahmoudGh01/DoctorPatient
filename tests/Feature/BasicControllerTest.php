<?php

use App\Models\User;

test('welcome page loads without errors for guests', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('welcome page loads without errors for authenticated patients', function () {
    $patient = User::factory()->patient()->create();
    $this->actingAs($patient);

    $response = $this->get('/');

    $response->assertStatus(200);
});

test('welcome page loads without errors for authenticated doctors', function () {
    $doctor = User::factory()->doctor()->create();
    $this->actingAs($doctor);

    $response = $this->get('/');

    $response->assertStatus(200);
});

test('welcome page loads without errors for authenticated admins', function () {
    $admin = User::factory()->admin()->create();
    $this->actingAs($admin);

    $response = $this->get('/');

    $response->assertStatus(200);
});

test('cabinets page loads without errors for guests', function () {
    $response = $this->get('/cabinets');

    $response->assertStatus(200);
});

test('cabinets page loads without errors for authenticated patients', function () {
    $patient = User::factory()->patient()->create();
    $this->actingAs($patient);

    $response = $this->get('/cabinets');

    $response->assertStatus(200);
});

test('cabinets page loads without errors for authenticated doctors', function () {
    $doctor = User::factory()->doctor()->create();
    $this->actingAs($doctor);

    $response = $this->get('/cabinets');

    $response->assertStatus(200);
});

test('cabinets page loads without errors for authenticated admins', function () {
    $admin = User::factory()->admin()->create();
    $this->actingAs($admin);

    $response = $this->get('/cabinets');

    $response->assertStatus(200);
});
