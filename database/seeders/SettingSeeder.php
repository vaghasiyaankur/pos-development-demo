<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'restaurent_name' => 'Pos Development',
            'logo' => 'setting/logo.png',
            'fav_icon' => 'setting/fav_icon.png',
            'address' => '408 23rd St, Canyo, Texas, United States-79015',
            'phone' => '(806) 655-4736',
            'time_zone' => 'Asia/Kolkata',
            'print_bill_header' => 'Pos Development',
            'print_bill_footer' => 'Thank you, See you again',
            'currency_name' => 'Indian Ruppe',
            'currency_code' => 'INR',
            'currency_symbol' => '₹',
        ];

        foreach($data as $type => $value){
            Setting::create([
                'type' => $type,
                'value' => $value,
            ]);
        }



    }
}
