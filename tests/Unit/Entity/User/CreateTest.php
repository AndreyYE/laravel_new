<?php

namespace Tests\Unit;

use App\Entity\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testNew() : void
    {
        $user = User::new(
                $name = 'name4',
                $email = 'email4',
                $role = User::ROLE_USER
        );

        self::assertNotEmpty($user);
        self::assertEquals($name, $user->name);
        self::assertEquals($email, $user->email);
        self::assertNotEmpty($user->password);
        self::assertFalse($user->isWait());
        self::assertTrue($user->isActive());
        self::assertNotNull($user->email_verified_at);
        self::assertFalse($user->isAdmin());
    }

}
