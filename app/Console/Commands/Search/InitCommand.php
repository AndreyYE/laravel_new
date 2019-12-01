<?php

namespace App\Console\Commands\Search;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Advert\Value;
use App\Entity\Adverts\Category;
use App\Services\Search\AdvertIndexer;
use Carbon\Carbon;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Console\Command;
use test\Mockery\MockingVariadicArgumentsTest;

class InitCommand extends Command
{

    protected $signature = 'search:init';


    protected $description = 'init search elasticsearch';
    /**
     * @var Client
     */
    private $client;
    /**
     * @var AdvertIndexer
     */
    private $advertIndexer;

    /**
     * InitCommand constructor.
     * @param Client $client
     */
    public function __construct(Client $client, AdvertIndexer $advertIndexer)
    {
        parent::__construct();
        $this->client = $client;
        $this->advertIndexer = $advertIndexer;
    }


    public function handle(): bool
    {
        try{
            $this->client->indices()->delete([
                'index'=>'app'
            ]);
        }catch (Missing404Exception $exception){}

        $params = [
            'index' => 'app',
            'body'  => [
                'mappings'=>[
                    'adverts'=>[
                        '_source'=>[
                            'enabled'=>true
                        ],
                        'properties'=>[
                            'id'=>[
                                'type' => 'integer',
                            ],
                            'published_at'=>[
                                'type'=>'date'
                            ],
                            'title'=>[
                                'type'=>'text'
                            ],
                            'content'=>[
                                'type'=>'text'
                            ],
                            'price'=>[
                                'type'=>'integer'
                            ],
                            'status'=>[
                                'type'=>'keyword'
                            ],
                            'categories'=>[
                                'type'=>'integer'
                            ],
                            'categories_for_promotion'=>[
                                'type'=>'integer'
                            ],
                            'regions'=>[
                                'type'=>'integer'
                            ],
                            'photo'=>[
                                'type'=>'keyword'
                            ],
                            'view'=>[
                                'type'=>'integer'
                            ],
                            'click'=>[
                                'type'=>'integer'
                            ],
                            'promotion'=>[
                                'type'=>'boolean'
                            ],
                            'values'=>[
                                'type'=>'nested',
                                'properties'=>[
                                    'attribute'=>[
                                        'type'=>'integer',
                                    ],
                                    'value_number'=>[
                                        'type'=>'integer'
                                    ],
                                    'value_string'=>[
                                        'type'=>'text'
                                    ],
                                ]
                            ],
                        ]
                    ],
                ],
                'settings' => [
                    'analysis' => [
                        'char_filter' => [
                            'replace' => [
                                'type' => 'mapping',
                                'mappings' => [
                                    '&=> and '
                                ],
                            ],
                        ],
                        'filter' => [
                            'word_delimiter' => [
                                'type' => 'word_delimiter',
                                'split_on_numerics' => false,
                                'split_on_case_change' => true,
                                'generate_word_parts' => true,
                                'generate_number_parts' => true,
                                'catenate_all' => true,
                                'preserve_original' => true,
                                'catenate_numbers' => true,
                            ],
                            'trigrams' => [
                                'type' => 'ngram',
                                'min_gram' => 4,
                                'max_gram' => 6,
                            ],
                        ],
                        'analyzer' => [
                            'default' => [
                                'type' => 'custom',
                                'char_filter' => [
                                    'html_strip',
                                    'replace',
                                ],
                                'tokenizer' => 'whitespace',
                                'filter' => [
                                    'lowercase',
                                    'word_delimiter',
                                    'trigrams',
                                ],
                            ],
                        ],
                    ],
                ]
            ]
        ];


        $this->client->indices()->create($params);
        foreach (Advert::cursor() as $advert){
            $this->advertIndexer->index($advert);
        }


//        $this->client->indices()->create([
//            'index'=>'app',
//            'body'=>[
//                "mappings" => [
//            "_doc" =>  [
//            "properties" =>  [
//                "id" =>  [ "type" =>  "integer" ],
//                "field1" =>  [ "type" =>  "text" ],
//                "obj" =>  [ "type" =>  "nested" ],
//                "values" =>  [ "type" =>  "nested",
//                    'properties'=>[
//                        'attribute'=>[
//                            'type'=>'integer'
//                        ]
//                    ]],
//            ]
//        ]
//    ]
//            ]
//        ]);
//        $params = [
//            'index' => 'app',
//            'id'    => 1,
//            'body'  => [ 'id'=> 1, 'field1' => 'abc', 'obj'=>['one'=>1,'two'=>2],'values'=>['attribute'=>1]]
//        ];
//       $this->client->index($params);
//        $params = [
//            'index' => 'app',
//            'body'  => [
//                'query' => [
//                    'nested'=>[
//                        'path'=>'obj',
//                        'query'=>[
//                            'bool'=>[
//                                'must'=>[
//                                    ['match'=>['obj.one'=>1]]
//                                ]
//                            ]
//                        ]
//                    ]
//                ]
//            ]
//        ];
//
//        $results = $this->client->search($params);
//        dd($results);


//        $response = $this->client->index([
//            'index'=>'app',
//            'type'=>'adverts',
//            'id'=>11,
//            'body'=>[
//                'id'=>11,
////                'published_at'=>Carbon::now()->format(DATE_ATOM),
////                'title'=>'title',
////                'content'=>'content',
////                'price'=>11,
////                'status'=>'status',
////                'categories'=>[1,2,3,4,5,11],
////                'regions'=>[1,2,3,4,5,11],
//                //'values' =>['one'=>1,'two'=>2]
//                'obj'=>['one'=>1,'two'=>2]
//            ]
//        ]);
//        $response1 = $this->client->index([
//            'index'=>'app',
//            'type'=>'adverts',
//            'id'=>12,
//            'body'=>[
//                'id'=>12,
////                'published_at'=>Carbon::now()->format(DATE_ATOM),
////                'title'=>'title',
////                'content'=>'content',
////                'price'=>12,
////                'status'=>'status',
////                'categories'=>[1,2,3,4,5,12],
////                'regions'=>[1,2,3,4,5,12],
//                //'values' =>['one'=>1,'two'=>2]
//                'obj'=>['one'=>1,'two'=>2]
//            ]
//        ]);
        return true;
    }
}
