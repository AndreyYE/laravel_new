<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Page;
use App\Http\Requests\Admin\Page\PageRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage-pages');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::defaultOrder()->withDepth()->get();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $page = Page::create([
            'title' => $request['title'],
            'slug' => $request['slug'],
            'menu_title' => $request['menu_title'],
            'parent_id' => $request['parent'],
            'content' => $request['content'],
            'description' => $request['description'],
        ]);
        return redirect()->route('admin.pages.show', $page);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $parents = Page::defaultOrder()->withDepth()->get();
        return view('admin.pages.edit', compact('page', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page $page)
    {
        $page->update([
            'title' => $request['title'],
            'slug' => $request['slug'],
            'menu_title' => $request['menu_title'],
            'parent_id' => $request['parent'],
            'content' => $request['content'],
            'description' => $request['description'],
        ]);
        return redirect()->route('admin.pages.show', $page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Yuo delete category '.$page->title);
    }

    public function first(Page $page)
    {
        if($first = $page->siblings()->defaultOrder()->first())
        {
            $page->insertBeforeNode($first);
            return redirect()->route('admin.pages.index');
        }
    }

    public function up(Page $page)
    {
        $page->up();
        return redirect()->route('admin.pages.index');
    }

    public function down(Page $page)
    {
        $page->down();
        return redirect()->route('admin.pages.index');
    }

    public function last(Page $page)
    {
        if($first = $page->siblings()->defaultOrder('desc')->first())
        {
            $page->insertAfterNode($first);
            return redirect()->route('admin.pages.index');
        }
    }

    public function deleteImages(Request $request)
    {
        // need put it in a Job;
        try{
            $delete_photos =  $request->input('need_delete_images');
            foreach ($delete_photos as $k=>$v){
                $url = explode('/',$v);
                $count = count($url)-1;
                Storage::disk('public_public')->delete('images/adverts/'.$url[$count]);
            }
        }catch (\DomainException $exception){
            return $exception->getMessage();
        }
        return 'OK';
    }
}
