<?php


namespace App\Http\Controllers\Api;

/**
 * @OA\OpenApi(
 *     @OA\Server(
 *         url="/api",
 *         description="API server"
 *     ),
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Board API",
 *         description="HTTP JSON API",
 *         @OA\Contact(name="Laravel api"),
 *         @OA\License(name="Mr.Dow"),
 *        @OA\Contact(email="support@example.com"),
 *     ),
 *      @OA\Components(
 *          @OA\SecurityScheme(
 *                securityScheme="OAuth2",
 *                type="oauth2",
 *                description="Use a global client_id / client_secret and your username / password combo to obtain a token",
 *                @OA\Flow(
 *                  tokenUrl="https://localhost:8080/oauth/token",
 *                  flow="password",
 *                  scopes={
 *                   "description" : "You can use all functions in this site"
 *                  }
 *                ),
 *          ),
 *          @OA\SecurityScheme(
 *                securityScheme="Bearer",
 *                type="apiKey",
 *                name="Authorization",
 *                in="header"
 *          )
 *     ),
 * )
 */
class HomeController
{
    /**
     * @OA\Get(
     *     path="/",
     *     tags={"Info"},
     *     @OA\Response(response="200",
     *     description="API version",
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Property(property="version", type="string"),
     *     )),
     * )
     */
    public function home()
    {
        return [
            'name' => 'Board API',
        ];
    }
}
