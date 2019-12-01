<?php

namespace App\Entity\Adverts\Advert\Dialog;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\User;
use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{
    protected $table = 'dialogs';
    protected $guarded = ['id'];

    public function writeMessageByOwner(int $userId, string $message): void
    {
        $this->messages()->create([
            'user_id' => $userId,
            'message' => $message,
        ]);
        $this->client_new_messages++;
        $this->save();
    }
    public function writeMessageByClient(int $userId, string $message): void
    {
        $this->messages()->create([
            'user_id' => $userId,
            'message' => $message,
        ]);
        $this->user_new_messages++;
        $this->save();
    }
    public function readByOwner(): void
    {
        $this->update(['user_new_messages' => 0]);
    }
    public function readByClient(): void
    {
        $this->update(['client_new_messages' => 0]);
    }
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }
    public function advert()
    {
        return $this->belongsTo(Advert::class, 'advert_id', 'id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class, 'dialog_id', 'id');
    }
}
