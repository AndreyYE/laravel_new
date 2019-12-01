<?php

namespace App\Http\Requests\Adverts;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'content' => 'required|string',
            'price' => 'required|integer',
            'address' => 'required|string',
        ];
    }
}

/**
 * @OA\Schema(
 *     schema="CreateRequest",
 *     type="aplication/json",
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
 *                 @OA\Property(
 *                     property="address",
 *                     type="string"
 *                 ),
 * )
 */
