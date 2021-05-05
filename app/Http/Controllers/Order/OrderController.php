<?php

namespace App\Http\Controllers\Order;

use App\Order;
use App\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    public function store(Request $request)
    {
        $rules = [
            'quantity' => 'required|integer',
            'product_id' => 'required|exists:products,id',
        ];

        $this->validate($request, $rules);
        
        $products = Products::findorFail($request->product_id);
        if($products->quantity >= $request->quantity){
            
            $order = new Order;
            $order->quantity = $request->quantity;
            $order->product_id = $request->product_id;
            $order->buyer_id = Auth::user()->id;
            $order->save();

            $products->quantity = ($products->quantity - $request->quantity);
            if($products->quantity ==   0){
                $products->status = 'unavailable';
            }
            $products->save();
            return response()->json(["message" => "You have successfully ordered this product"], 201); 
        }

        return response()->json(["message" => "Failed to order this product due to unavailability of the stock"], 200); 
        
    }

  
}
