<?php

namespace App\Observers;

use App\Entity\Adverts\Advert\Advert;
use App\Jobs\DeletePhotosAdvert;
use App\Services\Search\AdvertIndexer;


class AdvertObserver
{
    /**
     * @var AdvertIndexer
     */
    private $advertIndexer;

    public function __construct(AdvertIndexer $advertIndexer)
    {
        $this->advertIndexer = $advertIndexer;
    }

    /**
     * Handle the advert "created" event.
     *
     * @param  \App\Entity\Adverts\Advert\Advert  $advert
     * @return void
     */
    public function created(Advert $advert)
    {
        $this->advertIndexer->index($advert);
    }

    /**
     * Handle the advert "updated" event.
     *
     * @param  \App\Entity\Adverts\Advert\Advert  $advert
     * @return void
     */
    public function updated(Advert $advert)
    {
        $this->advertIndexer->index($advert);
    }

    /**
     * Handle the advert "deleted" event.
     *
     * @param  \App\Entity\Adverts\Advert\Advert  $advert
     * @return void
     */
    public function deleted(Advert $advert)
    {
        //delete advert from elasticsearch
        $this->advertIndexer->remove($advert);
        //delete dialogs
        if($advert->dialogs){
            foreach ($advert->dialogs as $dialog){
                $dialog->delete();
            };
        }
        //delete photos from your storage
        $photos = [];
        foreach ($advert->photos as $val){
            array_push($photos, $val->file);
        }
        DeletePhotosAdvert::dispatch($photos);
    }

    /**
     * Handle the advert "restored" event.
     *
     * @param  \App\Entity\Adverts\Advert\Advert  $advert
     * @return void
     */
    public function restored(Advert $advert)
    {

    }

    /**
     * Handle the advert "force deleted" event.
     *
     * @param  \App\Entity\Adverts\Advert\Advert  $advert
     * @return void
     */
    public function forceDeleted(Advert $advert)
    {

    }
}
