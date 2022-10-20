<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Models\ComboProduct;
use App\Models\OrderProduct;

class Combo extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'combos';

    // public $timestamps = false;

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
            $product->orderProduct()->each(function($orderProduct) {
                $orderProduct->delete();
            });

            $product->comboProducts()->each(function($comboProducts) {
                $comboProducts->delete();
            });
        });
    }

    public function comboProducts()
    {
        return $this->hasMany(ComboProduct::class);
    }


    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class);
    }

}
