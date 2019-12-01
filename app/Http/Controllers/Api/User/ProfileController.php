<?php

namespace App\Http\Controllers\Api\User;

use App\Entity\User;
use App\Http\Requests\Cabinet\ProfileEditRequest;
use App\Http\Resources\Profile;
use App\UseCases\Profile\ProfileService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{

    /**
     * @var ProfileService
     */
    private $service;

    public function __construct(ProfileService $service)
    {

        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/user",
     *     tags={"Profile"},
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/Profile")
     *         ),
     *      ),
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */

    public function show(Request $request)
    {
        $user = $request->user();
        return new Profile($user);
    }

    /**
     * @OA\Put(
     *     path="/user",
     *     tags={"Profile"},
     *     @OA\RequestBody(
     *     description="update user's profile",
     *     required=true,
     *      @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/ProfileEditRequest")
     *         ),
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */

    public function update(ProfileEditRequest $request)
    {
        $this->service->update($request);
        $user = User::findOrFail($request->user()->id);
        return new Profile($user);
    }
}
