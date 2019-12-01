<?php

namespace Tests\Unit;

use App\Entity\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testChange() : void
    {
      $user =  factory(User::class)->create(['role'=>User::ROLE_USER]);
      self::assertFalse($user->isAdmin());
      $user->changeRole(User::ROLE_ADMIN);
      self::assertTrue($user->isAdmin());
    }

    public function testAlready()
    {
        $user =  factory(User::class)->create(['role'=>User::ROLE_ADMIN]);
        $this->expectExceptionMessage('The role is already assigned');
        $user->changeRole(User::ROLE_ADMIN);
    }
    public function testWrongRole()
    {
        $user =  factory(User::class)->create(['role'=>User::ROLE_ADMIN]);
        $this->expectExceptionMessage('You picked the wrong role');
        $user->changeRole('wrong role');
    }

}
