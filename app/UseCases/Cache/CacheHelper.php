<?php


namespace App\UseCases\Cache;

use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    /**
     * @param array $tags
     * @return void
     */
    public function cacheFlush(array $tags)
    {
        foreach ($tags as $tag){
            Cache::tags($tag)->flush();
        }
    }
}
