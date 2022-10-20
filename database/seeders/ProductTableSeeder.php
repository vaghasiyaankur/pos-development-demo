<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IngredientCategory;
use App\Models\Ingredient;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductIngredient;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //  Ingredient-Category And Ingredient
        $ingcategories = [
            'Nutrient' => [
                'ingredient' => [
                    ['id' => 5,'name' => 'butter','prize' => '10','type' => '1'],  //  type =  1 is veg and type = 0 is non-veg
                    ['id' => 6,'name' => 'Bacon','prize' => '11','type' => '0'],
                ]
            ]
        ];

        
        //  Category And Product
        $categories = [
            'pizza' => [
                'products' => [
                    ['id' => 1,'name' => 'margreta','prize' => '10','type' => '1'], //  type =  1 is veg and type = 0 is non-veg
                    ['id' => 2,'name' => 'cheeze','prize' => '10','type' => '0'],
                ]
            ]
        ];


        // Product Size
        $productsizes =  [
            ['size_id' => 1, 'product_id' => 1, 'prize' => 10],
            ['size_id' => 2, 'product_id' => 1, 'prize' => 15],
            ['size_id' => 3, 'product_id' => 1, 'prize' => 20],
            ['size_id' => 4, 'product_id' => 1, 'prize' => 25]
        ];


        // Product Size
        $productings =  [
            ['ing_id' => 5, 'product_id' => 1],
            ['ing_id' => 6, 'product_id' => 1],
            ['ing_id' => 5, 'product_id' => 2],
            ['ing_id' => 6, 'product_id' => 2]
        ];


        $ingrecat = IngredientCategory::create(['name' => 'size','description' => 'Lorem Ipsum',]);
        Ingredient::create(['id' => 1,'name' => 'S','price' => 0,'image' => '','ingredient_category_id' => $ingrecat->id]);
        Ingredient::create(['id' => 2,'name' => 'M','price' => 0,'image' => '','ingredient_category_id' => $ingrecat->id]);
        Ingredient::create(['id' => 3,'name' => 'L','price' => 0,'image' => '','ingredient_category_id' => $ingrecat->id]);
        Ingredient::create(['id' => 4,'name' => 'X','price' => 0,'image' => '','ingredient_category_id' => $ingrecat->id]);

        foreach($ingcategories as $name=>$ingcat){
            $ingrecat = IngredientCategory::create([
            'name' => $name,
            'description' => 'Lorem Ipsum',
            ]);
            foreach(@$ingcat['ingredient'] as $ing){
                Ingredient::create([
                    'name' => $ing['id'],
                    'name' => $ing['name'],
                    'price' => 10,
                    'image' => 'ingredient/'.\Str::slug($ing['name']).'.png',
                    'ingredient_category_id' => $ingrecat->id,
                ]);
            }
        }

        foreach($categories as $name=>$category){
            $cat = Category::create([
                'name' => $name,
                'image' => 'category/'.\Str::slug($name).'.png',
                'featured' => 0,
            ]);
            foreach(@$category['products'] as $product){
                $product = Product::create([
                    'name' => $product['name'],
                    'image' => 'product/'.\Str::slug($product['name']).'.png',
                    'featured' => 0,
                    'status' => 1,
                    'food_type' => $product['type'],
                    'price' => $product['prize'],
                    'category_id' => $cat->id,
                ]);
            }
        }

        foreach($productsizes as $prosize){
            ProductSize::create([
                'size_id' => $prosize['size_id'],
                'product_id' => $prosize['product_id'],
                'price' => $prosize['prize']
            ]); 
        }

        foreach($productings as $proing){
            ProductIngredient::create([
                'ingredient_id' => $proing['ing_id'],
                'product_id' => $proing['product_id']
            ]); 
        }

    }
}
