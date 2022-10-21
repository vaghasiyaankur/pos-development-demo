<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Setting;
use App\Models\Table;
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
        $data = session()->get('demoOrderData');
        dd($data);
        $user_id = Auth::user()->id;
        $orderData = Order::where('payed',0)->get()->whereNotNull('tableOrder.table_id')->groupBy('tableOrder.table_id');
        $orders = [];
        foreach($orderData as $order){
            $firstOrder = $order[0];
            $data = [];
            $orderProData = $firstOrder->orderProduct;
                foreach($orderProData as $orderPro){
                    if($orderPro->product){
                        $data[$orderPro->product->name][$orderPro->product->id]['quantity'] = $orderPro->quantity;
                        $data[$orderPro->product->name][$orderPro->product->id]['name'] = $orderPro->product->name;
                        $data[$orderPro->product->name][$orderPro->product->id]['price'] = $orderPro->amount;
                    }
                    if($orderPro->combo){
                        $data[$orderPro->combo->name][$orderPro->combo->id]['quantity'] = $orderPro->quantity;
                        $data[$orderPro->combo->name][$orderPro->combo->id]['name'] = $orderPro->combo->name;
                        $data[$orderPro->combo->name][$orderPro->combo->id]['price'] = $orderPro->amount;
                    }
                    if($orderPro->ingredient){
                        $data[$orderPro->ingredient->name][$orderPro->ingredient->id]['quantity'] = $orderPro->quantity;
                        $data[$orderPro->ingredient->name][$orderPro->ingredient->id]['name'] = $orderPro->ingredient->name;
                        $data[$orderPro->ingredient->name][$orderPro->ingredient->id]['price'] = $orderPro->amount;
                    }

                }

                $diff = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $firstOrder->created_at)->diffInMinutes(\Carbon\Carbon::now());

                $orders[$firstOrder->id]['pay_amount'] = $firstOrder->pay_amount;
                $orders[$firstOrder->id]['total_amount'] = $firstOrder->total_amount;
                $orders[$firstOrder->id]['table'] = $firstOrder->tableOrder->table->number;
                $orders[$firstOrder->id]['ordered'] = $firstOrder->ordered;
                $orders[$firstOrder->id]['tableId'] = $firstOrder->tableOrder->table->id;
                $orders[$firstOrder->id]['color'] = $firstOrder->tableOrder->table->color;
                $orders[$firstOrder->id]['customer_name'] = $firstOrder->tableOrder->customer->name;
                $orders[$firstOrder->id]['order_count'] = $order->count();
                $orders[$firstOrder->id]['data'] = $data;
                $orders[$firstOrder->id]['diff'] = $diff;
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
        $user_id = Auth::user()->id;
        $orderData = Order::get()->whereNotNull('tableOrder.table_id')->groupBy('tableOrder.table_id');
        $timediff = [];

        foreach($orderData as $order){
            foreach($order as $ord){
                $diff = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ord->created_at)->diffInMinutes(\Carbon\Carbon::now());

                $timediff[$ord->id] = $diff;
            }
        }

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
        $user_id = Auth::user()->id;
        $orderData = Order::where('payed',0)->get()->where('tableOrder.table_id', $tableId);
        $popupOrders = [];

        foreach($orderData as $order){
            $data = [];
            $orderProData = $order->orderProduct;
            foreach($orderProData as $orderPro){
                if($orderPro->product){
                    $data[$orderPro->product->category->name][$orderPro->product->id]['quantity'] = $orderPro->quantity;
                    $data[$orderPro->product->category->name][$orderPro->product->id]['name'] = $orderPro->product->name;
                    $data[$orderPro->product->category->name][$orderPro->product->id]['price'] = $orderPro->amount;
                }
                if($orderPro->combo){
                    $data[$orderPro->combo->name][$orderPro->combo->id]['quantity'] = $orderPro->quantity;
                    $data[$orderPro->combo->name][$orderPro->combo->id]['name'] = $orderPro->combo->name;
                    $data[$orderPro->combo->name][$orderPro->combo->id]['price'] = $orderPro->amount;
                }
                if($orderPro->ingredient){
                    $data[$orderPro->ingredient->name][$orderPro->ingredient->id]['quantity'] = $orderPro->quantity;
                    $data[$orderPro->ingredient->name][$orderPro->ingredient->id]['name'] = $orderPro->ingredient->name;
                    $data[$orderPro->ingredient->name][$orderPro->ingredient->id]['price'] = $orderPro->amount;
                }
            }

            $diff = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->diffInMinutes(\Carbon\Carbon::now());

            $popupOrders[$order->id]['pay_amount'] = $order->pay_amount;
            $popupOrders[$order->id]['total_amount'] = $order->total_amount;
            $popupOrders[$order->id]['table'] = $order->tableOrder->table->number;
            $popupOrders[$order->id]['color'] = $order->tableOrder->table->color;
            $popupOrders[$order->id]['customer_name'] = $order->tableOrder->customer->name;
            $popupOrders[$order->id]['order_count'] = $order->count();
            $popupOrders[$order->id]['data'] = $data;
            $popupOrders[$order->id]['diff'] = $diff;
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
        $user_id = Auth::user()->id;
        $orderData = Order::where('payed', 0)->whereHas('tableOrder', function($q) use($id){
            $q->where('table_id', $id);
        })->get();

        $orders = [];
        $printData['sub_total'] = 0;
        $printData['pay_total'] = 0;
        foreach($orderData as $order){
            $data = [];
            $orderProData = $order->orderProduct;
                foreach($orderProData as $orderPro){
                    if($orderPro->product){
                        $printOrdersData[$order->id.'-'.$orderPro->product->id.'-product']['quantity'] = $orderPro->quantity;
                        $printOrdersData[$order->id.'-'.$orderPro->product->id.'-product']['name'] = $orderPro->product->name;
                        $printOrdersData[$order->id.'-'.$orderPro->product->id.'-product']['price'] = $orderPro->amount;
                    }
                    if($orderPro->combo){
                        $printOrdersData[$order->id.'-'.$orderPro->combo->id.'-combo']['quantity'] = $orderPro->quantity;
                        $printOrdersData[$order->id.'-'.$orderPro->combo->id.'-combo']['name'] = $orderPro->combo->name;
                        $printOrdersData[$order->id.'-'.$orderPro->combo->id.'-combo']['price'] = $orderPro->amount;
                    }
                    if($orderPro->ingredient){
                        $printOrdersData[$order->id.'-'.$orderPro->ingredient->id.'-ingredient']['quantity'] = $orderPro->quantity;
                        $printOrdersData[$order->id.'-'.$orderPro->ingredient->id.'-ingredient']['name'] = $orderPro->ingredient->name;
                        $printOrdersData[$order->id.'-'.$orderPro->ingredient->id.'-ingredient']['price'] = $orderPro->amount;
                    }

                }
                $printData['sub_total'] += $order->pay_amount;
                $printData['pay_total'] += $order->pay_amount;
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
        if($orderData[0]->purchase_type == 'dinein') $type='Dine In';
        elseif($orderData[0]->purchase_type == 'takeaway') $type='Take Away';
        elseif($orderData[0]->purchase_type == 'delivery') $type='Delivery';

        date_default_timezone_set($setting['time_zone']);
        $Date = date('m-d-Y', time());
        $Time = date('H:i', time());
        $printData['current_date'] = $Date;
        $printData['current_time'] = $Time;
        $printData['purchase_type'] = $type;
        $printData['table'] = $orderData[0]->tableOrder->table->number;
        $printData['customer_name'] = $order->tableOrder->customer->name;
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

        $order_id = TableOrder::where('table_id',$request->tableId)->pluck('order_id');

        $order = Order::whereIn('id',$order_id)->update(['ordered'=>1]);

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
        $order_id = TableOrder::where('table_id',$request->tableId)->pluck('order_id');

        $order = Order::whereIn('id',$order_id)->update(['ordered'=>1,'payed' => 1]);

        $table = Table::find($request->tableId);
        $table->update(['current'=>'Available']);

        return response()->json(['success' => "Order payed successfully."],200);
    }
}
