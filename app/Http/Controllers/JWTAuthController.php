<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JWTAuthController extends Controller
{


    /**
     * JWTAuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('cors');
    }

    public function register(UserRequest $request) {
        $request->validated();
        $user = (new User())->add($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages()
            ], 200);
        }

        if (! $token = Auth::guard('api')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($request['rememberMe']) {
            config('jwt.ttl', env('TOKEN_TTL_REMEMBER_ME', 86400 * 30));
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    public function user() {
        return response()->json(Auth::guard('api')->user());
    }

    public function refresh() {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    public function logout() {
        Auth::guard('api')->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'logout'
        ], 200);
    }
}
