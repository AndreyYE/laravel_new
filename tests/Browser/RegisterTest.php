<?php

namespace Tests\Browser;

use App\Entity\User;
use Carbon\Carbon;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends DuskTestCase
{

//    public function testRegister()
//    {
//        $password = '11111111';
//        $user = factory(User::class)->make([
//            'status'=>User::STATUS_WAIT,
//            'password'=>bcrypt($password),
//            'email_verified_at'=>null]);
//        $this->browse(function (Browser $browser) use ($password, $user){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//            $browser->visit('/register')
//                    ->type('name', $user->name)
//                    ->type('email', $user->email)
//                    ->type('password', $password)
//                    ->type('password_confirmation', $password)
//                    ->press('Register')
//                    ->assertPathIs('/email/verify');
//        });
//    }
//    public function testRegisterUserAlreadyExist()
//    {
//        $password = '11111111';
//
//        $user = factory(User::class)->make([
//            'status'=>User::STATUS_WAIT,
//            'password'=>bcrypt($password),
//            'email_verified_at'=>null]);
//
//        $this->browse(function (Browser $browser) use ($password, $user){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//            $browser
//                ->visit('/register')
//                ->type('name', $user->name)
//                ->type('email', $user->email)
//                ->type('password', $password)
//                ->type('password_confirmation', $password)
//                ->press('Register')
//                ->assertPathIs('/email/verify')
//                ->clickLink($user->name)
//                ->clickLink('Logout')
//                ->visit('/register')
//                ->type('name', $user->name)
//                ->type('email', $user->email)
//                ->type('password', $password)
//                ->type('password_confirmation', $password)
//                ->press('Register')
//                ->assertPathIs('/register')
//                ->assertSee('The email has already been taken.')
//                ->logout();
//        });
//    }
//    public function testRegisterErrorConfirmPassword()
//    {
//        $password = '11111111';
//        $user = factory(User::class)->make([
//            'status'=>User::STATUS_WAIT,
//            'password'=>bcrypt($password),
//            'email_verified_at'=>null]);
//
//        $this->browse(function (Browser $browser) use ($password, $user){
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser->visit('/register')
//                ->type('name', $user->name)
//                ->type('email', $user->email)
//                ->type('password', $password)
//                ->type('password_confirmation', '1111111111111')
//                ->press('Register')
//                ->assertPathIs('/register')
//                ->assertSee('The password confirmation does not match.');
//        });
//    }
//
//    public function testRegisterFacebook()
//    {
//        $this->browse(function ($browser) {
//            $browser
//                ->driver->manage()->deleteAllCookies();
//
//            $browser
//                ->visit('/register')
//                ->clickLink('Login Facebook');
//
//            $url = $browser->driver->getCurrentURL();
//            $str = strstr($url, "facebook.com");
//            $this->assertTrue(strlen($str) ? true: false);
//        });
//    }
}
