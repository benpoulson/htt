<?php

namespace App\Http\Controllers;

use App\Transformers\JWTTransformer;
use App\Transformers\MessageTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\JWT;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => [
                'login',
                'logout'
            ]
        ]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login()
    {
        $credentials = request([
            'email',
            'password'
        ]);
        $token = auth()->attempt($credentials);

        if (!$token) {
            return fractal('Invalid email or password', MessageTransformer::class)->respond(401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function user()
    {
        return fractal(auth()->user(), UserTransformer::class)->respond();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        if (auth()->check()) {
            auth()->logout();
        }

        return fractal('Successfully logged out', MessageTransformer::class)->respond();
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->getAuth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->getAuth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * @return JWT|AuthManager
     */
    private function getAuth()
    {
        return auth();
    }
}
