<?php

namespace App\Http\Controllers\Adverts;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Advert\Photo;
use App\Entity\Adverts\Attribute;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Http\Router\AdvertsPath;
use App\Jobs\ClickAdvert;
use App\Jobs\DeletePhotosAdvert;
use App\Jobs\ViewAdvert;
use App\Services\Search\AdvertIndexer;
use App\Services\Search\SearchService;
use Elasticsearch\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Nexmo\Call\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class AdvertController extends Controller
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var AdvertIndexer
     */
    private $advertIndexer;
    /**
     * @var SearchService
     */
    private $searchService;

    public function __construct(Client $client, AdvertIndexer $advertIndexer, SearchService $searchService)
    {

        $this->client = $client;
        $this->advertIndexer = $advertIndexer;
        $this->searchService = $searchService;
    }

   public function show(Advert $advert)
   {
       if(!($advert->isActive() || \Gate::allows('show-advert', $advert))){
           return abort(403);
       }
       $user = \Auth::user();
       $advert_adverts = $this->searchService->search_advert_adverts($advert)['hits']['hits'];
       $similar_adverts = $this->searchService->search_similar_adverts($advert)['hits']['hits'];
       return view('adverts.show', compact('advert','user','advert_adverts','similar_adverts'));
   }

    public function phone(Advert $advert): string
    {
        if (!($advert->isActive() || \Gate::allows('show-advert', $advert))) {
            abort(403);
        }
        return $advert->user->phone;
    }

    public function index(Request $request, $category, $region)
    {
        $cat = Category::findOrFail($category);
        $categories = Category::where('parent_id', $cat->id)->get();

        $allCategories = Cache::tags(['allCategories'])->rememberForever('allCategories',function(){
            return Category::defaultOrder()->withDepth()->get();
        });
        $allRegions = Cache::tags(['allRegions'])->rememberForever('allRegions',function(){
            return Region::all()->groupBy('parent_id');
        });
        $AllAttributes = $cat->AllAttributes();
        $attributes = collect();
        foreach ($AllAttributes as $val){
            $merge = $attributes->merge($val);
            $attributes = collect($merge->all());
        }
        $selected_attributes = $request->except('region','category');

        $region = is_numeric($region) ? Region::findOrFail($region):'';

        $pagination = $request->query('pagination') ? $request->query('pagination') : 1;
        $search = $request->query('search');
        $sort = $request->query('sort');
        $price = explode(";",$request->query('price'));


        $results = $this->searchService->search($request, $category,$region,20,$pagination);
        $adverts = $results[0];
        $max_price = $results[1];
            return view('adverts.allAdverts', compact('category', 'categories', 'attributes','selected_attributes',
                'adverts', 'allCategories', 'allRegions', 'region','search','sort','pagination', 'price', 'max_price'));

    }
    public function search(Request $request)
    {
       $search = $request->search;
       $adverts = Advert::where('title','like', '%'.$search.'%')->with('category')->get();
       return $adverts;
    }

    public function changeCategory(Request $request){
        return Category::findOrFail($request->input('category'))->AllAttributes();
    }
    public function clickAdvert(Advert $advert)
    {
        if($advert->promotion && $advert->click>0){
            ClickAdvert::dispatch($advert);
        }
    }
    public function view(Advert $advert)
    {
        ViewAdvert::dispatch($advert->id);
    }
    public function flashMessage(Request $request)
    {
        $request->session()->flash('error', 'Пожалуйста сперва войтиде в приложение');
        return 'ok';
    }

}
