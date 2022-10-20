<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
           ['name' => 'Super Admin', 'email' => 'superadmin@gmail.com', 'password' => Hash::make('123456789'), 'type' => 'super_admin', 'photo' => 'user/super_admin.jpg','govt_id' => 'govId/super_admin.jpg','active' => 1,'lock_pin'=>1234],
           ['name' => 'Sub Admin', 'email' => 'subadmin@gmail.com', 'password' => Hash::make('123456789'), 'type' => 'sub_admin', 'photo' => 'user/sub_admin.jpg','govt_id' => 'govId/sub_admin.jpg','active' => 1,'lock_pin'=>5678],
           ['name' => 'Kitchen Manager', 'email' => 'kitchenmanager@gmail.com', 'password' => Hash::make('123456789'), 'type' => 'kitchen_manager', 'photo' => 'user/kitchen_manager.jpg','govt_id' => 'govId/kitchen_manager.jpg','active' => 1,'lock_pin'=>9012],
           ['name' => 'Waiter', 'email' => 'waiter@gmail.com', 'password' => Hash::make('123456789'), 'type' => 'waiter', 'photo' => 'user/waiter.jpg','govt_id' => 'govId/waiter.jpg','active' => 1,'lock_pin'=>3456],
        ];

        foreach($datas as $data){
            User::create($data);
        }
    }
}
