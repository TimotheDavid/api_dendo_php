<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\JWTGuard;



class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        try {
            if (!$token = auth()->attempt($validator->validated())) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (ValidationException $e) {
            return response()->json(['error' => 'an error occurre'], 500);
        }


        DB::table('users')->where('email', $request->email)->update([
            'token' => $token
        ]);

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'c_password' => 'required|string|same:password',
            'last' => 'required|string|between:2,100',
            'role' => 'numeric'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $role = DB::table('roles')->select('id')->where('label', 'user')->get()[0]->id;
        if($request->role ){
            $role = $request->role;
        }
        try {
            DB::table('users')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'last' => $request->last,
                'role' => $role
            ]);
            return response()->json([
                'response' => 'user created'
            ], 201);
        } catch (\Exception $error ) {
            return response()->json([
                'error' => $error,
                'errors' => 'an error occurre'
            ]);
        }

    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        \auth()->logout();

        return response()->json(['response' => 'user logout']);
    }
    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->createNewToken(\auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function userProfile(): JsonResponse
    {
        return response()->json(\auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function createNewToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => \auth()->factory()->getTTL() * 60,
            'user' => \auth()->user(),
        ]);

    }
}
