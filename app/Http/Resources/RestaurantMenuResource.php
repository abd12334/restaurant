<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Restaurant;
use App\Models\Menu;

class RestaurantMenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    
    

    public function toArray(Request $request): array
    {
        return [
            'restaurant' => $this->restaurant,
            'menu' => $this->menu,
        ];
    }
    }

