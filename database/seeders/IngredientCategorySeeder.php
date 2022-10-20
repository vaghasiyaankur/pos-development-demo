<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IngredientCategory;

class IngredientCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'size',
            'Käse',
            'Fleisch',
            'Fisch',
            'Gemüse',
            'Sonstiges',
        ];
        foreach($categories as $key=>$category){
            IngredientCategory::create([
                'name' => $category,
                'description' => $category,
            ]);
        }
    }
}
