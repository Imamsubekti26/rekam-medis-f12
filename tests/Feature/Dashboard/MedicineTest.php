<?php

use App\Models\Medicine;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $response = $this->get('/medicine');
    $response->assertRedirect('/login');
});

test('doctor can view the medicine list and data', function () {
    $user = User::factory()->doctor()->create();
    $this->actingAs($user);

    // test: user bisa akses halaman list view
    $listView = $this->get('/medicine');
    $listView->assertStatus(200);

    // test: user bisa akses halaman detail
    $medicine = Medicine::factory()->create();
    $detailView = $this->get("/medicine/{$medicine->id}");
    $detailView->assertStatus(200);
});

test('pharmacist can view the medicine list and data', function () {
    $user = User::factory()->pharmacist()->create();
    $this->actingAs($user);

    // test: user bisa akses halaman list view
    $listView = $this->get('/medicine');
    $listView->assertStatus(200);

    // test: user bisa akses halaman detail
    $medicine = Medicine::factory()->create();
    $detailView = $this->get("/medicine/{$medicine->id}");
    $detailView->assertStatus(200);
});

test('doctor can NOT manipulate the medicine data', function () {
    $user = User::factory()->doctor()->create();
    $this->actingAs($user);

    $medicineData = [
        'barcode' => '1122332',
        'name' => 'paracetamol',
        'price' => 2000
    ];

    // test: create
    $response = $this->post('/medicine', $medicineData);
    $response->assertSessionHasErrors();
    $this->assertDatabaseMissing('medicines', ['barcode' => '1122332']);

    $medicine = Medicine::factory()->create();
    $medicineData['price'] = 3000;

    // test: update
    $updateResponse = $this->put("/medicine/{$medicine->id}", $medicineData);
    $updateResponse->assertSessionHasErrors();

    // test: delete
    $deleteResponse = $this->delete("/medicine/{$medicine->id}");
    $deleteResponse->assertSessionHasErrors();
    $this->assertDatabaseHas('medicines', ['id' => $medicine->id]);
});

test('pharmacist can manipulate the medicine data', function () {
    $user = User::factory()->pharmacist()->create();
    $this->actingAs($user);

    $medicineData = [
        'barcode' => '1122332',
        'name' => 'paracetamol',
        'price' => 2000
    ];

    // test: create
    $response = $this->post('/medicine', $medicineData);
    $this->assertDatabaseHas('medicines', $medicineData);
    $response->assertRedirect('/medicine');

    $medicine = Medicine::where('barcode', '1122332')->first();
    $medicineData['price'] = 3000;

    // test: update
    $updateResponse = $this->put("/medicine/{$medicine->id}", $medicineData);
    $updateResponse->assertRedirect("/medicine");
    $this->assertDatabaseHas('medicines', $medicineData);
    $this->assertDatabaseMissing('medicines', ['price' => 2000]);

    // test: delete
    $deleteResponse = $this->delete("/medicine/{$medicine->id}");
    $deleteResponse->assertRedirect('/medicine');
    $this->assertDatabaseMissing('medicines', ['id' => $medicine->id]);
});