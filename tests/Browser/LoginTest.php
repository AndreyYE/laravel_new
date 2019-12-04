<?php

namespace Tests\Browser;

use App\Entity\User;
use Carbon\Carbon;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
//    public function testLoginForm()
//    {
//        $this->browse(function (Browser $browser) {
//            $browser
//                ->driver->manage()->deleteAllCookies();
//            $browser->visit('/login')
//                    ->assertSee('Login');
//        });
//    }
//
//    public function testLoginAwait()
//    {
//        $password = 11111111;
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_WAIT,
//            'password'=>bcrypt($password),
//            'email_verified_at'=>null]);
//
//
//        $this->browse(function (Browser $browser) use ($user, $password) {
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $text = $browser
//                ->visit('/login')
//                ->assertSee('Password')
//                ->assertSee('E-Mail Address')
//                ->type('email', $user->email)
//                ->type('password', $password)
//                ->press('Login')
//
//                ->assertPathIs('/email/verify');
//            $user->delete();
//        });
//    }
//    public function testLoginActive()
//    {
//        $password = 11111111;
//
//        $user = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'email_verified_at'=>Carbon::now()]);
//
//        $this->browse(function (Browser $browser) use ($user, $password) {
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser->loginAs($user)
//                ->visit('/cabinet')
//                ->assertSee('Profile');
//            $user->delete();
//        });
//    }
//    public function testLogout()
//    {
//        $password = 11111111;
//
//        $user1 = factory(User::class)->create([
//            'status'=>User::STATUS_ACTIVE,
//            'password'=>bcrypt($password),
//            'email_verified_at'=>Carbon::now()]);
//
//        $this->browse(function ($browser1) use ($password, $user1) {
//            $browser1
//                ->driver->manage()->deleteAllCookies();
//
//            $browser1->loginAs($user1)
//                ->visit('/')
//                ->clickLink($user1->name)
//                ->assertSee('Logout')
//                ->clickLink('Logout')
//                ->assertSee('Login');
//            $user1->delete();
//        });
//    }
//    public function testLoginFacebook()
//    {
//        $this->browse(function ($browser) {
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->visit('/login')
//                ->clickLink('Login Facebook');
//
//            $url = $browser->driver->getCurrentURL();
//            $str = strstr($url, "facebook.com");
//            $this->assertTrue(strlen($str) ? true: false);
//        });
//    }
}
