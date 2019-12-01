<?php

namespace App\Http\Controllers\Admin\Adverts;

use App\Entity\Adverts\Attribute;
use App\Entity\Adverts\Category;
use App\Http\Requests\Admin\AttributeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class AttributeController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Category $category)
    {
        return view('admin.adverts.categories.attributes.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeRequest $request, Category $category)
    {
        $req  = '';
        $request['required']==='on' ? $req=true : $req=false;
        try{
            $attribute = new Attribute;
            $attribute->name = $request['name'];
            $attribute->type = $request['type'];
            $attribute->required = $req;
            $attribute->variants = explode(',', $request['variants'])[0] ? array_map('trim',explode(',', $request['variants'])) : 0;
            $attribute->sort = $request['sort'];
            $category->attributes()->save($attribute);
        }
        catch(\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
        return redirect()->route('admin.advert.categories.show', $category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Attribute $attribute)
    {

        return view('admin.adverts.categories.attributes.show',compact('category','attribute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, Attribute $attribute)
    {
        $types = Attribute::typeList();
        return view('admin.adverts.categories.attributes.edit', compact('category','attribute','types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeRequest $request, Category $category, Attribute $attribute)
    {
        $req  = '';
        $request['required']==='on' ? $req=true : $req=false;
        try{
            $attribute->name = $request['name'];
            $attribute->type = $request['type'];
            $attribute->required = $req;
            $attribute->variants = explode(',', $request['variants'])[0] ? array_map('trim',explode(',', $request['variants'])) : 0;
            $attribute->sort = $request['sort'];
            $category->attributes()->save($attribute);
        }
        catch(\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
        return redirect()->route('admin.advert.categories.show', $category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Attribute $attribute)
    {
        $category->attributes()->delete($attribute);
        return redirect()->route('admin.advert.categories.show',$category);
    }
}
