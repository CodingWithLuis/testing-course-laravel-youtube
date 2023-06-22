<?php

namespace Tests;

use App\Models\User;

trait CreateUser
{
    private function createNewUser($is_admin = 0): User
    {
        $user = User::factory()->create([
            'email' => $is_admin ? 'admin@admin.com' : 'user@user.com',
            'password' => bcrypt('password'),
            'is_admin' => $is_admin
        ]);

        return $user;
    }
}
