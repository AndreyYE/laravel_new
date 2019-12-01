<?php


namespace App\UseCases\Profile;


use App\Entity\User;
use App\Http\Requests\Cabinet\ProfileEditRequest;

class ProfileService
{
    public function update(ProfileEditRequest $request):void
    {
        $user_change = User::findOrFail($request->user()->id);
        $user_change->name = $request->input('name');
        $user_change->last_name = $request->input('last_name');
        $user_change->phone = $request->input('phone');
        $user_change->save();
    }
}
