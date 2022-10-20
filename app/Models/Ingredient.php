<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Models\IngredientCategory;
use App\Models\ProductIngredient;

class Ingredient extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected $table = 'ingredients';

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
        self::deleting(function($ingre) {
             $ingre->productIngredients()->each(function($productIngredients) {
                $productIngredients->delete(); // <-- direct deletion
             });
        });
    }

    public function ingCategory()
    {
        return $this->belongsTo(IngredientCategory::class,'ingredient_category_id');
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

}
