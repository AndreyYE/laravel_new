<?php

namespace App\Http\Requests\Admin;

use App\Entity\Adverts\Attribute;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class AttributeRequest extends FormRequest
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
            'name' => 'required|max:255',
            'type' => ['required',
                Rule::in(Attribute::typeList()),
            ],
            'variants' => 'nullable|string',
            'sort' => 'required|integer',
        ];
    }
}
