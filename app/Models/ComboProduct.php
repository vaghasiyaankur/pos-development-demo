<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Combo;

class ComboProduct extends Model
{
    use HasFactory;

    protected $table = 'combo_products';

    public $timestamps = false;

    public function combo()
    {
        return $this->belongsTo(Combo::class, 'combo_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
