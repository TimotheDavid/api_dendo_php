<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleRessource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $role = DB::table('roles')->get();

        return response()->json([
            "response" => $role
        ],200);
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
     * @return RoleRessource|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

            try {
                $role = Role::create([
                    'label' => $request->label,
                ]);


                return response()->json(null,201);

            }catch (\Exception $error){
                return response()->json([
                    'error' => $error
                ],500);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role, int $id)
    {
        $role = Role::findOrFail($id);

        return response()->json([
            'response' => $role
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
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
     * @param \App\Models\Role $role
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Role $role, int $id)
    {


        try{
            DB::table('roles')->where('id',$id)->update([
                'label' => $request->label
            ]);
            return response()->json(["response" => "role updated"]);

        }catch (\Exception $error){
           return response()->json(["error" => "internal server error"], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            return response()->json(null, 204);
        }catch (\Exception $error){
            return response()->json(null, 500);
        }
    }
}
