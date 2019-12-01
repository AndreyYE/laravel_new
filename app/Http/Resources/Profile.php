<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Profile extends JsonResource
{

    public function toArray($request)
    {
         return [
        'id' => $this->id,
        'name' => $this->name,
        'last_name' => $this->last_name,
        'email' => $this->email,
        'phone' => $this->phone,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
    ];
    }
}
/**
 * @OA\Schema(
 *   schema="Profile",
 *   type="application/json",
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="name",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="last_name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="phone",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="created_at",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="updated_at",
 *                     type="string"
 *                 ),
 * )
 */
