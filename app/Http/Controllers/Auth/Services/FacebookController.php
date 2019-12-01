<?php

namespace App\Http\Controllers\Auth\Services;

use App\Entity\Network\Network;
use App\Entity\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try{
            $user = Socialite::driver('facebook')->user();
            $network = User::where('email',$user->getEmail())->first();
            if($network){
                \Auth::login($network);
            }else{
                \DB::transaction(function () use($user){
                    $name = explode(" ", $user->getName());
                    $email = $user->getEmail();

                    $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $number = '0123456789';
                    $password = substr(str_shuffle($string.strtolower($string).$number),8,15);

                    $new_user = new User;
                    $new_user->name = $name[0];
                    $new_user->last_name =  $name[1] ? $name[1] : null;
                    $new_user->email = $email;
                    $new_user->status = 'wait';
                    $new_user->role = 'user';
                    $new_user->password = \Hash::make($password);
                    $new_user->save();

                    $new_network = new Network;
                    $new_network->network = 'facebook';
                    $new_network->identity = $password;
                    $new_user->network()->save($new_network);
                    \Auth::login($new_user);
                });
            }
        }catch (\DomainException $exception){
            return redirect()->intended()->with('error', $exception->getMessage());
        }
        return  redirect()->route('cabinet.profile.index');
    }
}
