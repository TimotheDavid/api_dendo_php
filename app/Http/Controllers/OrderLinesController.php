<?php

namespace App\Http\Controllers;

use App\Models\OrderLines;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as ValidatorAlias;
use Illuminate\Validation\Validator as Validator;
use function response as response;

class OrderLinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orderLines = DB::table('order_lines')
            ->leftJoin('orders', 'order_lines.orders', '=', 'orders.id')
            ->leftJoin('users','orders.user', '=', 'users.id')
            ->get(['order_lines.*','orders.amount_vat', 'orders.amount_ttc' , 'orders.done as orders_done', 'users.name', 'users.last', 'users.last','users.email', 'users.id as user_id']);

        return response()->json([
            'response' => $orderLines
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *!
     * @return JsonResponse
     *@return JsonResponse
     *
     **/
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try{
            DB::table('order_lines')->insert([
                'price_vat' => $request->price_vat,
                'stock' => $request->stock,
                'orders' => $request->orders,
                'products' => $request->products
            ]);


            return response()->json(201);

        }catch (\Exception $error){
            return response()->json([], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {

        if (is_numeric($id)) {

            $orderLines = DB::table('order_lines')
                ->leftJoin('orders', 'order_lines.orders', '=', 'orders.id')
                ->leftJoin('users', 'orders.user', '=', 'users.id')
                ->where('order_lines.id', $id)
                ->get(['order_lines.*', 'orders.amount_vat', 'orders.amount_ttc', 'users.name', 'users.last', 'users.last', 'users.email', 'users.id as user_id']);

            return response()->json([
                'response' => $orderLines
            ]);
        }else{
            return response()->json([], 404);
        }

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param OrderLines $orderLines
     * @return Response
     */
    public function edit(OrderLines $orderLines)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validator = ValidatorAlias::make($request->all(), [
            'price_vat' => 'required|integer',
            'stock' => 'required|integer',
            'orders' => 'required|integer',
            'products' => 'required|integer',
        ]);

        if($validator->fails()){
            response()->json($validator->errors(),400);
        }

        if(!is_numeric($id)){
            response()->json(null, 403);
        }


        try{
            DB::table('order_lines')->where('id', $id)->update([
                'price_vat' => $request->price_vat,
                'stock' => $request->stock,
                'orders' => $request->orders,
                'products' => $request->products
            ]);
            return response()->json(null,204);
        }catch ( \Exception $error){
            return response()->json($error,500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if(is_numeric($id)) {
            try {
                DB::table('order_lines')->where('id', $id)->delete();
                return response()->json(null,200);
            } catch (\Exception $error) {
                return response()->json(null,500);
            }
        }else{
            return response()->json(null,403);
        }
    }

    /**
     * Update the done parameter to make it done by the vendor
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function accept(int $id, Request  $request): JsonResponse
    {

        $validator = ValidatorAlias::make($request->all(), [
            'done' => 'boolean|required'
        ]);

        if($validator->fails()){
            response()->json([
                'error' => 'is not a boolean'
            ],500);
        }

        try{
            DB::table('order-lines')->where('id', $id)->update([
                'done' => $request->done,
            ]);
            response()->json([],204);

        }catch (\Exception $error){
            response()->json([
                'error' => $error
            ],500);
        }



    }
}
