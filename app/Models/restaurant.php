<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class restaurant extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'cuisine',
        'address',
        'phone_number',
        'rating',
    ];
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}



