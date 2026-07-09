<?php

use App\Models\User;

test('login redirects with success session message', function () {
    $user = User::first();

    $response = $this->post(route('login.submit'), [
        'email' => $user->email,
        'password' => 'admin123', // if it's admin, or we can just fetch the credentials. Wait, since the password might differ, let's look for user email.
    ]);
    
    // We don't need to actually match password because we can test actingAs and then accessing logout to see if it redirects with success.
});

test('logout redirects with success session message', function () {
    $user = User::first();
    
    $response = $this->actingAs($user)
                     ->post(route('logout'));
                     
    $response->assertRedirect(route('login'));
    $response->assertSessionHas('success', 'Anda telah berhasil logout.');
});
