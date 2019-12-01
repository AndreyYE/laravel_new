<?php

namespace App\Http\Controllers\Admin\Adverts;

use App\Entity\Adverts\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage-adverts-categories');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::defaultOrder()->withDepth()->get();
        return view('admin.adverts.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.adverts.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try{
            $request->validate([
                'name' => 'required|unique:advert_categories|max:255',
                'slug' => 'required|unique:advert_categories|max:255',
            ]);
            $parent =  $request->parent ? Category::findOrFail($request->parent): null;
            $node = new Category();
            $node->name = $request->name;
            $node->slug = $request->slug;
            $parent ? $parent -> appendNode ( $node ) : $node->save();
        }catch (\DomainException $exception){
            return redirect()->back()->with('error','error '.$exception->getMessage());
        }
        return redirect()->route('admin.advert.categories.index')->with('success', 'You add new category - '.$request->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $attributes = $category->attributes()->orderBy('sort')->get();
        $parentAttributes = $category->parentAttributes();
        return view('admin.adverts.categories.show', compact('category','attributes', 'parentAttributes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category :: defaultOrder()->withDepth()->ancestorsOf($category->id);
        return view('admin.adverts.categories.edit', compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
       $request->validate([
            'name' =>
            [
                'required',
                'max:255',
                Rule::unique('advert_categories')->ignore($category->id),
            ],
            'slug' =>  [
                'required',
                'max:255',
                Rule::unique('advert_categories')->ignore($category->id),
            ],
        ]);
        try{
            $category->name = $request->name;
            $category->slug = $request->slug;
            if($request->parent){
                if($request->parent === 'Main Category'){
                    $category->parent_id = null;
                }
                $category->parent_id = Category::where('name',$request->parent)->first();
            }
            $category->save();
        }catch (\DomainException $exception){
            return redirect()->back()->with('error', 'Error - '.$exception->getMessage());
        }
        return redirect()->route('admin.advert.categories.show',$category)->with('success','You updated you category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.advert.categories.index')->with('success', 'Yuo delete category '.$category->name);
    }

    public function first(Category $category)
    {
        if($first = $category->siblings()->defaultOrder()->first())
        {
            $category->insertBeforeNode($first);
            return redirect()->route('admin.advert.categories.index');
        }
    }

    public function up(Category $category)
    {
        $category->up ();
        return redirect()->route('admin.advert.categories.index');
    }

    public function down(Category $category)
    {
        $category->down();
        return redirect()->route('admin.advert.categories.index');
    }

    public function last(Category $category)
    {
        if($first = $category->siblings()->defaultOrder('desc')->first())
        {
            $category->insertAfterNode($first);
            return redirect()->route('admin.advert.categories.index');
        }
    }
}
