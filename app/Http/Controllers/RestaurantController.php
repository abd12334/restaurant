<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\restaurant;
use App\Http\Traits\GeneralTrait;
class RestaurantController extends Controller
{
    use GeneralTrait;
    public function index()
{
    $restaurants = Restaurant::all();

    return RestaurantResource::collection($restaurants)->toArray($request);
}

    public function show($id)
{
    $restaurant = Restaurant::findOrFail($id);

    $menu = Menu::where('restaurant_id', $restaurant->id)->get();

    return RestaurantResource::make($restaurant, [
        'menu' => $menu,
    ])->toArray($request);
}
public function search(Request $request)
{
    $cuisine = $request->input('cuisine');
    $location = $request->input('location');
    $address = $request->input('address');
    $phone_number = $request->input('phone_number');

    $restaurants = Restaurant::where('cuisine', '=', $cuisine)
        ->where('location', '=', $location)
        ->where('address', '=', $address)
        ->where('phone_number', '=', $phone_number)
        ->get();

    return RestaurantResource::collection($restaurants)->toArray($request);
}





}
