<?php


namespace App\Http\Controllers\Api\Adverts;


use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Http\Resources\AdvertListResource;
use App\Http\Resources\AdvertShowResource;
use App\Services\Search\SearchService;
use Illuminate\Http\Request;

class AdvertController
{
    private $search;
    public function __construct(SearchService $search)
    {
        $this->search = $search;
    }

    /**
     * @OA\Get(
     *     security={{"Bearer": {}, "OAuth2": {}}},
     *     path="/adverts",
     *     tags={"Adverts"},
     *        @OA\Parameter(
     *         name="region",
     *         in="query",
     *         description="Point of region's id",
     *         required=true,
     *          ),
     *         @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Point of category's id",
     *         required=true,
     *           ),
     *         @OA\Parameter(
     *         name="pagination",
     *         in="query",
     *         description="pagination, default 1",
     *         required=false,
     *          ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/AdvertListResource")
     *          ),
     *     ),
     *     )
     * )
     */
    public function index(Request $request)
    {
        $region = $request->get('region') ? Region::findOrFail($request->get('region')) : null;
        $category = $request->get('category') ? Category::findOrFail($request->get('category')) : null;
        $pagination = $request->query('pagination') ? $request->query('pagination') : 1;
        $result = $this->search->search($request, $category->id, $region, 2, $pagination);
        return new AdvertListResource($result);
    }

    /**
     * @OA\Get(
     *     path="/adverts/{advertId}",
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
     *         @OA\Mediatype(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/AdvertShowResource"),
     *          ),
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */


    public function show(Advert $advert)
    {
        if (!($advert->isActive() || \Gate::allows('show-advert', $advert))) {
            abort(403);
        }
        return new AdvertShowResource($advert);
    }
}
