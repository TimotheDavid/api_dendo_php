<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserRessource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = DB::table('users')
            ->leftJoin('roles', 'users.id', '=', 'roles.id')
            ->get();

        return response()->json([
            'response' => $user
        ],200);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = DB::table('roles')->select('label')->where('label','user')->get();

        try{
            Product::create([
                'name' => $request->name,
                'email' => $request-> email,
                'password' => $request->password,
                'role' =>  $role
            ]);

            response()->json([
                'response' => 'user entry successfully'
            ],200);

        }catch (\Exception $error){

            response()->json([
                'error' => 'internal server error'
            ],500);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {

        $user = DB::table('users')
            ->where('users.id' , $id)
            ->leftJoin('roles', 'users.id', '=', 'roles.id')
            ->get();

        return response()->json([
            'response' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,int $id)
    {
        try {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();
           return response()->json([],204);

        }catch (\Exception $error){
            return response()->json([
                'error' => $error
            ],500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user, int $id)
    {
        try{
            $user = DB::table('users')->where('id', $id)->delete();
            return response()->json(null,204);


        }catch (\Exception $error){
            return response()->json([
                'error' => $error
            ],500);
        }
    }
}
