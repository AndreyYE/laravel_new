<?php

namespace App\Http\Controllers\Cabinet;

use App\Entity\User;
use App\Services\Sms\SmsSender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhoneController extends Controller
{
    private $sms;
    public function __construct(SmsSender $sms)
    {
        $this->sms = $sms;
    }

    public function request(Request $request)
    {

       $user = \Auth::user();
       try{
           $token = $user->requestPhoneVerification(Carbon::now());
           if($token){
               $text = 'Your token - '.$token.'. He is actioning during 300 seconds';
               $this->sms->send($user->phone, $text);
           }
       }catch(\DomainException $exceptione)
       {
             $request->session()->flash('error', $exceptione->getMessage());
       }
       return redirect()->route('cabinet.profile.phone');
    }

    public function form()
    {
        $user = \Auth::user();
        return view('cabinet.profile.phone', compact('user'));
    }

    public function verify(Request $request)
    {
        $request->validate([
           'token' => 'required|string|max:255',
        ]);
        try{
            $user = \Auth::user();
            $user->verifyPhone($request->token, Carbon::now());
        }catch (\DomainException $exception){
            return redirect()->route('cabinet.profile.phone')->with('error', $exception->getMessage());
        }
        return redirect()->route('cabinet.profile.index');
    }

    public function auth(Request $request)
    {
        $user = \Auth::user();
        $auth = $user->phone_auth;
        if($auth){
            $user->phone_auth = false;
            $user->save();
            return redirect()->route('cabinet.profile.index');
        }
        $user->phone_auth = true;
        $user->save();
        return redirect()->route('cabinet.profile.index');
    }
}
