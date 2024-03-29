<?php


namespace App\Http\Requests\Cabinet;

use Illuminate\Foundation\Http\FormRequest;

class ProfileEditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|regex:/^\d+$/s',
        ];
    }
}
/**
 * @OA\Schema(
 *     schema="ProfileEditRequest",
 *     type="application/json",
 *                 @OA\Property(
 *                     property="name",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="last_name",
 *                     type="string"
 *                 ),
 *                  @OA\Property(
 *                     property="phone",
 *                     type="string"
 *      ),
 * )
 */
