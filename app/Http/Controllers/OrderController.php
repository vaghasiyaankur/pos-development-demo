<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Auth;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Setting;
use App\Models\Table;
use App\Models\Product;
use App\Models\Combo;
use App\Models\TableOrder;
use App\Models\Tax;

class OrderController extends Controller
{

    /**
     * Get Order List
     *
     * @return Json
     *
     */
    public function  getOrder(Request $request)
    {
        $orderData = session()->get('demoOrderData');
        $orders = [];

        if($orderData){
            foreach($orderData as $orderPro){
                foreach($orderPro as $key=>$order){
                    if($key != 'table' && $key != 'customer_name' && $key != 'customer_number' && $key != 'customer_email' && $key != 'ordered'){
                        $data = [];
                        // dd($orderPro);
                        foreach($order['order_product'] as $op){
                            if(array_key_exists('product_id',$op)){
                                $product = Product::where('id', $op['product_id'])->first();
                                $data[$product->name][$product->id]['quantity'] = $op['quantity'];
                                $data[$product->name][$product->id]['name'] = $product->name;
                                $data[$product->name][$product->id]['price'] = $op['amount'];
                            }else if(array_key_exists('combo_id',$op)){
                                $combo = Combo::where('id', $op['combo_id'])->first();
                                $data[$combo->name][$combo->id]['quantity'] = $op['quantity'];
                                $data[$combo->name][$combo->id]['name'] = $combo->name;
                                $data[$combo->name][$combo->id]['price'] = $op['amount'];
                            }else if(array_key_exists('ingredient_id',$op)){
                                $ingredient = Ingredient::where('id', $op['ingredient_id'])->first();
                                $data[$ingredient->name][$ingredient->id]['quantity'] = $op['quantity'];
                                $data[$ingredient->name][$ingredient->id]['name'] = $ingredient->name;
                                $data[$ingredient->name][$ingredient->id]['price'] = $op['amount'];
                            }
                        }
    
                        $table = Table::where('id', $orderPro['table'])->first();
                        $diff = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order['created_at'])->diffInMinutes(\Carbon\Carbon::now());
                        $orders[$key]['color'] = @$table->color;
                        $orders[$key]['customer_name'] = @$orderPro['customer_name'];
                        $orders[$key]['diff'] = $diff;
                        $orders[$key]['data'] = $data;
                        $orders[$key]['order_count'] = count($orderPro) - 4;
                        $orders[$key]['ordered'] = @$orderPro['ordered'];
                        $orders[$key]['pay_amount'] = $order['pay_amount'];
                        $orders[$key]['table'] = @$table->number;
                        $orders[$key]['tableId'] = @$table->id;
                        $orders[$key]['total_amount'] = $order['total_amount'];
                        break 1;
                    }
                }
            }
        }
            return response()->json(['orders' => $orders]);
    }

    /**
     * Time Different For Order
     *
     * @return Json
     *
     */
    public function  getOrdersTime(Request $request)
    {
        $orderData = session()->get('demoOrderData');
        $timediff = [];
        foreach($orderData as $orderPro){
            foreach($orderPro as $key=>$order){
                if($key != 'table' && $key != 'customer_name' && $key != 'customer_number' && $key != 'customer_email' && $key != 'ordered'){
                    $diff = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order['created_at'])->diffInMinutes(\Carbon\Carbon::now());
                    $timediff[$key] = $diff;
                }
            }
        }
        // $user_id = Auth::user()->id;
        // $orderData = Order::get()->whereNotNull('tableOrder.table_id')->groupBy('tableOrder.table_id');
        // $timediff = [];

        // foreach($orderData as $order){
        //     foreach($order as $ord){
        //         $diff = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ord->created_at)->diffInMinutes(\Carbon\Carbon::now());

        //         $timediff[$ord->id] = $diff;
        //     }
        // }

        return response()->json(['timediff' => $timediff]);
    }

    /**
     * Get Single Order For Popup
     *
     * @return Json
     *
     */
    public function  getOrderForPopup(Request $request)
    {
        $tableId = $request->table;
        $orderData = session()->get('demoOrderData');
        $popupOrders = [];
        $popuporder = [];
        foreach($orderData as $key=>$orderPro){
            if($orderPro['table'] == $tableId){
                $popuporder = $orderData[$key];
            }
        }

        foreach($popuporder as $key=>$order){
            if($key != 'table' && $key != 'customer_name' && $key != 'customer_number' && $key != 'customer_email' && $key != 'ordered'){
                $data = [];
                foreach($order['order_product'] as $op){
                    if(array_key_exists('product_id',$op)){
                        $product = Product::where('id', $op['product_id'])->first();
                        $data[$product->name][$product->id]['quantity'] = $op['quantity'];
                        $data[$product->name][$product->id]['name'] = $product->name;
                        $data[$product->name][$product->id]['price'] = $op['amount'];
                    }else if(array_key_exists('combo_id',$op)){
                        $combo = Combo::where('id', $op['combo_id'])->first();
                        $data[$combo->name][$combo->id]['quantity'] = $op['quantity'];
                        $data[$combo->name][$combo->id]['name'] = $combo->name;
                        $data[$combo->name][$combo->id]['price'] = $op['amount'];
                    }else if(array_key_exists('ingredient_id',$op)){
                        $ingredient = Ingredient::where('id', $op['ingredient_id'])->first();
                        $data[$ingredient->name][$ingredient->id]['quantity'] = $op['quantity'];
                        $data[$ingredient->name][$ingredient->id]['name'] = $ingredient->name;
                        $data[$ingredient->name][$ingredient->id]['price'] = $op['amount'];
                    }
                }

                $table = Table::where('id', $popuporder['table'])->first();
                $diff = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order['created_at'])->diffInMinutes(\Carbon\Carbon::now());
                $popupOrders[$key]['color'] = @$table->color;
                $popupOrders[$key]['customer_name'] = @$popuporder['customer_name'];
                $popupOrders[$key]['diff'] = $diff;
                $popupOrders[$key]['data'] = $data;
                $popupOrders[$key]['order_count'] = count($popuporder) - 4;
                $popupOrders[$key]['ordered'] = @$popuporder['ordered'];
                $popupOrders[$key]['pay_amount'] = $order['pay_amount'];
                $popupOrders[$key]['table'] = @$table->number;
                $popupOrders[$key]['tableId'] = @$table->id;
                $popupOrders[$key]['total_amount'] = $order['total_amount'];
            }
        }
        return response()->json(['popupOrders' => $popupOrders]);
    }

    /**
     * Send Order Data For Print
     *
     * @return Json
     *
     */
    public function printOrder(Request $request)
    {
        $id = $request->id;
        $printData = [];
        $printData['sub_total'] = 0;
        $printData['pay_total'] = 0;
        $printOrdersData = [];


        $orderData = session()->get('demoOrderData');
        $printorder = [];
        // dd($orderData);
        foreach($orderData as $key=>$orderPro){
            if($orderPro['table'] == $id){
                $printorder = $orderData[$key];
            }
        }

        $printOrdersData = [];
        foreach($printorder as $key=>$order){
            if($key != 'table' && $key != 'customer_name' && $key != 'customer_number' && $key != 'customer_email' && $key != 'ordered'){
                foreach($order['order_product'] as $op){
                    if(array_key_exists('product_id',$op)){
                        $product = Product::where('id', $op['product_id'])->first();
                        $printOrdersData[$key.'-'.$product->id.'-product']['quantity'] = $op['quantity'];
                        $printOrdersData[$key.'-'.$product->id.'-product']['name'] = $product->name;
                        $printOrdersData[$key.'-'.$product->id.'-product']['price'] = $op['amount'];
                    }else if(array_key_exists('combo_id',$op)){
                        $combo = Combo::where('id', $op['combo_id'])->first();
                        $printOrdersData[$key.'-'.$combo->id.'-combo']['quantity'] = $op['quantity'];
                        $printOrdersData[$key.'-'.$combo->id.'-combo']['name'] = $combo->name;
                        $printOrdersData[$key.'-'.$combo->id.'-combo']['price'] = $op['amount'];
                    }else if(array_key_exists('ingredient_id',$op)){
                        $ingredient = Ingredient::where('id', $op['ingredient_id'])->first();
                        $printOrdersData[$key.'-'.$ingredient->id.'-ingredient']['quantity'] = $op['quantity'];
                        $printOrdersData[$key.'-'.$ingredient->id.'-ingredient']['name'] = $ingredient->name;
                        $printOrdersData[$key.'-'.$ingredient->id.'-ingredient']['price'] = $op['amount'];
                    }
                    $purchaseType = $order['purchase_type'];
                }
                $printData['sub_total'] += $order['total_amount'];
                $printData['pay_total'] += $order['pay_amount'];
            }
        }

        $allTax = Tax::where('status', 1)->get();
        $taxes = [];
        foreach($allTax as $tax){
            if($tax->tax_type == 'percentage'){
                $taxValue = ($printData['sub_total'] * $tax->tax_value) / 100;
                $taxes[$tax->id]['name'] = $tax->name;
                $taxes[$tax->id]['value'] = $taxValue;
                $printData['pay_total'] += $taxValue;
            }else{
                $taxes[$tax->id]['name'] = $tax->name;
                $taxes[$tax->id]['value'] = $tax->tax_value;
                $printData['pay_total'] += $tax->tax_value;
            }
        }

        $printData['taxes'] = $taxes;
        $setting = Setting::pluck('value','type');
        if($purchaseType == 'dinein') $type='Dine In';
        elseif($purchaseType == 'takeaway') $type='Take Away';
        elseif($purchaseType == 'delivery') $type='Delivery';
        
        date_default_timezone_set($setting['time_zone']);
        $Date = date('m-d-Y', time());
        $Time = date('H:i', time());
        $printData['current_date'] = $Date;
        $printData['current_time'] = $Time;
        $printData['purchase_type'] = $type;
        $printData['table'] = $printorder['table'];
        $printData['customer_name'] = $printorder['customer_name'];
        $printData['footer'] = $setting['print_bill_footer'];
        $printData['logo'] = $setting['logo'];
        return response()->json(['printData' => $printData, 'printOrdersData' => $printOrdersData]);

    }

    /**
     * Order Save In Database
     *
     * @return Json
     *
     */
    public function orderSave(Request $request)
    {
        $orderData = session()->get('demoOrderData');
        foreach($orderData as $key=>$orderPro){
            if($orderPro['table'] == $request->tableId){
                $orderData[$key]['ordered'] = 1;
            }
        }
        session()->put('demoOrderData', $orderData);
        return response()->json(['success' => "Order serve successfully."]);
    }

     /**
     * Pay Order=
     *
     * @return Json
     *
     */
    public function orderPay(Request $request)
    {
        $orderData = session()->get('demoOrderData');
        $data = [];
        foreach($orderData as $key=>$orderPro){
            if($orderPro['table'] == $request->tableId){
                session()->push('demoCompleteOrderData', $orderPro);
            }else{
                $data[$key] = $orderPro;
            }
        }


        session()->put('demoOrderData', $data);

        return response()->json(['success' => "Order payed successfully."],200);
    }
}
