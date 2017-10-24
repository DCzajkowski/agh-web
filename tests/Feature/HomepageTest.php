<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomepageTest extends TestCase
{
    public function testMainPageRedirectsToLoginPageWhenNotAuthenticated()
    {
        $response = $this->get('/');

        while ($response->isRedirect()) {
            $response = $this->get($response->headers->get('Location'));
        }

        $response->assertViewIs('auth.login');
    }

    public function testMainPageRedirectsToHomepageWhenAuthenticated()
    {
        $response = $this->actingAs(factory(\App\User::class)->make())->get('/');

        while ($response->isRedirect()) {
            $response = $this->get($response->headers->get('Location'));
        }

        $response->assertViewIs('home');
    }
}
