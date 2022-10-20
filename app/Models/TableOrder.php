<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Table;
use App\Models\Order;
use App\Models\Customer;

class TableOrder extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'table_orders';

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
