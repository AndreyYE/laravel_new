<?php

namespace App\Http\Controllers\Cabinet\Adverts;

use App\Entity\Adverts\Attribute;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\UseCases\Adverts\AdvertService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CreateController extends Controller
{
    public $service;
    public function __construct(AdvertService $service)
    {
        $this->service = $service;
    }

    public function category()
    {
        $categories = Category::defaultOrder()->withDepth()->get()->toTree();
        return view('cabinet.adverts.create.category', compact('categories'));
    }

    public function region(Category $category, Region $region=null)
    {
        $regions =  Region::where('parent_id', $region ? $region->id : null)->orderBy('name')->get();
        return view('cabinet.adverts.create.region', compact('category', 'region', 'regions'));
    }

    public function advert(Category $category, Region $region=null)
    {
        return view('cabinet.adverts.create.advert', compact('category', 'region'));
    }

    public function store(Request $request,  Category $category, Region $region=null)
    {
        // Validation
        $attributes = [];
        \DB::transaction(function() use ($request, &$attributes){
            foreach ($request['attributes'] as $k => $v)
            {
                $att = Attribute::findOrFail($k);

                $attributes['attributes.'.$k] = [];


                if($att->required){
                    array_push( $attributes['attributes.'.$k], 'required');
                    print_r($attributes['attributes.'.$k]);
                }
                if(!$att->required){
                    array_push( $attributes['attributes.'.$k], 'nullable');
                }
                if($att->type === 'integer'){
                    array_push( $attributes['attributes.'.$k], 'integer');
                }
                if($att->type === 'string'){
                    array_push( $attributes['attributes.'.$k], 'string');
                }
                if($att->type === 'slider'){
                    array_push( $attributes['attributes.'.$k], 'slider');
                }
                if($att->type === 'float'){
                    array_push( $attributes['attributes.'.$k], 'integer');
                }
            }
        });
       $request->validate([
            'title'=>'required|string|max:255',
           'price'=>'required|integer',
           'address'=>'required|string|max:255',
           'content'=>'required|string',
            'attributes.*' => $attributes
        ]);

       // Save Advert
       try{
            $advert = $this->service->create(\Auth::id(), $category->id, $region ? $region->id : null, $request);
       }catch (\DomainException $exception){
           return back()->with('error', $exception->getMessage());
       }
       return redirect()->route('adverts.show',$advert);
    }

}
