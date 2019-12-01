<?php

namespace App\Http\Controllers\Cabinet;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Advert\Dialog\Dialog;
use App\Http\Requests\Adverts\MessageRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::id();
        $allDialogs = Dialog::where('user_id',$user)->orWhere('client_id',$user)->with(['client','messages','advert'])->get();
        return view('cabinet.message.index',compact('allDialogs'));
    }

    public function delete(Request $request)
    {
        Dialog::destroy($request->input('id'));
        return redirect()->back();
    }

    public function send(Dialog $dialog, MessageRequest $request)
    {
        $message =  $request->input('message');
        $user_id = \Auth::id();
        if($user_id == $dialog->advert->user->id){
            $dialog->advert->writeOwnerMessage($dialog->client_id, $message);
        }else{
            $dialog->advert->writeClientMessage($user_id, $message);
        }
        return redirect()->back();
    }

    public function showAllMessages(Request $request)
    {
        $user_id = \Auth::id();
        $dialog = Dialog::findOrFail($request->input('dialog'));
        /*Read messages*/
        $user_id == $dialog->user_id ? $dialog->readByOwner() : $dialog->readByClient();
        $dialog = Dialog::where('id', $request->input('dialog'))->with(['messages','advert'])->get();
        return view('cabinet.message.allMessages',compact('dialog'));
    }
}
