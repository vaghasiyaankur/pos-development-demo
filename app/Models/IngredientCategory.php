<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ingredient;
use File;

class IngredientCategory extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    protected $table = 'ingredient_categories';

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
        self::deleting(function($Ingcategory) {
             $Ingcategory->ingredients()->each(function($ing) {
                $path = public_path()."/storage/$ing->image";
                $result = File::exists($path);

                if($result)
                {
                    File::delete($path);
                }

                $ing->delete(); // <-- direct deletion
             });
        });
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    public function activeingredients()
    {
        return $this->hasMany(Ingredient::class)->where('status', 1);
    }
}
