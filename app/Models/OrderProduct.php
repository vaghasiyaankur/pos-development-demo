<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Product;
use App\Models\Combo;

class OrderProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'order_products';


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function combo()
    {
        return $this->belongsTo(Combo::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
