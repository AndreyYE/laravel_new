<?php

namespace App\Http\Controllers\Cabinet\Promo;

use App\Entity\Adverts\Advert\Advert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {
        $adverts = Advert::where('user_id',\Auth::id())->where('click','>',0)->where('promotion',1)->paginate(10);

        return view('cabinet.promo.index',compact('adverts'));
    }

    public function create(Advert $advert)
    {
        return view('cabinet.promo.create_promo',compact('advert'));
    }
    public function pay(Advert $advert, Request $request)
    {
        try{
            $clicks = $request->input('quantity');
            $advert->click = $clicks;
            $advert->promotion = 1;
            $advert->save();
        }catch (\DomainException $exception){
            return redirect()->back()->withErrors(['error'=>$exception->getMessage()]);
        }
        return redirect()->route('cabinet.adverts.index');
    }
}
