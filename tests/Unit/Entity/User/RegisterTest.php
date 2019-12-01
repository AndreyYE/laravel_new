<?php

namespace Tests\Unit;

use App\Entity\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRequest() : void
    {
        $user = User::register(
                $name = 'name3',
                $email = 'email3',
                $password = '11111111'
        );

        self::assertNotEmpty($user);
        self::assertEquals($name, $user->name);
        self::assertEquals($email, $user->email);
        self::assertNotEquals($password, $user->password);
        self::assertTrue($user->isWait());
        self::assertFalse($user->isActive());
        self::assertNull($user->email_verified_at);
        self::assertFalse($user->isAdmin());
    }

}
