<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use App\Models\Tax;
use Illuminate\Http\Request;
use Mail;

class CompletedOrderController extends Controller
{

    /**
     * Get Complete Order Data 
     *
     * @param Request $request
     * 
     * @return Json
     * 
     */
    public function getcompleteorderddata()
    {
        $completed_orders = Order::withCount('orderProduct')->where('ordered', 1)->where('payed', 1)->with('tableOrder.customer')->orderBy('id', 'desc')->get();
        foreach($completed_orders as $completed_order){
            $date = $completed_order->created_at;
            $completed_order->create = $date->format('F d,Y \A\t h:i A');
        }
        return response()->json(['completed_orders' => $completed_orders]);
    }

    /**
     * Get Ordered Product Data 
     *
     * @param Request $request
     * 
     * @return Json
     * 
     */
    public function getOrderProduct($tableId,$orderId)
    {
        $orderData = Order::where('id', $orderId)->get()->where('tableOrder.table_id', $tableId);
        $products = [];

        foreach($orderData as $order){
            $data = [];
            $orderProData = $order->orderProduct;
            foreach($orderProData as $key => $orderPro){
                if($orderPro->product){
                    $data[$key]['quantity'] = $orderPro->quantity;
                    $data[$key]['name'] = $orderPro->product->name;
                    $data[$key]['total_price'] = $orderPro->amount;
                    $data[$key]['price'] = $orderPro->product->price;
                    $data[$key]['image'] = $orderPro->product->image;
                }
                if($orderPro->combo){
                    $data[$key]['quantity'] = $orderPro->quantity;
                    $data[$key]['name'] = $orderPro->combo->name;
                    $data[$key]['total_price'] = $orderPro->amount;
                    $data[$key]['price'] = $orderPro->combo->price;
                    $data[$key]['image'] = $orderPro->combo->image;
                }
                if($orderPro->ingredient){
                    $data[$key]['quantity'] = $orderPro->quantity;
                    $data[$key]['name'] = $orderPro->ingredient->name;
                    $data[$key]['total_price'] = $orderPro->amount;
                    $data[$key]['price'] = $orderPro->ingredient->price;
                    $data[$key]['image'] = $orderPro->ingredient->image;
                }
            }


            $products['pay_amount'] = $order->pay_amount;
            $products['total_amount'] = $order->pay_amount;
            $products['customer_name'] = $order->tableOrder->customer->name;
            $products['customer_email'] = $order->tableOrder->customer->email;
            $products['id'] = $order->id;
            $products['data'] = $data;

            $allTax = Tax::where('status', 1)->get();
            $taxes = [];
            foreach($allTax as $tax){
                if($tax->tax_type == 'percentage'){
                    $taxValue = ($products['pay_amount'] * $tax->tax_value) / 100;
                    $taxes[$tax->id]['name'] = $tax->name;
                    $taxes[$tax->id]['value'] = $taxValue;
                    $products['total_amount'] += $taxValue;
                }else{
                    $taxes[$tax->id]['name'] = $tax->name;
                    $taxes[$tax->id]['value'] = $tax->tax_value;
                    $products['total_amount'] += $tax->tax_value;
                }
            }

            $products['taxes'] = $taxes;
        }
        return response()->json(['products' => $products]);
    }

    /**
     * Complete Order Invoice Print.
     *
     * @param mixed $id (order id)
     * 
     * @return Json
     * 
     */
    public function printCompletedorder($id)
    {
        $orderData = Order::where('payed', 1)->whereHas('tableOrder', function($q) use($id){
            $q->where('order_id', $id);
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
     * Filteration complete order data for search and date (filter)
     *
     * @param Request $request
     * @param daterange $request->daterange (ex. 2022-09-01 - 2022-09-15)
     * @param search $request->search
     * 
     * @return [type]
     * 
     */
    public function filterCompleteOrder(Request $request)
    {
        $datarange = $request->daterange;
        $datetoarray = explode(' - ', $datarange);
        $from = date($datetoarray[0]);
        $to = date($datetoarray[1]);
        $search = $request->search;


        $completed_orders = Order::withCount('orderProduct')->with('tableOrder')->with('tableOrder.customer');
        
        if($search){
            $completed_orders = $completed_orders->whereHas('tableOrder', function($query) use ($search) {
                $query->where('order_id','LIKE', '%'.$search.'%')->orWhereHas('customer', function($query2) use ($search) {
                    $query2->where('name','LIKE', '%'.$search.'%')->orWhere('email','LIKE', '%'.$search.'%');
                });
            });
        }

        $completed_orders = $completed_orders->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->where('ordered', 1)->where('payed', 1)->orderBy('id', 'desc')->get();
                
        foreach($completed_orders as $completed_order){
            $date = $completed_order->created_at;
            $completed_order->create = $date->format('F d,Y \A\t h:i A');
        }

        return response()->json(['completed_orders' => $completed_orders]);

    }

    /**
     * Complete Order Invoice send customer through email.
     *
     * @param Request $request
     * @param id $request->id
     * 
     * @return [type]
     * 
     */
    public function emailInvoice(Request $request)
    {
        $id = $request->id;
        $orderData = Order::where('payed', 1)->whereHas('tableOrder', function($q) use($id){
            $q->where('order_id', $id);
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


        $setting = Setting::pluck('value','type');

        $data = array('setting'=>$setting, 'printData'=>$printData, 'printOrdersData'=>$printOrdersData);

        $email = $order->tableOrder->customer->email;
        if($email){
            Mail::send('mail-invoice', $data, function($message) use($email){
                $message->to($email, 'Invoice')->subject
                   ('Mail Invoice');
                $message->from('test@gmail.com','Invoice');
             });
        }
        return view('mail-invoice', compact('setting','printData','printOrdersData'));
    }
}
