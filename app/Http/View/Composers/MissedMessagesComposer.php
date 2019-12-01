<?php


namespace App\Http\View\Composers;

use App\Entity\Adverts\Advert\Dialog\Dialog;
use App\Entity\Page;
use Illuminate\View\View;

class MissedMessagesComposer
{
    public function compose(View $view)
    {
        $user_id = \Auth::id();
        $dialog = Dialog::where([
            ['user_id',$user_id],
            ['user_new_messages','>',0]
        ])->orWhere([
            ['client_id',$user_id],
            ['client_new_messages','>',0]
        ])->getModels();
        $view->with('missedMessages', count($dialog));
    }
}
