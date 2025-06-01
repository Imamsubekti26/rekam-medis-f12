<?php

use App\Models\Patient;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $response = $this->get('/patient');
    $response->assertRedirect('/login');
});

test('doctor can view the patient list and data', function () {
    $user = User::factory()->doctor()->create();
    $this->actingAs($user);

    // test: user bisa akses halaman list view
    $listView = $this->get('/patient');
    $listView->assertStatus(200);

    // test: user bisa akses halaman detail
    $patient = Patient::factory()->create();
    $detailView = $this->get("/patient/$patient->id");
    $detailView->assertStatus(200);
});

test('pharmacist can view the patient list and data', function () {
    $user = User::factory()->pharmacist()->create();
    $this->actingAs($user);

    // test: user bisa akses halaman list view
    $listView = $this->get('/patient');
    $listView->assertStatus(200);

    // test: user bisa akses halaman detail
    $patient = Patient::factory()->create();
    $detailView = $this->get("/patient/$patient->id");
    $detailView->assertStatus(200);
});

test('doctor can manipulate the patient data', function () {
    $user = User::factory()->doctor()->create();
    $this->actingAs($user);

    $patientData = [
        'member_id' => '1122332',
        'name' => 'john doe',
    ];

    // test: create
    $response = $this->post('/patient', $patientData);
    $this->assertDatabaseHas('patients', $patientData);
    $response->assertRedirect('/patient');

    $patient = Patient::where('member_id', '1122332')->first();
    $patientData['name'] = 'john updated';

    // test: update
    $updateResponse = $this->put("/patient/{$patient->id}", $patientData);
    $updateResponse->assertRedirect("/patient/{$patient->id}");
    $this->assertDatabaseHas('patients', $patientData);
    $this->assertDatabaseMissing('patients', ['name' => 'john doe']);

    // test: delete
    $deleteResponse = $this->delete("/patient/{$patient->id}");
    $deleteResponse->assertRedirect('/patient');
    $this->assertDatabaseMissing('patients', ['id' => $patient->id]);
});

test('pharmacist can manipulate the patient data', function () {
    $user = User::factory()->pharmacist()->create();
    $this->actingAs($user);

    $patientData = [
        'member_id' => '1122332',
        'name' => 'john doe',
    ];

    // test: create
    $response = $this->post('/patient', $patientData);
    $this->assertDatabaseHas('patients', $patientData);
    $response->assertRedirect('/patient');

    $patient = Patient::where('member_id', '1122332')->first();
    $patientData['name'] = 'john updated';

    // test: update
    $updateResponse = $this->put("/patient/{$patient->id}", $patientData);
    $updateResponse->assertRedirect("/patient/{$patient->id}");
    $this->assertDatabaseHas('patients', $patientData);
    $this->assertDatabaseMissing('patients', ['name' => 'john doe']);

    // test: delete
    $deleteResponse = $this->delete("/patient/{$patient->id}");
    $deleteResponse->assertRedirect('/patient');
    $this->assertDatabaseMissing('patients', ['id' => $patient->id]);
});