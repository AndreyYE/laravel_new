<?php

namespace App\Console\Commands\Advert;

use App\Entity\Adverts\Advert\Advert;
use App\UseCases\Adverts\AdvertService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireCommand extends Command
{

    protected $signature = 'advert:expire';


    protected $description = 'Check expire adverts';
    /**
     * @var AdvertService
     */
    private $service;

    public function __construct(AdvertService $service)
    {
        parent::__construct();

        $this->service = $service;
    }


    public function handle(): bool
    {
        $success = true;
        foreach (Advert::active()->where('expires_at','<',Carbon::now())->cursor() as $advert)
        {
            try{
                $this->service->expire($advert);
            }catch (\DomainException $exception){
                $this->error($exception->getMessage());
                $success = false;
            }
        }
       return $success;
    }
}
