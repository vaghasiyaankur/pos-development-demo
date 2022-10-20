<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductIngredient extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'order_product_ingredients';


    public function orderProduct()
    {
        return $this->belongsTo(OrderProduct::class);
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}
