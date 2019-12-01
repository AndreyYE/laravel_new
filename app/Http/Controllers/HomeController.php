<?php

namespace App\Http\Controllers;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Jobs\ViewAdvert;
use Elasticsearch\Client;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {

        $this->client = $client;
    }

    public function index()
    {
        $categories = Category::whereIsRoot()->defaultOrder()->getModels();
        $allRegions = \Cache::tags(['allRegions'])->rememberForever('allRegions',function(){
            return Region::all()->groupBy('parent_id');
        });
        $allCategories = \Cache::tags(['allCategories'])->rememberForever('allCategories',function(){
            return Category::defaultOrder()->withDepth()->get();
        });
        $parameter =
            [
              'index'=>'app',
               'body'=>[
                   "size"=>10,
                   'sort'=>[
                       'view'=>["order" => "desc"]
                   ],
                   "query"=>  [
                       "bool" => [
                           "must" => [
                               [ "term" => ["status" => 'active'] ],
                           ],],]
               ],
            ];
        $most_popular_adverts = $this->client->search($parameter);
        return view('adverts.index2', compact('categories','most_popular_adverts','allRegions','allCategories'));
    }
}
