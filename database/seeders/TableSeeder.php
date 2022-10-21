<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;
use App\Models\TableType;
use Illuminate\Support\Arr;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // $current = ['Available','Deactive'];
        // $current = ['Available','Running','Deactive'];

        $current = ['Available'];
        $tables = [
            "1","2","3","4","5","6","7","8","9","10"
        ];
        $colors = [
            "243, 205, 184","29, 78, 137","125, 207, 182","0, 178, 202","243, 62, 62","247, 184, 75","201, 220, 245","0, 179, 156","37, 50, 56","255, 29, 180"
        ];
        // $colors = [
        //     "240,255,234","200,132,158","135, 151, 134","160, 178, 202","77,225,255","247, 171, 75","201, 220, 245","220, 110, 191","255, 121, 121","255, 140, 180"
        // ];
        foreach($tables as $key=>$table){
            Table::create([
                'number' => $table,
                'color' => $colors[$key],
                'current' => Arr::random($current),
                'capacity' => rand('1','10')
            ]);
        }
    }
}
