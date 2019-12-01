<?php
namespace App\Console\Commands\Search;
use App\Entity\Adverts\Advert\Advert;
//use App\Entity\Banner\Banner;
use App\Services\Search\AdvertIndexer;
//use App\Services\Search\BannerIndexer;
use Illuminate\Console\Command;
class ReindexCommand extends Command
{
    protected $signature = 'search:reindex';
    private $adverts;
    public function __construct(AdvertIndexer $adverts)
    {
        parent::__construct();
        $this->adverts = $adverts;
    }

    public function handle(): bool
    {
        $this->adverts->clear();
        foreach (Advert::orderBy('id')->cursor() as $advert) {
            $this->adverts->index($advert);
        }
//        $this->banners->clear();
//        foreach (Banner::active()->orderBy('id')->cursor() as $banner) {
//            $this->banners->index($banner);
//        }
        return true;
    }
}
