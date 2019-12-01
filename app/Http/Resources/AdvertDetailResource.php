<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertDetailResource extends JsonResource
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
        foreach ($this as $key=>$val){
            foreach ($val as $k=>$v){
                array_push($arr, [
                    'id' => $v->id,
                    'user_name' => $v->user->name,
                    'phone' => $v->user->phone,
                    'category' => $v->category->name,
                    'region' => $v->region->name,
                    'title' => $v->title,
                    'content' => $v->content,
                    'price' => $v->price,
                    'address' => $v->address,
                    'published' => $v->published_at,
                    'expires' => $v->expires_at,
                ]);
            }
        }
        return $arr;
    }
}

/**
 * @OA\Schema(
 *     schema="AdvertDetailResource",
 *     type="aplication/json",
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="user_name",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="category",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="region",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="phone",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="content",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="price",
 *                     type="string"
 *                 ),
 *                      @OA\Property(
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
 *          )
 */
