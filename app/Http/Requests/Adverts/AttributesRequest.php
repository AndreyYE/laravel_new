<?php

namespace App\Http\Requests\Adverts;

use App\Entity\Adverts\Attribute;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttributesRequest extends FormRequest
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
        $array = [];
        foreach (request()->input('attributes') as $key=>$attribute){
            $array['attributes.'.$key] = [];
            if($att = Attribute::findOrFail($key)){
                if($att->required){
                    array_push($array['attributes.'.$key], 'required');
                }
                if($att->type === 'slider'){
                    $min = $att->variants[0];
                    $max = $att->variants[1];
                    array_push($array['attributes.'.$key], 'numeric');
                    array_push($array['attributes.'.$key], "min:$min");
                    array_push($array['attributes.'.$key], "max:$max");
                }
                if($att->type === 'string'){
                    if($att->variants){
                        array_push($array['attributes.'.$key], Rule::in($att->variants));
                    }else{
                        array_push($array['attributes.'.$key], 'string');
                    }
                }
                if($att->type === 'integer'){
                    if($att->variants){
                        array_push($array['attributes.'.$key], Rule::in($att->variants));
                    }else{
                        array_push($array['attributes.'.$key], 'numeric');
                    }
                }
            }
        }
        return $array;
    }
}
