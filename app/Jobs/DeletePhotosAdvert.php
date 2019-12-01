<?php

namespace App\Jobs;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Advert\Photo;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

class DeletePhotosAdvert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Advert
     */
    private $photos;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($photos)
    {

        $this->photos = $photos;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->photos as $photo){
           Storage::disk('public_public')->delete($photo);
           \Log::info($photo);
        }
    }
}
