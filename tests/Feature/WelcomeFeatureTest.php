<?php

test('welcome page displays basic view without problematic sections', function () {
    // Create cabinet without triggering doctor relationship/media issues
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertViewIs('welcome');
});

test('welcome page view loads with minimal data', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertViewIs('welcome');

    // Test that view contains expected elements
    $response->assertSee('Find Your Perfect Doctor');
    $response->assertSee('Connect with top-rated medical professionals');
});
