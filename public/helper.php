<?php

\App\Models\User::updateOrCreate(
    ['email' => 'admin@lilacstar.local'],
    [
        'name' => 'Admin',
        'email_verified_at' => date("Y-m-d H:i:s", time()),
        'password' => bcrypt('password123'),
        'remember_token' => rand(1000000000, 9999999999),
        'is_admin' => 1,
    ]
);
