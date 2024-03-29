<?php

namespace App\Entity\Adverts\Advert\Dialog;

use App\Entity\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
