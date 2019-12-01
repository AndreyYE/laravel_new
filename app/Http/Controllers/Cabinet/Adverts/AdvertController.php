<?php

namespace App\Http\Controllers\Cabinet\Adverts;

use App\Entity\Adverts\Advert\Advert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvertController extends Controller
{
    public function index()
    {
        $adverts = Advert::ForUser(\Auth::id())->orderBy('id','desc')->paginate(20);
        return view('cabinet.adverts.index', compact('adverts'));
    }
}
