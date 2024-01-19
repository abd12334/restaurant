<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\restaurant;
use App\Models\menu;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\RestaurantResource;
use App\Http\Resources\RestaurantMenuResource;
use App\Http\Resources\MenuResource;
class RestaurantController extends Controller
{
    
    use GeneralTrait;
    public function index()
{
    $restaurants = Restaurant::all();
    Cache::put('res', $restaurants, 60);

    
        if (Cache::has('res')) {
        $restaurants = Cache::get('res');
        } else {
        Cache::put('res', $restaurants, 60);
        }

    return RestaurantResource::collection($restaurants);
}

    public function show($id)
{
    
    $restaurant = Restaurant::find($id);
    $restaurant_id = $restaurant['id'];

    $menu =  Menu::where('restaurant_id' ,'=', $restaurant_id)->get();

    #return RestaurantResource::collection($restaurant,$menu);
    return $this->successResponse($menu , $restaurant);
}


public function search(Request $request)
{
    

    $cuisine = $request->input('cuisine');
    
    $address = $request->input('address');

    

    $restaurants = Restaurant::where('cuisine', '=', $cuisine)
        ->where('address', '=', $address)
        ->get();
       
    foreach ($restaurants as $restaurant) {
        $restaurant_id = $restaurant->id;
        $menus = Menu::where('restaurant_id', $restaurant_id)->get();
        $restaurant->menu = $menus;
        }
        
    return $this->successResponse($restaurants);
           
}
}
