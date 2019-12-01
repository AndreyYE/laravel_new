<?php

namespace App\Http\Resources;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Attribute;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $arr =['attributes'=>[]];
        foreach (Advert::findOrFail($this->id)->values as $v){
            array_push($arr['attributes'], [
                Attribute::findOrFail($v['attribute_id'])->name => $v['value']
            ]);
        }
        return array_merge([
            'id' => $this->id,
            'user_name' => $this->user->name,
            'phone' => $this->user->phone,
            'category' => $this->category->name,
            'region' => $this->region->name,
            'title' => $this->title,
            'content' => $this->content,
            'price' => $this->price,
            'address' => $this->address,
            'published' => $this->published_at,
            'expires' => $this->expires_at,
        ], $arr);
        return parent::toArray($request);
    }
}
/**
 * @OA\Schema(
 *     schema="AdvertShowResource",
 *     type="application/json",
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer"
 *                 ),
 *                  @OA\Property(
 *                     property="user_name",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="phone",
 *                     type="string"
 *                 ),
 *                       @OA\Property(
 *                     property="category",
 *                     type="integer"
 *                 ),
 *                       @OA\Property(
 *                     property="region",
 *                     type="integer"
 *                 ),
 *                       @OA\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                       @OA\Property(
 *                     property="content",
 *                     type="string"
 *                 ),
 *                       @OA\Property(
 *                     property="price",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="address",
 *                     type="string"
 *                 ),
 *                      @OA\Property(
 *                     property="published",
 *                     type="string"
 *                 ),
 *                      @OA\Property(
 *                     property="expires",
 *                     type="string"
 *                 ),
 * )
 */
