<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Table;
use Validator;

class TableController extends Controller
{
    /**
     * Get Table List Data
     *
     * @return Json
     * 
     */
    public function gettablelist()
    {
        $TablesAvailable = Table::where('current', 'Available')->get();
        $TablesRunning = Table::where('current', 'Running')->get();
        $TablesDeactive = Table::where('current', 'Deactive')->get();

        $availTables = [];
        $runningTables = [];
        $deactiveTables = [];
        foreach ($TablesAvailable as $key => $table) {
            $availTables[$table->id] = $table;
        }
        foreach ($TablesRunning as $table) {
            $runningTables[$table->id] = $table;
        }
        foreach ($TablesDeactive as $table) {
            $deactiveTables[$table->id] = $table;
        }
        $colors = Table::all()->unique('color')->pluck('color');
        return response()->json(['availTables' => $availTables, 'runningTables' => $runningTables, 'deactiveTables' => $deactiveTables, 'colors' => $colors]);
    }

    /**
     * Add Table In DataBase
     *
     * @return Json
     * 
     */
    public function addtable(Request $request)
    {
        $tabledata = $request->only('number', 'capacity', 'color');

        $validator = Validator::make($tabledata, [
            'number' => 'required|unique:tables,number',
            'capacity' => 'required|numeric|min:1',
            'color' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

        if($request->status){
            $current = 'Available';
        }else{
            $current = 'Deactive';
        }

        $table = new Table;
        $table->number = $request->number;
        $table->capacity = $request->capacity;
        $table->color = $request->color;
        $table->current = @$current;
        $table->save();

        return 1;
    }

    /**
     * Get Table Time
     *
     * @return Json
     * 
     */
    public function gettablesTime(Request $request)
    {
        $orderData = Table::with('tableOrders')->get();
        $timediff = [];
        foreach($orderData as $order){
            foreach($order->tableOrders as $ord){
                $diff = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ord->created_at)->diffInMinutes(\Carbon\Carbon::now());

                $timediff[$order->id] = $diff;
            }
        }
        return response()->json(['timediff' => $timediff]);
    }

    /**
     * Update Status For Table In DataBase
     *
     * @return 1;
     * 
     */
    public function changeTableStatus(Request $request)
    {
        Table::where('id',$request->id)->update(['current'=>$request->status]);
        return 1;
    }
}
