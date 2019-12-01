<?php


namespace App\Http\Controllers\Api\User;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertDetailResource;
use App\UseCases\Adverts\FavoriteService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;


class FavoriteController extends Controller
{
    private $service;
    public function __construct(FavoriteService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/user/favorites",
     *     tags={"Favorites"},
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/AdvertDetailResource")
     *         ),
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */

    public function index(Request $request)
    {
        $user_id =  $request->user()->id;
        $adverts = Advert::where('user_id',$user_id)->whereHas('favorites', function (Builder $query) use($user_id){
            $query->where('user_id', $user_id);
        })->with('favorites','user','category', 'region')->get();
        return new AdvertDetailResource($adverts);
    }

    /**
     * @OA\Delete(
     *     path="/user/favorites/{advertId}",
     *     tags={"Favorites"},
     *     @OA\Parameter(name="advertId", in="path", required=true),
     *     @OA\Response(
     *         response=204,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */

    public function remove(Request $request, Advert $advert)
    {
        try{
            $advert = Advert::findOrFail($advert->id);
            $user = $request->user();
            $user->favorites()->detach($advert);
        }catch (\DomainException $exception){
            return \response()->json(['message'=>$exception->getMessage()],Response::HTTP_BAD_REQUEST);
        }
       return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
