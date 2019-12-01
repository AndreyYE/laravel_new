<?php

namespace App\Http\Resources;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Entity\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $title
 * @property int $price
 * @property string $address
 * @property Carbon $published_at
 *
 * @property User $user
 * @property Region $region
 * @property Category $category
 * @property string $photos
 */

class AdvertListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $arr = [];
        foreach ($this['hits']['hits'] as $value){
          $count_categories = count($value['_source']['categories'])-1;
          $count_regions = count($value['_source']['regions'])-1;
            array_push($arr, [
                'id' => $value['_source']['id'],
                'user' =>[
                    'name' => $request->user()->name,
                    'phone' => $request->user()->phone,
                ],
                'category' => [
                    'id' => $value['_source']['categories'][$count_categories],
                    'name' => Category::findOrFail($value['_source']['categories'][$count_categories])->name,
                ],
                'region' => $count_regions ? [
                    'id' => $value['_source']['regions'][$count_regions],
                    'name' => Region::findOrFail($value['_source']['regions'][$count_regions])->name,
                ] : [],
                'title' => $value['_source']['title'],
                'price' => $value['_source']['price'],
                'date' => $value['_source']['published_at'],
                'photo' => $value['_source']['photo'] ? $value['_source']['photo'][0] : [],
            ]);
        }
        return  $arr;
    }
}

/**
 * @OA\Schema(
 *     schema="AdvertListResource",
 *     type="application/json",
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="name",
 *                     type="string"
 *                 ),
 * )
 */

