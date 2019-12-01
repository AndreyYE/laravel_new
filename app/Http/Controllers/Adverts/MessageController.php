<?php

namespace App\Http\Controllers\Adverts;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\User;
use App\Http\Requests\Adverts\MessageRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
   public function form(Request $request)
   {
       $advert = Advert::findOrFail($request->input('advert'));
       return view('adverts.message.create',compact('advert'));
   }
   public function send(Advert $advert, MessageRequest $request)
   {
       $message =  $request->input('message');
       $client_id = \Auth::id();
       $advert->writeClientMessage($client_id, $message);
       return redirect()->route('adverts.show',['advert'=>$advert]);
   }
}
