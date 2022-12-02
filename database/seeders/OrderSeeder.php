<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\TableOrder;
use App\Models\Customer;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            Order::create([
                'id' => 1,
                'ordered' => 0,
                'payed' => 0,
                'pay_amount' => 43.00,
                'total_amount' => 43.00,
                'purchase_type' => 'dinein',
                'user_id' => 1
            ]);

            Order::create([
                'id' => 2,
                'ordered' => 0,
                'payed' => 0,
                'pay_amount' => 83.00,
                'total_amount' => 83.00,
                'purchase_type' => 'dinein',
                'user_id' => 1
            ]);

            Order::create([
                'id' => 3,
                'ordered' => 1,
                'payed' => 1,
                'pay_amount' => 43.00,
                'total_amount' => 43.00,
                'purchase_type' => 'dinein',
                'user_id' => 1
            ]);

            Order::create([
                'id' => 4,
                'ordered' => 1,
                'payed' => 1,
                'pay_amount' => 83.00,
                'total_amount' => 83.00,
                'purchase_type' => 'dinein',
                'user_id' => 1
            ]);

            
            OrderProduct::create(['order_id' => 1, 'product_id' => 1, 'amount' => 21.00, 'quantity' => 1.00]);
            OrderProduct::create(['order_id' => 1, 'product_id' => 2, 'amount' => 22.00, 'quantity' => 1.00]);
            OrderProduct::create(['order_id' => 2, 'product_id' => 7, 'amount' => 47.00, 'quantity' => 1.00]);
            OrderProduct::create(['order_id' => 2, 'product_id' => 8, 'amount' => 42.00, 'quantity' => 1.00]);

            OrderProduct::create(['order_id' => 3, 'product_id' => 1, 'amount' => 21.00, 'quantity' => 1.00]);
            OrderProduct::create(['order_id' => 3, 'product_id' => 2, 'amount' => 22.00, 'quantity' => 1.00]);
            OrderProduct::create(['order_id' => 4, 'product_id' => 7, 'amount' => 47.00, 'quantity' => 1.00]);
            OrderProduct::create(['order_id' => 4, 'product_id' => 8, 'amount' => 42.00, 'quantity' => 1.00]);


            Customer::create([
                'id' => 10,
                'name' => 'test',
                'email' => 'test@gmail.com',
                'phone' => '1234567890'
            ]);

            TableOrder::create(['order_id' => 1, 'table_id' => 1, 'customer_id' => 10]);
            TableOrder::create(['order_id' => 2, 'table_id' => 2, 'customer_id' => 10]);


            TableOrder::create(['order_id' => 3, 'table_id' => 1, 'customer_id' => 10]);
            TableOrder::create(['order_id' => 4, 'table_id' => 2, 'customer_id' => 10]);
        }
}
