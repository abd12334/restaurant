<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;
use App\OrderResource;
use App\Http\Traits\GeneralTrait;
class OrderController extends Controller
{
    use GeneralTrait;
    public function patchOrderStatus(Request $request, $id)
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
        $restaurant_id = $request->input('restaurant_id');
        $items = $request->input('items');
        $delivery_type = $request->input('delivery_type');
        $total_cost = $request->input('total_cost');

        $order = new Order();
        $order->restaurant_id = $restaurant_id;
        $order->items = $items;
        $order->delivery_type = $delivery_type;
        $order->total_cost = $total_cost;
        $order->save();

        return $order;
    }

    public function index(Request $request)
    {
        $user_id = $request->user()->id;

        $orders = Order::where('user_id', '=', $user_id)->get();

        return $orders;
    }
}

