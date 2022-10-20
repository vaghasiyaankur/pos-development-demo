<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use File;


class Category extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected $table = 'categories';

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
        self::deleting(function($category) {
             $category->products()->each(function($product) {
                $path = public_path()."/storage/$product->image";
                $result = File::exists($path);

                if($result)
                {
                    File::delete($path);
                }

                $product->delete(); // <-- direct deletion
             });
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function activeproducts()
    {
        return $this->hasMany(Product::class)->where('status', 1);
    }

}
