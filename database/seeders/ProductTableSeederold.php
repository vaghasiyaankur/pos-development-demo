<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $categories = Category::get();
        // $products = [
        //     'cheeze',
        //     'test',
        //     'port',
        // ];

        // foreach($categories as $ckey=>$category){
        //     foreach($products as $skey=>$product){
        //         $product = Product::create([
        //             'name' => $category->name.' '.$product,
        //             'image' => 'product/'.($ckey + 1).''.($skey + 1).'.png',
        //             'featured' => 0,
        //             'status' => 1,
        //             'food_type' => rand(0, 1),
        //             'price' => ($ckey + 1).''.($skey + 1),
        //             'category_id' => $category->id,
        //         ]);

        //         ProductSize::create([
        //             'size_id' => 1,
        //             'product_id' => $product->id,
        //             'price' => 10
        //         ]);
        //     }
        // }
        // $categories = [
        //     'pizza' => [
        //         'products' => [

        //         ] 
        //     ]
        // ]
    }
}
