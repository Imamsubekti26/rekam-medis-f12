<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $response = $this->get('/doctor');
    $response->assertRedirect('/login');

    $response2 = $this->get('/pharmacist');
    $response2->assertRedirect('/login');
});

test('superadmin can view the doctor list and data', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/doctor');
    $response->assertStatus(200);
});

test('superadmin can view the pharmacist list and data', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/pharmacist');
    $response->assertStatus(200);
});

test('superadmin can manipulate the doctor list and data', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $userData = [
        'name' => 'john doe',
        'email' => 'john@doe.com',
        'password' => '123123123',
        'password_confirmation' => '123123123'
    ];

    $noPassword = [
        'name' => 'john doe',
        'email' => 'john@doe.com'
    ];

    // test: create
    $response = $this->post('/doctor', $userData);
    $response->assertRedirect('/doctor');
    
    $doctor = User::where('email', $userData['email'])->first();
    $this->assertNotNull($doctor);
    $this->assertTrue($doctor->role === 'doctor');
    $this->assertDatabaseHas('users', [
        'id' => $doctor->id,
        'email' => $userData['email'],
    ]);

    $userData['email'] = 'john@doe.id';
    $noPassword['email'] = 'john@doe.id';

    // test: update
    $updateResponse = $this->put("/doctor/{$doctor->id}", $noPassword);
    $updateResponse->assertRedirect("/doctor");
    $this->assertDatabaseHas('users', $noPassword);
    $this->assertDatabaseMissing('users', ['email' => 'john@doe.com']);

    // test: delete
    $deleteResponse = $this->delete("/doctor/{$doctor->id}");
    $deleteResponse->assertRedirect('/doctor');
    $this->assertDatabaseMissing('users', ['id' => $doctor->id]);
});

test('superadmin can manipulate the pharmacist list and data', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $userData = [
        'name' => 'john doe',
        'email' => 'john@doe.com',
        'password' => '123123123',
        'password_confirmation' => '123123123'
    ];

    $noPassword = [
        'name' => 'john doe',
        'email' => 'john@doe.com'
    ];

    // test: create
    $response = $this->post('/pharmacist', $userData);
    $response->assertRedirect('/pharmacist');
    
    $pharmacist = User::where('email', $userData['email'])->first();
    $this->assertNotNull($pharmacist);
    $this->assertTrue($pharmacist->role === 'pharmacist');
    $this->assertDatabaseHas('users', [
        'id' => $pharmacist->id,
        'email' => $userData['email'],
    ]);

    $userData['email'] = 'john@doe.id';
    $noPassword['email'] = 'john@doe.id';

    // test: update
    $updateResponse = $this->put("/pharmacist/{$pharmacist->id}", $noPassword);
    $updateResponse->assertRedirect("/pharmacist");
    $this->assertDatabaseHas('users', $noPassword);
    $this->assertDatabaseMissing('users', ['email' => 'john@doe.com']);

    // test: delete
    $deleteResponse = $this->delete("/pharmacist/{$pharmacist->id}");
    $deleteResponse->assertRedirect('/pharmacist');
    $this->assertDatabaseMissing('users', ['id' => $pharmacist->id]);
});

test('doctor can view the doctor list and data', function () {
    $user = User::factory()->doctor()->create();
    $this->actingAs($user);

    $response = $this->get('/doctor');
    $response->assertStatus(200);
});

test('doctor can view the pharmacist list and data', function () {
    $user = User::factory()->doctor()->create();
    $this->actingAs($user);

    $response = $this->get('/pharmacist');
    $response->assertStatus(200);
});

test('doctor can NOT manipulate the doctor list and data', function () {
    $user = User::factory()->doctor()->create();
    $this->actingAs($user);

    $userData = [
        'name' => 'john doe',
        'email' => 'john@doe.com',
        'password' => '123123123',
        'password_confirmation' => '123123123'
    ];

    // test: create
    $response = $this->post('/doctor', $userData);
    $response->assertSessionHasErrors();
    
    $doctor = User::where('email', $userData['email'])->first();
    $this->assertNull($doctor);

    $newDoctor = [
        'name' => 'john doe',
        'email' => 'john@doe.com',
    ];
    $doctor = User::factory()->doctor()->create($newDoctor);
    $newDoctor['email'] = 'john@doe.id';

    // test: update
    $updateResponse = $this->put("/doctor/{$doctor->id}", $newDoctor);
    $updateResponse->assertSessionHasErrors();

    // test: delete
    $deleteResponse = $this->delete("/doctor/{$doctor->id}");
    $deleteResponse->assertSessionHasErrors();
    $this->assertDatabaseHas('users', ['id' => $doctor->id]);
});

