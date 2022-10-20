<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
           ['function' => 'Login', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 1,'waiter' => 1],
           ['function' => 'Index', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'Pos', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 1,'waiter' => 1],
           ['function' => 'Category', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 1,'waiter' => 0],           
           ['function' => 'subCategory', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 1,'waiter' => 0],
           ['function' => 'CategoryAdd', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'CategoryDelete', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'CategoryEdit', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'Product', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 1,'waiter' => 0],
           ['function' => 'ProductAdd', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'ProductEdit', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'ProductDelete', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'IngredientCategory', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 1,'waiter' => 0],
           ['function' => 'IngredientCategoryAdd', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'IngredientCategoryEdit', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'IngredientCategoryDelete', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'Ingredient', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 1,'waiter' => 0],
           ['function' => 'IngredientAdd', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'IngredientEdit', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'IngredientDelete', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'Combo', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 1,'waiter' => 0],
           ['function' => 'ComboAdd', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'ComboEdit', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'ComboDelete', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'UserManagement', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'UserManagementAdd', 'super_admin' => 1, 'sub_admin' => 0,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'UserManagementEdit', 'super_admin' => 1, 'sub_admin' => 0,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'UserManagementDelete', 'super_admin' => 1, 'sub_admin' => 0,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'AdminManagement', 'super_admin' => 1, 'sub_admin' => 0,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'Orders', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 1,'waiter' => 1],
           ['function' => 'OrdersSaved', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 1,'waiter' => 1],
           ['function' => 'OrdersPayed', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 1,'waiter' => 1],
           ['function' => 'OrdersPrint', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 1,'waiter' => 1],
           ['function' => 'Table', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 1,'waiter' => 1],
           ['function' => 'TableAdd', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 1,'waiter' => 0],
           ['function' => 'TableStatus', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 1,'waiter' => 0],
           ['function' => 'Setting', 'super_admin' => 1, 'sub_admin' => 0,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'SettingUpdate', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'Report', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
           ['function' => 'Completeorder', 'super_admin' => 1, 'sub_admin' => 1,'kitchen_manager' => 0,'waiter' => 0],
        ];   

        foreach($datas as $data){
            Permission::create($data);
        }
    }
}
