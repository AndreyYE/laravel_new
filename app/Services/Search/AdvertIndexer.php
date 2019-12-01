<?php
namespace App\Services\Search;
use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Advert\Value;
use App\Entity\Adverts\Category;
use Elasticsearch\Client;
class AdvertIndexer
{
    private $client;
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    public function clear(): void
    {
        $this->client->deleteByQuery([
            'index' => 'app',
            'body' => [
                'query' => [
                    'match_all' => new \stdClass(),
                ],
            ],
        ]);
    }
    public function index(Advert $advert): void
    {
        $regions = $advert->region->getAllParent();
        $allRegions = explode(",", $regions);
        array_shift($allRegions);

        $descendantsAndSelfRegions = $advert->region->allChildren();
        $allCategories = Category::ancestorsAndSelf($advert->category->id)->pluck('id')->toArray();

        $value = [];

        foreach (Value::where('advert_id',$advert->id)->get() as $val)
        {

            array_push($value, [
                'attribute'=>$val->attribute_id,
                'value_number'=>is_numeric($val->value) ? (int)$val->value : null,
                'value_string'=>is_numeric($val->value) ? null : $val->value,
            ]);
        }
        $response = $this->client->index([
            'index'=>'app',
            'type'=>'adverts',
            'id'=>$advert->id,
            'body'=>[
                'id'=>$advert->id,
                'published_at'=>$advert->published_at ? $advert->published_at->format(DATE_ATOM) : null,
                'title'=>$advert->title,
                'content'=>$advert->content,
                'price'=>$advert->price,
                'status'=>$advert->status,
                'categories'=>$allCategories,
                'regions'=>$allRegions,
                'region_promotion'=>$descendantsAndSelfRegions,
                'photo'=>$advert->photos->pluck('file')->toArray(),
                'view'=>$advert->view,
                'click'=>$advert->click,
                'promotion'=>$advert->promotion ? true : false,
                'values' =>$value
            ]
        ]);
    }
    public function remove(Advert $advert): void
    {
        $this->client->delete([
            'index' => 'app',
            'id' => $advert->id,
        ]);
    }
}
