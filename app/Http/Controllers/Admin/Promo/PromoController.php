<?php

namespace App\Http\Controllers\Admin\Promo;

use App\Entity\Adverts\Advert\Advert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $click_sort_min = $request->input('options1');
        $click_sort_max = $request->input('options2');
        $query = Advert::where('click','>',0)->where('promotion',1);
        if($id){
            $query->where('id', $id);
        }
        elseif ($title){
            $query->where('title','like', "%".$title."%");
        }
        elseif ($click_sort_min){
            $query->orderBy('click');
        }
        elseif ($click_sort_max){
            $query->orderBy('click','desc');
        }
        $adverts = $query->paginate(10);
        return view('admin.promo.index',compact('adverts','request'));
    }

    public function create(Advert $advert)
    {
        return view('admin.promo.create_promo',compact('advert'));
    }

    public function store(Advert $advert, Request $request)
    {
        try {
            $advert->click = $request->input('quantity');
            $advert->promotion = 1;
            $advert->save();
            return redirect()->route('admin.advert.adverts.index');
        }catch (\DomainException $exception){
            return redirect()->back()->withErrors('error', $exception->getMessage());
        }
    }

    public function close(Advert $advert)
    {
        try {
            $advert->click = 0;
            $advert->promotion = 0;
            $advert->save();
        }catch (\DomainException $exception){
            return redirect()->back()->withErrors('error', $exception->getMessage());
        }
    }
    public function edit(Advert $advert)
    {
        return view('admin.promo.edit',compact('advert'));
    }
    public function saveEdit(Advert $advert, Request $request)
    {
        try{
            $advert->click = $request->input('quantity');
            $advert->save();
            return redirect()->route('admin.promo.index');
        }
        catch (\DomainException $exception){
            return redirect()->back()->withErrors('error',$exception->getMessage());
        }
    }
}
