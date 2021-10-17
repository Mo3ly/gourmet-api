<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderResourceCollection;
use App\Events\OrderReceived;

class OrderController extends Controller
{
    public function index(){
        return new OrderResourceCollection(Order::orderBy('id', 'DESC')->get());
    }

    public function show($id){
        return new OrderResource(Order::where('id', $id)->firstOrFail());
    }

    
    public function paginate(){
        $orders = Order::orderBy('id', 'DESC')->paginate(10);

        $response = [
            'pagination' => [
                'total' => $orders->total(),
                'has_more_pages' => $orders->hasMorePages(),
                'per_page' => $orders->perPage(),
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'from' => $orders->firstItem(),
                'to' => $orders->lastItem(),
            ],
            'orders' => new OrderResourceCollection($orders)
        ];

        return $response;
    }
    
    public function store (Request $request){
        // Notes: 
        //  - check if the same ip or the same table has just made a request and inform the user
        //  - check user location in gourment
        //  - max orders 4 with status delieverd

        // $request->validate([
        //     'username' => 'required',
        //     'table' => 'required',
        //     'products' => 'required',
        // ]);

        $order = Order::create([
            'username' => $request->username,
            'user_ip' => $request->ip,
            'table_number' =>  $request->table,
        ]);

        foreach($request->get('products') as $key=>$product){
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'notes' => $product['notes'],
                'options' => $product['options'],
                'additions' => $product['additions'],
            ]);
        }

        $orderResource = new OrderResource($order);

        if($orderResource) {
            try{
                event(new OrderReceived($order));
            } catch (Throwable $e){}

            return response()->json(['success'=>'The order has been placed successfully.']);
        }

    }
    
    public function update(Request $request){
        $request->validate([
            'order_id' => 'required',
            'status' => 'required',
        ]);
        
        $order = Order::find($request->order_id);
        $order->status = $request->status;
        $order->save();   

        return response()->json(['success'=>'The product status has been updated.']);
    }

    public function destroy(Request $request){
        $request->validate([
            'order_id' => 'required',
        ]);
        
        $order = Order::find($request->order_id);
        $order->delete();       

        return response()->json(['success'=>'The order has been deleted.']);
    }
}
