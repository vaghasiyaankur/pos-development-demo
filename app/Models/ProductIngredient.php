<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIngredient extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','ingredient_id'];

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function ingredients()
    {
        return $this->belongsTo(Ingredient::class,'ingredient_id');
    }
}
