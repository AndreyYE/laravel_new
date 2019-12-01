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
    public function elastic()
    {

//               $params =
// [
//                  'index'=>'app','type'=>'adverts',
//                   'body'=>[
//                   "query"=>  [
//                    "nested" => [
//                    "path" => "values",
//                    "query" => [
//                     "bool" => [
//                    "must" => [
//                    [ "match" => ["values.attribute" => 11] ],]
//                ]
//            ]
//        ]
//    ]]
//                   ];
//
       // $results = $this->client->search($params);
      //  dd($results);
//        $params = [
//            'index' => 'app',
//            'id'    => 25
//        ];
        //$this->client->delete($params);
//        $results = $this->client->get($params);
//        dd($results);
//        $advert = Advert::findOrFail(28);
//        $advert->title = 'slider advert 5 update';
//        $advert->save();
        //return ['name'=>'board'];
//        $adverts = Advert::where('user_id',784)->whereHas('favorites', function (Builder $query) {
//            $query->where('user_id', 784);
//        })->with('favorites','user','category', 'region')->get();
//        return $adverts;
//        Storage::disk('public_public')->delete('images/adverts/'.$this->advert);
        //Storage::disk('public_public')->delete(Photo::find(32)->file);
        //DeletePhotosAdvert::dispatch(Photo:);
//        foreach (Advert::find(47)->photos as $photo){
//            Storage::disk('public_public')->delete($photo->file);
//        }
//        $photos =Advert::find(36)->photos;
//        $value = [];
//        foreach ($photos as $val){
//            array_push($value, $val->file);
//        }
//        DeletePhotosAdvert::dispatch($value);
//        $client = new \GuzzleHttp\Client();
//        $url = 'https://api.privatbank.ua/p24api/pay_pb';
//        $oper = 'cmt';
//        $wait = 0;
//        $test = 1;
//        $payment = 1234567;
//        $card = 4627081718568608;
//        $amt = 1;
//        $ccy = 'UAH';
//        $details = 'test%20merch%20not%20active';
//        $data = '<oper>cmt</oper>
//                    <wait>0</wait>
//                    <test>1</test>
//                    <payment id="1234567">
//                        <prop name="b_card_or_acc" value="4627081718568608" />
//                        <prop name="amt" value="1" />
//                        <prop name="ccy" value="UAH" />
//                        <prop name="details" value="test%20merch%20not%20active" />
//                    </payment>';
//        $pass = '3A90E5J0f6OUIfqN1Qu59gYrjDgDblfL';
//        $sign=sha1 (md5($oper.$wait.$test.$payment.$card.$amt.$ccy.$details.$pass));
//        $xml = "
//         <request version='1.0'>
//                <merchant>
//                    <id>75482</id>
//                    <signature>557bfc30c19dbb7f50a2afe18c3c4e44d60b47a3</signature>
//                </merchant>
//                <data>
//                    <oper>cmt</oper>
//                    <wait>0</wait>
//                    <test>1</test>
//                    <payment id='1234567'>
//                        <prop name='b_card_or_acc' value='4627081718568608' />
//                        <prop name='amt' value='1' />
//                        <prop name='ccy' value='UAH' />
//                        <prop name='details' value='test%20merch%20not%20active' />
//                    </payment>
//                </data>
//            </request>
//        ";
//        $options = [
//            'headers' => [
//                'Content-Type' => 'text/xml; charset=UTF8',
//            ],
//            'body' => $xml,
//        ];
//        $result = $client->request('POST', $url, $options);
//        return $result;
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
}
