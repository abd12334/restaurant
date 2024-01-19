<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    use HasFactory;
    protected $fillable=['restaurant_id', 'list_of_foods', 'list_of_drink'];







    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
