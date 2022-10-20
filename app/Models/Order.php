<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderProduct;
use App\Models\TableOrder;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'orders';


    public function tableOrder()
    {
        return $this->hasOne(TableOrder::class);
    }

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
