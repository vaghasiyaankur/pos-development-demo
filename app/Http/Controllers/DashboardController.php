<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use DB;

class DashboardController extends Controller
{

    /**
     * Check Recent Order (Cron Job)
     *
     * @return Tables Number
     * 
     */
    public function recentOrder()
    {
        $date  = Carbon::now()->subSecond(4);
        $orders = Order::where( 'created_at', '>=', $date )->get();
        $tables = [];
        foreach($orders as $key=>$order){
            $tables[$key] = @$order->tableOrder->table->number;
        }
        return $tables;
    }

    /**
     * Get DashBoard Data
     *
     * @return Json
     * 
     */
    public function getdashboarddata()
    {
        $total_orders = Order::count();
        $complete_orders = Order::where('payed', 1)->count();
        $pending_orders = Order::where('payed', 0)->count();
        $total_billed = Order::where('payed', 1)->count();
        $latest_orders = Order::where('payed', 0)->orderBy('id', 'desc')->take(6)->get();
        $recently_add = Product::orderBy('id', 'desc')->take(6)->get();
        $recently_update = Product::orderBy('updated_at', 'desc')->take(6)->get();
        $product_id = OrderProduct::groupBy('product_id')->whereNotNull('product_id')->select('product_id', DB::raw('count(*) as total'))->orderBy('total', 'desc')->pluck('product_id');

        $top_selling = Product::whereIn('id',$product_id)->orderBy('id', 'desc')->take(6)->get();

        return response()->json(['total_orders' => $total_orders,'complete_orders' => $complete_orders,'pending_orders' => $pending_orders,'total_billed' => $total_billed,'latest_orders' => $latest_orders,'recently_add' => $recently_add,'recently_update' => $recently_update,'top_selling' => $top_selling]);
    }
}
