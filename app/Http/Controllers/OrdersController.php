<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Orders;

class OrdersController extends Controller
{
    public function order(Request $request){
        
        //user
        $user = auth()->user();
        // check if product exist
        $product = Products::where('id', $request->product_id)->first();

        if($product){
            $canOrder = $product->available_stock >= $request->quantity;
            if($canOrder){
                $order = new Orders();
                $order->user_id = $user->id;
                $order->product_id = $request->product_id;
                $order->quantity  = $request->quantity;
                $order->save();


                $product->available_stock = $product->available_stock - $request->quantity;
                $product->save();
                $response = [
                        'code' => 201,
                        'status' => 'SUCCESS',
                        'message' => 'SUCCESSFULLY ORDERED',
                        'data' => $order,
                    ];
            
            }else{
                $response = [
                    'code' => 400,
                    'status' => 'FAILED',
                    'message' => '“Failed to order this product due to unavailability of the stock',
                ];
            }
        }else{
            $response = [
                    'code' => 404,
                    'status' => 'FAILED',
                    'message' => 'PRODUCT DOES NOT EXIST',
                ];
        }
        return response($response, $response['code']);
    }
}
