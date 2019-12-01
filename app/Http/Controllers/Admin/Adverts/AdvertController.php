<?php
namespace App\Http\Controllers\Admin\Adverts;
use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Attribute;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Adverts\AttributesRequest;
use App\Http\Requests\Adverts\EditRequest;
use App\Http\Requests\Adverts\PhotosRequest;
use App\Http\Requests\Adverts\Rejectrequest;
use App\Jobs\DeletePhotosAdvert;
use App\UseCases\Adverts\AdvertService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdvertController extends Controller
{
    private $service;
    public function __construct(AdvertService $service)
    {
        $this->service = $service;
        $this->middleware('can:manage-adverts');
    }
    public function index(Request $request)
    {
        $query = Advert::orderByDesc('updated_at');
        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }
        if (!empty($value = $request->get('name'))) {
            //dd($request->get('title'));
            var_dump('work');
            $query->where('title', 'like', '%' . $value . '%');
        }
        if (!empty($value = $request->get('user'))) {
            $id = User::where('name', $value)->first() ? User::where('name', $value)->first()->id : '';
            $query->where('user_id', $id);
        }
        if (!empty($value = $request->get('region'))) {

            $region = Region::where('name','like','%'.$value.'%')->pluck('id');
            $query->whereIn('region_id', $region);
        }
        if (!empty($value = $request->get('category'))) {
            $category = Category::where('name','like','%'.$value.'%')->pluck('id');
            $query->whereIn('category_id', $category);
        }
        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }
        $adverts = $query->paginate(20)->appends($request->all());
        $statuses = Advert::statusesList();
        $roles = User::rolesList();
        return view('admin.adverts.adverts.index', compact('adverts', 'statuses', 'roles'));
    }
    public function editForm(Advert $advert)
    {
        return view('adverts.edit.advert', compact('advert'));
    }
    public function edit(EditRequest $request, Advert $advert)
    {
        try {
            $this->service->edit($advert->id, $request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()->route('adverts.show', $advert);
    }
    public function attributesForm(Advert $advert)
    {
        return view('adverts.edit.attributes', compact('advert'));
    }
    public function attributes(AttributesRequest $request, Advert $advert)
    {
        try {
            $this->service->editAttributes($advert->id, $request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()->route('adverts.show', $advert);
    }
    public function photosForm(Advert $advert)
    {
        return view('adverts.edit.photos', compact('advert'));
    }
    public function photos(PhotosRequest $request, Advert $advert)
    {
        try {
            $this->service->addPhotos($advert->id, $request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()->route('adverts.show', $advert);
    }
    public function moderate(Advert $advert)
    {
        try {
            $this->service->moderate($advert->id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()->route('adverts.show', $advert);
    }
    public function rejectForm(Advert $advert)
    {
        return view('admin.adverts.adverts.reject', compact('advert'));
    }
    public function reject(Rejectrequest $request, Advert $advert)
    {
        try {
            $this->service->reject($advert->id, $request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()->route('adverts.show', $advert);
    }
    public function destroy(Advert $advert)
    {
        try {
            $this->service->remove($advert->id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()->route('admin.advert.adverts.index');
    }
}
