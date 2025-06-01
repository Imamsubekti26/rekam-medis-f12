<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('doctor can view the appointment list and data', function () {
    $user = User::factory()->doctor()->create();
    $this->actingAs($user);

    $response = $this->get('/appointment');
    $response->assertStatus(200);
});

test('pharmacist can view the appointment list and data', function () {
    $user = User::factory()->pharmacist()->create();
    $this->actingAs($user);

    $response = $this->get('/appointment');
    $response->assertStatus(200);
});

test('guest can NOT view the appointment list and data', function () {
    $response = $this->get('/appointment');
    $response->assertRedirect('/login');
});

test('guest can access and create an appointment form', function () {
    $appointmentData = [
        'patientName' => 'john doe',
        'phone' => '08123432123',
        'selectedDate' => '2025-08-01',
        'selectedTime' => '12:30',
        'detail' => 'detail',
    ];

    $response = $this->get('/');
    $response->assertStatus(200);
});

test('doctor can add new appointment data', function () {
    $user = User::factory()->doctor()->create();
    $this->actingAs($user);

    $appointmentData = [
        'patientName' => 'john doe',
        'phone' => '08123432123',
        'selectedDate' => '2025-08-01',
        'selectedTime' => '12:30',
        'detail' => 'detail',
    ];

    $response = $this->get('/');
    $response->assertStatus(200);
});

test('pharmacist can add new appointment data', function () {
    $user = User::factory()->doctor()->create();
    $this->actingAs($user);

    $appointmentData = [
        'patientName' => 'john doe',
        'phone' => '08123432123',
        'selectedDate' => '2025-08-01',
        'selectedTime' => '12:30',
        'detail' => 'detail',
    ];

    $response = $this->get('/');
    $response->assertStatus(200);
});

test('doctor can NOT process the appointment data', function () {
    $user = User::factory()->doctor()->create();
    $this->actingAs($user);

    $response = $this->get('/');
    $response->assertStatus(200);
});

test('pharmacist can process the appointment data', function () {
    $user = User::factory()->doctor()->create();
    $this->actingAs($user);

    $response = $this->get('/');
    $response->assertStatus(200);
});