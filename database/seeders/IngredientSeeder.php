<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IngredientCategory;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredientCategories = IngredientCategory::get();
        $ingredients = [
            'cheeze',
            'test',
            'port',
        ];

        foreach($ingredientCategories as $ckey=>$category){
            if($category->name != 'size'){
                foreach($ingredients as $ikey=>$ingredient){
                    Ingredient::create([
                        'name' => $category->name.' '.$ingredient,
                        'price' => ($ckey + 1).''.($ikey + 1),
                        'image' => 'ingredient/'.($ckey + 1).''.($ikey + 1).'.png',
                        'ingredient_category_id' => $category->id,
                    ]);
                }
            }else{
                Ingredient::create([
                    'name' => 'S',
                    'price' => 0,
                    'image' => '',
                    'ingredient_category_id' => $category->id,
                ]);

                Ingredient::create([
                    'name' => 'M',
                    'price' => 0,
                    'image' => '',
                    'ingredient_category_id' => $category->id,
                ]);

                Ingredient::create([
                    'name' => 'L',
                    'price' => 0,
                    'image' => '',
                    'ingredient_category_id' => $category->id,
                ]);

                Ingredient::create([
                    'name' => 'X',
                    'price' => 0,
                    'image' => '',
                    'ingredient_category_id' => $category->id,
                ]);
            }
        }
    }
}
