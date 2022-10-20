<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tax;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxes = [
            ['name' => 'GST', 'tax_type' => 'percentage', 'tax_value' => 18, 'status' => 1],
            ['name' => 'Service', 'tax_type' => 'flat', 'tax_value' => 100, 'status' => 1],
            ['name' => 'OTHER', 'tax_type' => 'percentage', 'tax_value' => 8, 'status' => 0],
        ];

        foreach($taxes as $tax){
            Tax::create($tax);
        }
    }
}
