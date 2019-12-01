<?php


namespace App\Services\Serialize;


use App\Entity\User;

class SerializeUser
{
 public function serialize(User $user)
 {
     return [
       'id'=>$user->id,
     ];
 }
}
