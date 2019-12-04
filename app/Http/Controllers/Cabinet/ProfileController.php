<?php

namespace App\Http\Controllers\Cabinet;

use App\Entity\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user =  Auth::user();
        return view('cabinet.profile.home', compact('user'));
    }

    public function edit()
    {
         $user = Auth::user();
        return view('cabinet.profile.edit',compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $oldPhone = $user->phone;
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'size:11',
                Rule::unique('users')->ignore($user->id),
            ]
        ]);
        $user->update($request->only('name','last_name','phone'));

        if($oldPhone!==$user->phone){
            $user->unverifyPhone();
        }
        return redirect()->route('cabinet.profile.index');
    }
}
