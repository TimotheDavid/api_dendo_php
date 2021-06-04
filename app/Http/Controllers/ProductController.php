<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $product = DB::table('products')
            ->leftJoin('pictures', 'products.picture',  '=' , 'pictures.id')
                ->get(['products.*','pictures.path' ]);
        return response()->json([
            'response' => $product
        ]);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'price_vat' => 'float|required',
            'price_ttc' => 'float|required',
            'name' => 'string|required',
            'description' => 'string',
            'stock' => 'integer|required',
            'focus' => 'boolean',
            'place' => 'integer',
            'rank' => 'integer',
            'picture' => 'integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 500);
        }
        try {
            Product::create([
                'price_vat' => $request->price_vat,
                'price_ttc' => $request->price_ttc,
                'name' => $request->name,
                'description' => $request->description,
                'stock' => $request->stock,
                'focus' => $request->focus,
                'place' => $request->place,
                'rank' => $request->rank,
                'picture' => $request->picture
            ]);
            return  response()->json([], 201);

        }catch (\Exception $error){
            return response()->json([
                'error' => $request
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $product = DB::table('products')->where('products.id', $id)
            ->leftJoin('pictures', 'products.picture', '=', 'pictures.id')
            ->get();
        return response()->json([
            'response' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Product $product, int $id)
    {
        try{

            DB::table('products')->where('id', $id)->update([
                'price_vat' => $request->price_vat,
                'price_ttc' => $request->price_ttc,
                'name' => $request->name,
                'description' => $request->description,
                'stock' => $request->stock,
                'focus' => $request->focus,
                'place' => $request->place,
                'rank' => $request->rank,
                'picture' => $request->picture
            ]);
            return response()->json(null, 204);

        }catch (\Exception $error){
            return response()->json([
                'response' => $error
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {


        try{

            DB::table('order_lines')->where('products', $id)->update(['products' => 1]);

            DB::table('products')->where('id',$id)->delete();
            return response()->json(null, 204);

        }catch (\Exception $error){

            return response()->json([
                'error' => $error
            ],500);

        }
    }
}
