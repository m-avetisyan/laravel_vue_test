<?php
namespace App\Http\Controllers;

use App\Http\Resources\FailedResource;
use App\Http\Resources\SuccessResource;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','index', 'register']]);
    }

    /**
     * POST /api/auth/register
     * Register a new user
     *
     * @param RegisterRequest $request
     * @return SuccessResource
     */
    public function register(UserService $userService,RegisterRequest $request)
    {
        $credentials = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => false,
            'auth_token' => Str::random(),
            'token_generated' => date('Y-m-d H:i:s', time()),
        ];
        $user = $userService->create($credentials);
        return new SuccessResource((object)['message' => 'Successfully registered','code' => 200,'data' => $user]);
    }

    /**
     * POST /api/auth/login
     * Login user
     *
     * @param Request $request
     *  @return FailedResource|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = auth('api')->attempt($credentials)) {
            return new FailedResource((object)['error' => 'Wrong login/password.Try again']);
        }
        else {
            return $this->respondWithToken($token);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return SuccessResource
     */
    public function logout()
    {
        auth('api')->logout();
        return new SuccessResource((object)['message' => 'Successfully Log out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     *  @return FailedResource|SuccessResource|\Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = $this->guard()->user();

            return response()->json([
                'code' => 200,
                'token' => $token,
                'user' => $user,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ]);

    }

    public function guard()
    {
        return \Auth::Guard('api');
    }

}
