<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Combo;
use App\Models\ComboProduct;

class ComboSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $combos = ['combo 1', 'combo 2', 'combo 3', 'combo 4', 'combo 5'];
        foreach($combos as $key=>$combos){
            $products = Product::all()->random(2);
            $price = 0;
            foreach($products as $product){
                $price += $product->price;
            }
            $price -= 10;
            $combo = Combo::create([
                'name' => $combos,
                'price' => $price,
                'image' => 'combo/'.($key+1).'.png',
                'food_type' => rand(0, 1),
            ]);


            foreach($products as $product){
                $combopro = new ComboProduct;
                $combopro->combo_id =  $combo->id;
                $combopro->product_id = $product->id;
                $combopro->timestamps = false;
                $combopro->save();
            }

        }

    }
}
