<?php

namespace App\Observers;

use App\Entity\Region;
use App\UseCases\Cache\CacheHelper;

class RegionObserver
{
    private $cache;

    public function __construct(CacheHelper $cache)
    {
        $this->cache = $cache;
    }
    /**
     * Handle the region "created" event.
     *
     * @param  \App\Entity\Region  $region
     * @return void
     */
    public function created(Region $region)
    {
        $this->cache->cacheFlush([
            ['allRegions'],
            ['allRegionChildren'],
            ['RegionAncestors']
        ]);
    }

    /**
     * Handle the region "updated" event.
     *
     * @param  \App\Entity\Region  $region
     * @return void
     */
    public function updated(Region $region)
    {
        $this->cache->cacheFlush([
            ['allRegions'],
            ['allRegionChildren'],
            ['RegionAncestors']
        ]);
        \Artisan::call('search:init');
    }

    /**
     * Handle the region "deleted" event.
     *
     * @param  \App\Entity\Region  $region
     * @return void
     */
    public function deleted(Region $region)
    {
        $this->cache->cacheFlush([
            ['allRegions'],
            ['allRegionChildren'],
            ['RegionAncestors']
        ]);
        \Artisan::call('search:init');
    }

    /**
     * Handle the region "restored" event.
     *
     * @param  \App\Entity\Region  $region
     * @return void
     */
    public function restored(Region $region)
    {
        //
    }

    /**
     * Handle the region "force deleted" event.
     *
     * @param  \App\Entity\Region  $region
     * @return void
     */
    public function forceDeleted(Region $region)
    {
        //
    }
}
