<?php

namespace Tests;

use App\User;

trait CreatesUser
{
    /**
     * Creates a user from a factory and then logs it in
     * @return User
     */
    protected function createLoggedInUser(): User
    {
        $user = $this->createUser();
        auth()->attempt(['email' => $user->email, 'password' => 'test']);
        return $user;
    }

    /**
     * Creates a user from a factory
     * @return User
     */
    protected function createUser(): User
    {
        return factory(User::class)->create(['password' => bcrypt('test')]);
    }
}