test('doctor can NOT manipulate the pharmacist list and data', function () {
    $user = User::factory()->doctor()->create();
    $this->actingAs($user);

    $userData = [
        'name' => 'john doe',
        'email' => 'john@doe.com',
        'password' => '123123123',
        'password_confirmation' => '123123123'
    ];

    // test: create
    $response = $this->post('/pharmacist', $userData);
    $response->assertSessionHasErrors();
    
    $pharmacist = User::where('email', $userData['email'])->first();
    $this->assertNull($pharmacist);

    $newPharmacist = [
        'name' => 'john doe',
        'email' => 'john@doe.com',
    ];
    $pharmacist = User::factory()->pharmacist()->create($newPharmacist);
    $newPharmacist['email'] = 'john@doe.id';

    // test: update
    $updateResponse = $this->put("/pharmacist/{$pharmacist->id}", $newPharmacist);
    $updateResponse->assertSessionHasErrors();

    // test: delete
    $deleteResponse = $this->delete("/pharmacist/{$pharmacist->id}");
    $deleteResponse->assertSessionHasErrors();
    $this->assertDatabaseHas('users', ['id' => $pharmacist->id]);
});

test('pharmacist can view the doctor list and data', function () {
    $user = User::factory()->pharmacist()->create();
    $this->actingAs($user);

    $response = $this->get('/doctor');
    $response->assertStatus(200);
});

test('pharmacist can view the pharmacist list and data', function () {
    $user = User::factory()->pharmacist()->create();
    $this->actingAs($user);

    $response = $this->get('/pharmacist');
    $response->assertStatus(200);
});

test('pharmacist can NOT manipulate the doctor list and data', function () {
    $user = User::factory()->pharmacist()->create();
    $this->actingAs($user);

    $userData = [
        'name' => 'john doe',
        'email' => 'john@doe.com',
        'password' => '123123123',
        'password_confirmation' => '123123123'
    ];

    // test: create
    $response = $this->post('/doctor', $userData);
    $response->assertSessionHasErrors();
    
    $doctor = User::where('email', $userData['email'])->first();
    $this->assertNull($doctor);

    $newDoctor = [
        'name' => 'john doe',
        'email' => 'john@doe.com',
    ];
    $doctor = User::factory()->doctor()->create($newDoctor);
    $newDoctor['email'] = 'john@doe.id';

    // test: update
    $updateResponse = $this->put("/doctor/{$doctor->id}", $newDoctor);
    $updateResponse->assertSessionHasErrors();

    // test: delete
    $deleteResponse = $this->delete("/doctor/{$doctor->id}");
    $deleteResponse->assertSessionHasErrors();
    $this->assertDatabaseHas('users', ['id' => $doctor->id]);
});

test('pharmacist can NOT manipulate the pharmacist list and data', function () {
    $user = User::factory()->pharmacist()->create();
    $this->actingAs($user);

    $userData = [
        'name' => 'john doe',
        'email' => 'john@doe.com',
        'password' => '123123123',
        'password_confirmation' => '123123123'
    ];

    // test: create
    $response = $this->post('/pharmacist', $userData);
    $response->assertSessionHasErrors();
    
    $pharmacist = User::where('email', $userData['email'])->first();
    $this->assertNull($pharmacist);

    $newPharmacist = [
        'name' => 'john doe',
        'email' => 'john@doe.com',
    ];
    $pharmacist = User::factory()->pharmacist()->create($newPharmacist);
    $newPharmacist['email'] = 'john@doe.id';

    // test: update
    $updateResponse = $this->put("/pharmacist/{$pharmacist->id}", $newPharmacist);
    $updateResponse->assertSessionHasErrors();

    // test: delete
    $deleteResponse = $this->delete("/pharmacist/{$pharmacist->id}");
    $deleteResponse->assertSessionHasErrors();
    $this->assertDatabaseHas('users', ['id' => $pharmacist->id]);
});