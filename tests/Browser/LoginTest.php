<?php

namespace Tests\Browser;

use App\Entity\User;
use Carbon\Carbon;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends DuskTestCase
{
    use DatabaseTransactions;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginForm()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->assertSee('Login');
        });
    }

    public function testLoginAwait()
    {
        $password = 11111111;

        $user = factory(User::class)->create([
            'status'=>User::STATUS_WAIT,
            'password'=>bcrypt($password),
            'email_verified_at'=>null]);

        $this->browse(function (Browser $browser) use ($user, $password) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', $password)
                ->press('Login')
                ->assertPathIs('/email/verify');
        });
    }
    public function testLoginActive()
    {
        $password = 11111111;

        $user = factory(User::class)->create([
            'status'=>User::STATUS_ACTIVE,
            'password'=>bcrypt($password),
            'email_verified_at'=>Carbon::now()]);
        $user1 = factory(User::class)->create([
            'name'=>'asdfafkjhgqlweth',
            'status'=>User::STATUS_ACTIVE,
            'password'=>bcrypt($password),
            'email_verified_at'=>Carbon::now()]);

        $this->browse(function ($browser, $browser1) use ($user, $password, $user1) {

            $browser->loginAs($user)
                ->visit('/cabinet')
                ->assertSee('Profile');


            $browser1->loginAs($user1)
                ->visit('/')
                ->clickLink($user1->name)
                ->assertSee('Logout')
                ->clickLink('Logout')
                ->assertSee('Login');
        });
    }
}
