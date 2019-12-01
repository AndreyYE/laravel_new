<?php
namespace App\Http\Requests\Adverts;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
/**
 * @property Category $category
 * @property Region $region
 */
class EditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
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
 *     schema="EditRequest",
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
