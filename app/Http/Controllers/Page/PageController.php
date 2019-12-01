<?php

namespace App\Http\Controllers\Page;

use App\Entity\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
   public function show(Request $request)
   {
       $id = $request->input('id');
       $page = Page::where('id',$id)->with('descendants')->get();
       return view('page',compact('page'));
   }
}
