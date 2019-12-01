<?php

namespace App\Observers;

use App\Entity\Adverts\Category;
use App\UseCases\Cache\CacheHelper;

class CategoryObserver
{
    private $cache;

    public function __construct(CacheHelper $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Handle the category "created" event.
     *
     * @param  \App\Entity\Adverts\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        $this->cache->cacheFlush([
            ['CategoryAncestors'],
            ['allCategories'],
            ['allCategoryChildren']
            ]);
    }

    /**
     * Handle the category "updated" event.
     *
     * @param  \App\Entity\Adverts\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        $this->cache->cacheFlush([
            ['CategoryAncestors'],
            ['allCategories'],
            ['allCategoryChildren']
        ]);
        //\Artisan::call('search:init');
    }

    /**
     * Handle the category "deleted" event.
     *
     * @param  \App\Entity\Adverts\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        $this->cache->cacheFlush([
            ['CategoryAncestors'],
            ['allCategories'],
            ['allCategoryChildren']
        ]);
        //\Artisan::call('search:init');
    }

    /**
     * Handle the category "restored" event.
     *
     * @param  \App\Entity\Adverts\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the category "force deleted" event.
     *
     * @param  \App\Entity\Adverts\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}
