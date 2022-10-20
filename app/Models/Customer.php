<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TableOrder;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function tableOrders()
    {
        return $this->hasMany(TableOrder::class);
    }
}
