<?php
namespace App\UseCases\Auth;

use App\Entity\User;

class RegisterServis
{
    public function verify($id)
    {
       $user = User::find($id);
       $user->verify();
       // Нужно дописать отправу письма через очередь
    }
}
