<?php


namespace App\Services\Search;



use App\Entity\Adverts\Advert\Advert;
use Elasticsearch\Client;

class SearchService
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {

        $this->client = $client;
    }

    public function search($request, $category, $region, $numberElements, $currentPage)
    {
        $sort =[];

        switch ($request->query('sort')) {
            case 1:
                array_push($sort,['published_at'=>['order'=>'desc']]);
                break;
            case 2:
                array_push($sort,['price'=>['order'=>'asc']]);
                break;
            case 3:
                array_push($sort,['price'=>['order'=>'desc']]);
                break;
            default :
                array_push($sort,['published_at'=>['order'=>'desc']]);
        }

        $selected_attributes = $request->query->all();
        $values =[];
        foreach ($selected_attributes as $k=>$v)
        {
            if(is_numeric($k) && $v){
                $val = explode(";", $v);
                if(count($val)===2 and is_numeric($val[0]) and is_numeric($val[1])){
                    array_push($values,['nested'=>
                        [
                            'path'=>'values',
                            'query'=>[
                                'bool'=>[
                                    'must'=>[
                                        ['match'=>['values.attribute'=>$k]],
                                        ['range'=>['values.value_number'=>[   "gte" => $val[0], "lte" => $val[1]  ]]]
                                    ]
                                ]
                            ]
                        ],]);
                }

                else {
                    array_push($values,['nested'=>
                        [
                            'path'=>'values',
                            'query'=>[
                                'bool'=>[
                                    'must'=>[
                                        ['match'=>['values.attribute'=>$k]],
                                        is_numeric($v) ? ['match'=>['values.value_number'=>(int)$v]] : ['match'=>['values.value_string'=>$v]]
                                    ]
                                ]
                            ]
                        ],]);
                }

            }
        }

        $must = [];
        array_push($must, ['term' => ['categories' => (int)$category]]);
        array_push($must, ['term' => ['status' => 'active']]);
        if($region){
            array_push($must, ['term' => ['regions' => $region->id]]);
        }
        if($request->query('search')){
            array_push($must,
                ['multi_match'=>[
                    'query'=>$selected_attributes['search'],
                    'fields'=> ['title^3','content']
                ]]);
        }
        $price = explode(";",$request->query('price'));
        if($request->query('price')){
            array_push($must,
                ['range'=>[
                    'price'=>[
                     'gte'=> $price[0],
                        'lte'=> $price[1]
                    ]
                ]]);
        }
        $params = ['index'=>'app','type'=>'adverts',
            'body'=>[
                'sort'=>$sort,
                "from" => $numberElements*($currentPage-1),
                "size" => $numberElements,
                "query"=>  [
                    'bool'=>[
                        'must'=>[
                            array_merge($must, $values)
                        ]
                    ]
                ],
                'aggs'=>[
                    'group_by_region'=>[
                        'terms'=>['field'=>'regions']
                    ],
                    'group_by_category'=>[
                        'terms'=>['field'=>'categories']
                    ],
                    'max_price'=>[
                        'max'=>[
                            'field'=>'price'
                        ]
                    ]
                ]
                ]
        ];

        $params1 = ['index'=>'app',
            'body'=>[
                "query"=>  [
                    'bool'=>[
                        'must'=>[
                            'term' => ['categories' => (int)$category]
                        ]
                    ]
                ],
                'aggs'=>[
                    'max_price'=>[
                        'max'=>[
                            'field'=>'price'
                        ]
                    ]
                ]
            ]
        ];
        $results = $this->client->search($params);
        $max_price = $this->client->search($params1);
        return [$results,$max_price['aggregations']['max_price']['value']];
    }

    public function search_advert_adverts(Advert $advert) : array
    {
        $params = [
            'index' => 'app',
            'id'    => $advert->id
        ];
        $results = $this->client->get($params);
        $category = $results['_source']['categories'][count($results['_source']['categories'])-1];
        $region = $results['_source']['regions'][count($results['_source']['regions'])-1];

       $params1 =
         [
          'index'=>'app',
           'body'=>[
               'size'=>2,
               'sort'=>['click'=>'desc'],
            "query"=>  [
             "bool" => [
                "must" => [
                    [ "term" => ["categories" => $category] ],
                    [ "term" => ["region_promotion" => $region] ],
                    [ "term" => ["promotion" => true] ],
                    [ "term" => ["status" => 'active'] ],
                    [ "range" => ["click" => ['gte'=>0]] ],
                ],
                 'must_not' =>[
                     [ "term" => ["id" => $advert->id] ],
                 ]
             ]
           ]]
         ];

         $results1 = $this->client->search($params1);
        return $results1;
    }
    public function search_similar_adverts(Advert $advert)
    {
        $params = [
            'index' => 'app',
            'id'    => $advert->id
        ];
        $results = $this->client->get($params);
        $category = $results['_source']['categories'][count($results['_source']['categories'])-1];
        $region = $results['_source']['regions'][count($results['_source']['regions'])-1];
        $params1 =
            [
                'index'=>'app',
                'body'=>[
                    'size'=>3,
                    'sort'=>['published_at'=>'desc'],
                    "query"=>  [
                        "bool" => [
                            "must" => [
                                [ "term" => ["categories" => $category] ],
                                [ "term" => ["regions" => $region] ],
                                [ "term" => ["status" => 'active'] ],
                            ],
                            'must_not' =>[
                                [ "term" => ["id" => $advert->id] ],
                            ]
                        ]
                    ]]
            ];

        $results1 = $this->client->search($params1);
        return $results1;
    }
}
