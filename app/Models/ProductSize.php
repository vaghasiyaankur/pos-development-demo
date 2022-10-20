<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    public $timestamps = false;
    
    use HasFactory;

    protected $guarded = ['id'];

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function size()
    {
        return $this->belongsTo(Ingredient::class,'size_id');
    }
}
