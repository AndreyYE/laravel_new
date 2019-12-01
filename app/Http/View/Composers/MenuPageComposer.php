<?php


namespace App\Http\View\Composers;

use App\Entity\Page;
use Illuminate\View\View;

class MenuPageComposer
{
    public function compose(View $view)
    {
        $view->with('menuPages', Page::whereIsRoot()->defaultOrder()->getModels());
    }
}
