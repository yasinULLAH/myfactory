<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Core\Application;
use App\Core\Auth;

class AuthTest extends TestCase
{
    protected Application $app;

    protected function setUp(): void
    {
        $root = dirname(__DIR__);
        $config = ['db' => ['driver' => 'sqlite', 'database' => $root . '/database/factory.sqlite']];
        $this->app = new Application($root, $config);
    }

    public function testIsGuestByDefault()
    {
        $this->assertTrue(Auth::isGuest());
    }

    public function testLoginSuccess()
    {
        $user = ['id' => 1, 'role_id' => 1];
        Auth::login($user);
        $this->assertFalse(Auth::isGuest());
        $this->assertEquals(1, $this->app->session->get('user'));
    }
}
