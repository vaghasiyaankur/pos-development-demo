<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            // CategoryTableSeeder::class,
            // IngredientCategorySeeder::class,
            // IngredientSeeder::class,
            ProductTableSeeder::class,
            PermissionSeeder::class,
            ComboSeeder::class,
            TableSeeder::class,
            SettingSeeder::class,
            TaxSeeder::class,
        ]);
    }
}
