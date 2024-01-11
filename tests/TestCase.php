<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // Este método inicia sesion de un usuario o lo crea
    protected function signIn($user = null)
    {
        $user = $user?: \App\Models\User::factory()->create();

        $this->actingAs($user);

        return $user;
    }
}
