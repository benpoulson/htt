<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class AuthenticationFeatureTest
 * Tests specifically relating to the authentication REST API endpoints
 * @package Tests\Feature
 */
class AuthenticationFeatureTest extends TestCase
{
    use DatabaseTransactions;

    public function testAccessUserDetailsEndpointSuccessfully()
    {
        $user = $this->createLoggedInUser();
        $response = $this->actingAs($user)->get(route('auth.user', [], false));
        $response->assertJsonStructure([
            'data' => [
                'name',
                'email'
            ]
        ]);
    }

    public function testAccessUserDetailsEndpointUnsuccessfully()
    {
        $response = $this->get(route('auth.user', [], false));
        $response->assertStatus(401);
    }

    public function testAccessUserLoginEndpointSuccessfully()
    {
        $user = $this->createUser();
        $response = $this->post(route('auth.login', [], false), [
            'email' => $user->email,
            'password' => 'test'
        ]);
        $response->assertStatus(200);
    }

    public function testAccessUserLoginEndpointUnsuccessfully()
    {
        $user = $this->createLoggedInUser();
        $response = $this->post(route('auth.login', [], false), [
            'email' => $user->email,
            'password' => 'incorrect'
        ]);
        $response->assertStatus(401);
    }

    public function testAccessUserRefreshEndpointSuccessfully()
    {
        $user = $this->createLoggedInUser();
        $response = $this->actingAs($user)->post(route('auth.refresh', [], false));
        $response->assertStatus(200);
    }

    public function testAccessUserRefreshEndpointUnsuccessfully()
    {
        $response = $this->post(route('auth.refresh', [], false));
        $response->assertStatus(401);
    }

    public function testAccessUserLogoutEndpointWithoutUserSuccessfully()
    {
        $response = $this->post(route('auth.logout', [], false));
        $response->assertExactJson(['data' => ['message' => 'Successfully logged out']]);
    }

    public function testAccessUserLogoutEndpointWithUserSuccessfully()
    {
        $user = $this->createLoggedInUser();
        $response = $this->actingAs($user)->post(route('auth.logout', [], false));
        $response->assertExactJson(['data' => ['message' => 'Successfully logged out']]);
    }
}
