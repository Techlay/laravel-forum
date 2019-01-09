<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_a_profile()
    {
        $user = create('App\User');

        $response = $this->getJson("/profiles/{$user->username}")->json();

        $this->assertEquals($response['profileUser']['name'], $user->name);
    }
}
