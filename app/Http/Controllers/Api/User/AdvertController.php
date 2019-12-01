<?php

namespace App\Http\Controllers\Api\User;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Advert\Photo;
use App\Entity\Adverts\Advert\Value;
use App\Entity\Adverts\Attribute;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Http\Requests\Adverts\CreateRequest;
use App\Http\Requests\Adverts\EditRequest;
use App\Http\Requests\Adverts\PhotosRequest;
use App\Http\Resources\AdvertDetailResource;
use App\Http\Resources\AdvertListResource;
use App\Http\Resources\AdvertShowResource;
use App\Http\Router\AdvertsPath;
use App\Services\Search\AdvertIndexer;
use App\Services\Search\SearchService;
use App\UseCases\Adverts\AdvertService;
use Elasticsearch\Client;
use Illuminate\Auth\Access\Gate;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Nexmo\Call\Collection;
use Illuminate\Support\Facades\Cache;

class AdvertController extends Controller
{
    private $search;
    /**
     * @var AdvertService
     */
    private $service;

    /**
     * AdvertController constructor.
     * @param SearchService $search
     * @param AdvertService $service
     */
    public function __construct(SearchService $search, AdvertService $service)
    {
        $this->search = $search;
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/user/adserts",
     *     tags={"Adverts"},
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/AdvertListResource")
     *         ),
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */

    public function index(Request $request)
    {
        $adverts = Advert::forUser($request->user())->orderByDesc('id')->get();
        return new AdvertListResource($adverts);
    }

    /**
     * @OA\Get(
     *     path="/user/adverts/{advertId}",
     *     tags={"Adverts"},
     *     @OA\Parameter(
     *         name="advertId",
     *         description="ID of advert",
     *         in="path",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/AdvertShowResource")
     *         ),
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */

    public function show(Advert $advert)
    {
        if (!($advert->isActive() || \Gate::allows('show-advert', $advert))) {
            abort(403);
        }
        $advert = $advert->load('user','category','region');
        return new AdvertShowResource($advert);
    }

    /**
     * @OA\Put(
     *     path="/user/adverts/{advertId}",
     *     tags={"Adverts"},
     *     @OA\Parameter(
     *     name="advertId",
     *     description="ID of advert",
     *     in="path",
     *     required=true,
     *     ),
     *     @OA\RequestBody(
     *     description="update user's advert",
     *     required=true,
     *      @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/EditRequest")
     *         ),
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    public function update(EditRequest $request, Advert $advert)
    {
        if (!(\Gate::allows('admin-panel') || \Gate::allows('edit-own-advert', $advert))) {
            return response()->json([],Response::HTTP_FORBIDDEN);
        }
        try{
            $advert->title = $request->input('title');
            $advert->content = $request->input('content');
            $advert->price = $request->input('price');
            $advert->address = $request->input('address');
            $advert->save();
        }catch (\DomainException $exception){
            return \response()->json(['message'=>$exception->getMessage(),Response::HTTP_BAD_REQUEST]);
        }
        return response()->json([],Response::HTTP_CREATED);
    }

    /**
     * @OA\Delete(
     *     path="/user/adverts/{advertId}",
     *     tags={"Adverts"},
     *     @OA\Parameter(name="advertId", in="path", required=true),
     *     @OA\Response(
     *         response=204,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */

    public function destroy(Advert $advert)
    {
        if (!(\Gate::allows('admin-panel') || \Gate::allows('edit-own-advert', $advert))) {
            return response()->json([],Response::HTTP_FORBIDDEN);
        }
        $advert->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Post(
     *     path="/user/adverts/create/{category}/{region}",
     *     tags={"Adverts"},
     *     @OA\Parameter(
     *     name="category",
     *     description="ID of category",
     *     in="path",
     *     required=true,
     *     ),
     *     @OA\Parameter(
     *     name="region",
     *     description="ID of region",
     *     in="path",
     *     required=true,
     *     ),
     *     @OA\RequestBody(
     *     description="update user's advert",
     *     required=true,
     *      @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/CreateRequest")
     *         ),
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */

    public function store(CreateRequest $request, Category $category, Region $region = null)
    {
        try{
            $advert = new Advert();
            $advert->user_id = $request->user()->id;
            $advert->category_id = $category->id;
            $advert->region_id = $region ? $region->id : $region;
            $advert->category_id = $category->id;
            $advert->title = $request->input('title');
            $advert->price = $request->input('price');
            $advert->content = $request->input('content');
            $advert->address = $request->input('address');
            $advert->save();
            $advert = $advert->load('user','category','region');
        }catch (\DomainException $exception){
            return \response()->json(['message'=>$exception->getMessage(),Response::HTTP_BAD_REQUEST]);
        }
        return (new AdvertShowResource($advert))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
    public function photos(Request $request, Advert $advert)
    {
        if (!(\Gate::allows('admin-panel') || \Gate::allows('edit-own-advert', $advert))) {
            return response()->json([],Response::HTTP_FORBIDDEN);
        }
        try{
        foreach ($request->allFiles() as $file) {
            $photo =  new Photo();
            $photo->file = $file->store('images/adverts', 'public_public');
            $photo->advert_id = $advert->id;
            $photo->save();
        }}catch (\DomainException $exception){
            return \response()->json(['message'=>$exception->getMessage(),Response::HTTP_BAD_REQUEST]);
        }
        return new AdvertShowResource(Advert::findOrFail($advert->id));
    }

    public function attributes(Request $request, Advert $advert)
    {
        if (!(\Gate::allows('admin-panel') || \Gate::allows('edit-own-advert', $advert))) {
            return response()->json([],Response::HTTP_FORBIDDEN);
        }
        try{
        foreach ($request->all() as $k=>$val){
           Value::where('advert_id', $advert->id)->where('attribute_id', $k)->update([
                'value'=>$val
            ]);
        }}catch (\DomainException $exception){
            return \response()->json(['message'=>$exception->getMessage(),Response::HTTP_BAD_REQUEST]);
        }
        return new AdvertShowResource($advert);
    }

    public function send(Advert $advert)
    {
        if (!(\Gate::allows('admin-panel') || \Gate::allows('edit-own-advert', $advert))) {
            return response()->json([],Response::HTTP_FORBIDDEN);
        }
        $this->service->sendToModeration($advert->id);
        return new AdvertShowResource($advert);
    }

    public function close(Advert $advert)
    {
        if (!(\Gate::allows('admin-panel') || \Gate::allows('edit-own-advert', $advert))) {
            return response()->json([],Response::HTTP_FORBIDDEN);
        }
        $this->service->close($advert->id);
        return new AdvertShowResource(Advert::findOrFail($advert->id));
    }

    public function delete(Advert $advert)
    {
        if (!(\Gate::allows('admin-panel') || \Gate::allows('edit-own-advert', $advert))) {
            return response()->json([],Response::HTTP_FORBIDDEN);
        }
        $this->service->remove($advert->id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
