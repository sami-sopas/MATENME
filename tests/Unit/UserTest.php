<?php

namespace Tests\Unit;

use Tests\TestCase; //Se usa esta madre cuando usemos factory en unit tests
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_a_user_has_projects(): void
    {
        $user = \App\Models\User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }
}
