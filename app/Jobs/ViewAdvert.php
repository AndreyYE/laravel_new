<?php

namespace App\Jobs;

use App\Entity\Adverts\Advert\Advert;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ViewAdvert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $id_advert;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id_advert)
    {
        //
        $this->id_advert = $id_advert;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $advert = Advert::findOrFail($this->id_advert);
        $advert->view ?
            $advert->view = $advert->view+1
            :
            $advert->view=1;
        $advert->save();
    }
}
