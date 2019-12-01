<?php

namespace App\Http\Controllers\Api\Auth;

use App\Entity\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Profile"},
     *     @OA\RequestBody(
     *         description="A object that needs to be added to be register",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *            @OA\Schema(@OA\Property(property="name", type="string"),
     *                      @OA\Property(property="email", type="string"),
     *                      @OA\Property(property="pasword", type="string"))
     *         ),
     *     ),
     *     @OA\Response(
     *     response=201,
     *     description="Success response",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Property(property="version", type="string"),
     *     ))
     * )
     */
   public function register(Request $request)
   {
       Validator::make($request->all(), [
           'name' => ['required', 'string', 'max:255'],
           'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           'password' => ['required', 'string', 'min:8', 'confirmed'],
       ]);

        User::create([
           'name' => $request['name'],
           'email' => $request['email'],
           'password' => Hash::make($request['password']),
           'status' => User::STATUS_WAIT
       ]);
       return response()->json([
           'success' => 'Check your email and click on the link to verify.'
       ], Response::HTTP_CREATED);
   }
}
