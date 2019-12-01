<?php

namespace App\Jobs;

use App\Entity\Adverts\Advert\Advert;
use App\Notifications\AdvertPromotion;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ClickAdvert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Advert
     */
    private $advert;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Advert $advert)
    {
        $this->advert = $advert;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->advert->click === 1){
            $this->advert->click = 0;
            $this->advert->promotion = 0;
            $this->advert->save();
            $this->advert->user->notify(new AdvertPromotion($this->advert));
            return;
        }
        if($this->advert->click < 1){
            if($this->advert->promotion){
                $this->advert->click = 0;
                $this->advert->promotion = 0;
                $this->advert->save();
                $this->advert->user->notify(new AdvertPromotion($this->advert));
                return;
            }
            return;
        }
        echo $this->advert->click;
        $this->advert->click = $this->advert->click-1;
        $this->advert->save();
    }
}
