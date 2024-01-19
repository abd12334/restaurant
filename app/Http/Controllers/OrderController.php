<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;
use App\Http\Resources\OrderResource;
use App\Http\Traits\GeneralTrait;
use App\models\user;
use Illuminate\Support\Facades\Cache;
class OrderController extends Controller
{
    use GeneralTrait;
    public function OrderStatus(Request $request, int $id)
    {
        $order = Order::findOrFail($id);

        if ($request->input('status') == 'Cancelled') {
            $order->status = 'Cancelled';
        } else {
            $order->items = json_decode($request->input('items'));
            $order->total_price = $request->input('total_price');
        }

        $order->save();

        return OrderResource::make($order);
    }

    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|integer',
        'restaurant_id' => 'required|integer',
        'items' => 'required|string',
    ]);

    $user_id = $request->input('user_id');
    $restaurant_id = $request->input('restaurant_id');
    $items = $request->input('items');

   
        $order = new Order;
        $order->restaurant_id = $restaurant_id;
        $order->user_id = $user_id;
        $order->items = $items;

        $order->save();
    
    return $this->successResponse($order, 'ok');
}

    public function index(Request $request )
    
{
    $user_id = $request->user()->id;
    if (Order::where('user_id', '=', $user_id)->exists()) {
        // User has placed orders, proceed to retrieve and return them
        $orders = Order::where('user_id', '=', $user_id)->get();
    
        // Cache the orders for 60 seconds
        Cache::put('or', $orders, 60);
    
        // Check if orders are cached
        if (Cache::has('or')) {
            $orders = Cache::get('or');
        } else {
            // Data not found in the cache, fetch it from the original source and cache it.
            $orders = Order::where('user_id', '=', $user_id)->get();
            Cache::put('or', $orders, 60);
        }
    
        // Return the orders
        return OrderResource::collection($orders);
    } else {
        // User has not placed any orders, return an empty array
        return [];
    }
}
public function showByName(Request $request)
{
    $name =$request->input('name');
    $user = user::where('name', '=', $name)->get();
   

    if (empty($user)) {
        return response()->json([
            'error' => 'User not found',
        ]);
    }

    $user_id = $user[0]->id;
    
    $orders = Order::where('user_id','=', $user_id)->get();

    #$filteredOrders = [];

    #foreach ($orders as $order) {
        #$filteredOrder = $this->formatOrder($orders);
        #$filteredOrders[] = $filteredOrder;
    #}

    return $this->successResponse($orders,'ok');
}



}

