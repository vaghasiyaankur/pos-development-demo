<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\ProductIngredient;
use App\Models\OrderProduct;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected $table = 'products';

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public static function boot() {
        parent::boot();
        self::deleting(function($product) {
             $product->productIngredients()->each(function($productIngredients) {
                $productIngredients->delete(); // <-- direct deletion
             });

             $product->orderProduct()->each(function($orderProduct) {
                $orderProduct->delete();
             });

             $product->comboProduct()->each(function($comboProducts) {
                $comboProducts->delete();
             });

             $product->productSize()->each(function($productSize) {
                $productSize->delete();
             });
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productIngredients()
    {
        return $this->hasMany(ProductIngredient::class);
    }

    public function productSize()
    {
        return $this->hasMany(ProductSize::class);
    }


    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function comboProduct()
    {
        return $this->hasMany(ComboProduct::class);
    }
}
