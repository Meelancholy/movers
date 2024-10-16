<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    // Create a user with a specific password
    $password = 'password';
    $user = User::factory()->create([
        'password' => bcrypt($password), // Hash the password
    ]);

    // Attempt to log in with the correct email and password
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => $password, // Use the same password
    ]);

    $this->assertAuthenticatedAs($user);


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
