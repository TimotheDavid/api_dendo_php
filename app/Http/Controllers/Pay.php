<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Pay extends Controller
{
    /**
     * @param Request $request
     */
    public function pay(Request $request){
        if(sizeof($request->items) < 1){
            response()->json(null,403);
        }
        $id_user = 0;
        if(!$request->header('Authorization')){
            response()->json(null,403);
        }else{
            $token =  explode(' ',$request->header('Authorization'))[1];
            $id_user = DB::table('users')->where('token', $token)->get('id')[0];
        }

        $total_vat = 0;
        $total_ttc = 0;
        $items = $request->items;
        // get the total of amount by the price_vat
        for( $i = 0; $i< sizeof($items); $i++){
            $total_vat += $items[$i]['product']['price_vat'] * $items[$i]['quantity'];
        }
        // get the amount of the price by price_ttc
        for( $i = 0; $i< sizeof($items); $i++){
            $total_ttc += $items[$i]['product']['price_ttc'] * $items[$i]['quantity'];
        }

        try{
           $order_id = DB::table('orders')->insertGetId([
               'amount_vat' => $total_vat,
               'amount_ttc' => $total_ttc,
               'user' => $id_user->id
           ]);
        }catch (\Exception $error){
            return response()->json([
                'error' => $error
            ],500);
        }

        try{
            for($i = 0; $i<sizeof($items); $i++){
                DB::table('order_lines')->insert([
                    'price_vat' => $items[$i]['product']['price_vat'],
                    'stock' => $items[$i]['quantity'],
                    'orders' => $order_id,
                    'products' => $items[$i]['product']['id']
                ]);
            }
        }catch (\Exception $error){
        return  response()->json([
                'error' => $error
            ],500);
        }

        return response()->json([],201);

    }
}
