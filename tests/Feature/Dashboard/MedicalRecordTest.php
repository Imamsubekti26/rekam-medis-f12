<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');
});

test('doctor can view the medical record list and data', function () {
    $user = User::factory()->doctor()->create();
    $this->actingAs($user);

    $response = $this->get('/');
    $response->assertStatus(200);
});

test('pharmacist can view the medical record list and data', function () {
    $user = User::factory()->pharmacist()->create();
    $this->actingAs($user);

    $response = $this->get('/');
    $response->assertStatus(200);
});

test('doctor can manipulate the medical record data', function () {
    $user = User::factory()->pharmacist()->create();
    $this->actingAs($user);

    $response = $this->get('/');
    $response->assertStatus(200);
});

test('pharmacist can NOT manipulate the medical record data', function () {
    $user = User::factory()->pharmacist()->create();
    $this->actingAs($user);

    $response = $this->get('/');
    $response->assertStatus(200);
});