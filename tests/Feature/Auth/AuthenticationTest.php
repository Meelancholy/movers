<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    // Create a user with a specific password
    $password = 'password'; // Set your desired password here
    $user = User::factory()->create([
        'password' => bcrypt($password), // Ensure the password is hashed
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => $password, // Use the same password
    ]);

    $this->assertAuthenticatedAs($user); // Check if the user is authenticated
    $response->assertRedirect(route('dashboard', absolute: false));
});


test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
