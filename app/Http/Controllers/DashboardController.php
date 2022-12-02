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
        $total_orders = 0;
        $complete_orders = 0;
        $pending_orders = 0;
        $total_billed = 0;


        $latest_orders = [];
        $product_id = OrderProduct::groupBy('product_id')->whereNotNull('product_id')->select('product_id', DB::raw('count(*) as total'))->orderBy('total', 'desc')->pluck('product_id');
        
        $top_selling = Product::orderBy('id', 'desc')->take(6)->get();
        

        // $orderData = session()->get('demoOrderData');
        // $orders = [];
        // $ltfive = 0;

        // if($orderData){
        //     foreach($orderData as $k => $orderPro){
        //         foreach($orderPro as $key=>$order){
        //             if($key != 'table' && $key != 'customer_name' && $key != 'customer_number' && $key != 'customer_email' && $key != 'ordered'){
        //                 $total_orders += 1;
        //                 $pending_orders += 1;
        //             }

        //             if($key != 'table' && $key != 'customer_name' && $key != 'customer_number' && $key != 'customer_email' && $key != 'ordered' && $ltfive < 5){
        //                 $ltfive += 1;
        //                 $latest_orders[$k.'-'.$key]['created_at'] = $order['created_at'];
        //                 $latest_orders[$k.'-'.$key]['id'] = $k.'-'.$key;
        //                 $latest_orders[$k.'-'.$key]['ordered'] = 1;
        //                 $latest_orders[$k.'-'.$key]['pay_amount'] = $order['pay_amount'];
        //                 $latest_orders[$k.'-'.$key]['payed'] = 1;
        //                 $latest_orders[$k.'-'.$key]['purchase_type'] = $order['purchase_type'];
        //                 $latest_orders[$k.'-'.$key]['total_amount'] = $order['total_amount'];
        //                 $latest_orders[$k.'-'.$key]['updated_at'] = $order['created_at'];
        //                 $latest_orders[$k.'-'.$key]['user_id'] = 1;
        //             }
        //         }
        //     }
        // }
        $latest_orders = Order::where('payed', 0)->orderBy('id', 'desc')->take(6)->get();

        $completeOrderData = session()->get('demoCompleteOrderData');
        $completed_orders = [];
        // dd('1');
        // dd($completeOrderData);
        if($completeOrderData){
            foreach($completeOrderData as $k=>$completeOrder){
                foreach($completeOrder as $key=>$corder){
                    if($key != 'table' && $key != 'customer_name' && $key != 'customer_number' && $key != 'customer_email' && $key != 'ordered'){
                        $total_orders += 1;
                        $complete_orders += 1;
                        $total_billed += 1;
                    }
                }
            }
        }

        $recently_add = Product::orderBy('id', 'desc')->take(6)->get();
        $recently_update = Product::orderBy('updated_at', 'desc')->take(6)->get();

        return response()->json(['total_orders' => $total_orders,'complete_orders' => $complete_orders,'pending_orders' => $pending_orders,'total_billed' => $total_billed,'latest_orders' => $latest_orders,'recently_add' => $recently_add,'recently_update' => $recently_update,'top_selling' => $top_selling]);
    }
}
