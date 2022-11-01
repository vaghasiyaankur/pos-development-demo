<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use App\Models\Tax;
use App\Models\Product;
use App\Models\Ingredient;
use App\Models\Combo;
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
        $completeOrderData = session()->get('demoCompleteOrderData');
        $completed_orders = [];
        // dd('1');
        // dd($completeOrderData);
        if($completeOrderData){
            foreach($completeOrderData as $k=>$completeOrder){
                foreach($completeOrder as $key=>$corder){
                    if($key != 'table' && $key != 'customer_name' && $key != 'customer_number' && $key != 'customer_email' && $key != 'ordered'){
                        $tableOrder = [];
                        $tableOrder['customer']['email'] = $completeOrder['customer_email'];
                        $tableOrder['customer']['name'] = $completeOrder['customer_name'];
                        $tableOrder['customer']['phone'] = $completeOrder['customer_number'];
                        $date = $corder['created_at'];
                        $d = $date->format('F d,Y \A\t h:i A');
                        $completed_orders[$k.'-'.$key]['create'] = $d;
                        $completed_orders[$k.'-'.$key]['created_at'] = $corder['created_at'];
                        $completed_orders[$k.'-'.$key]['id'] = $k.'-'.$key;
                        $completed_orders[$k.'-'.$key]['order_product_count'] = count($corder['order_product']);
                        $completed_orders[$k.'-'.$key]['ordered'] = 1;
                        $completed_orders[$k.'-'.$key]['pay_amount'] = $corder['pay_amount'];
                        $completed_orders[$k.'-'.$key]['payed'] = 1;
                        $completed_orders[$k.'-'.$key]['purchase_type'] = $corder['purchase_type'];
                        $completed_orders[$k.'-'.$key]['total_amount'] = $corder['total_amount'];
                        $completed_orders[$k.'-'.$key]['updated_at'] = $corder['created_at'];
                        $completed_orders[$k.'-'.$key]['user_id'] = 1;
                        $completed_orders[$k.'-'.$key]['table_order'] = $tableOrder;
                    }
                }
            }
        }

        $firstArray = array_key_first($completed_orders);
        return response()->json(['completed_orders' => $completed_orders, 'first_array' => $firstArray]);
    }

    /**
     * Get Ordered Product Data 
     *
     * @param Request $request
     * 
     * @return Json
     * 
     */
    public function getOrderProduct($orderId)
    {
        $completeOrderData = session()->get('demoCompleteOrderData');
        $products = [];
        if($orderId == 1){
            foreach($completeOrderData as $k=>$completeOrder){
                foreach($completeOrder as $key=>$corder){
                    if($key != 'table' && $key != 'customer_name' && $key != 'customer_number' && $key != 'customer_email' && $key != 'ordered'){
                        // dd($corder);
                        foreach($corder['order_product'] as $op){
                            if(array_key_exists('product_id',$op)){
                                $product = Product::where('id', $op['product_id'])->first();
                                $data[$product->name.'-'.$product->id]['image'] = $product->image;
                                $data[$product->name.'-'.$product->id]['quantity'] = $op['quantity'];
                                $data[$product->name.'-'.$product->id]['name'] = $product->name;
                                $data[$product->name.'-'.$product->id]['price'] = $op['amount'];
                                $data[$product->name.'-'.$product->id]['total_price'] = $op['amount'];
                            }else if(array_key_exists('combo_id',$op)){
                                $combo = Combo::where('id', $op['combo_id'])->first();
                                $data[$combo->name.'-'.$combo->id]['image'] = $combo->image;
                                $data[$combo->name.'-'.$combo->id]['quantity'] = $op['quantity'];
                                $data[$combo->name.'-'.$combo->id]['name'] = $combo->name;
                                $data[$combo->name.'-'.$combo->id]['price'] = $op['amount'];
                                $data[$combo->name.'-'.$combo->id]['total_price'] = $op['amount'];
                            }else if(array_key_exists('ingredient_id',$op)){
                                $ingredient = Ingredient::where('id', $op['ingredient_id'])->first();
                                $data[$ingredient->name.'-'.$ingredient->id]['image'] = $ingredient->image;
                                $data[$ingredient->name.'-'.$ingredient->id]['quantity'] = $op['quantity'];
                                $data[$ingredient->name.'-'.$ingredient->id]['name'] = $ingredient->name;
                                $data[$ingredient->name.'-'.$ingredient->id]['price'] = $op['amount'];
                                $data[$ingredient->name.'-'.$ingredient->id]['total_price'] = $op['amount'];
                            }
                        }
                        $products['customer_email'] = $completeOrder['customer_email'];
                        $products['customer_name'] = $completeOrder['customer_name'];
                        $products['id'] = $k.'-'.$key;
                        $products['pay_amount'] = $corder['pay_amount'];
                        $products['total_amount'] = $corder['total_amount'];
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

                        break 2;
                    }
                }
            }
        }else{
            $explodeData = explode('-',$orderId);
            $ky = $explodeData[0];
            $order_id = $explodeData[1];

            foreach($completeOrderData[$ky] as $key=>$corder){
                if($key != 'table' && $key != 'customer_name' && $key != 'customer_number' && $key != 'customer_email' && $key != 'ordered' && $key == $order_id){
                    foreach($corder['order_product'] as $op){
                        if(array_key_exists('product_id',$op)){
                            $product = Product::where('id', $op['product_id'])->first();
                            $data[$product->name.'-'.$product->id]['image'] = $product->image;
                            $data[$product->name.'-'.$product->id]['quantity'] = $op['quantity'];
                            $data[$product->name.'-'.$product->id]['name'] = $product->name;
                            $data[$product->name.'-'.$product->id]['price'] = $op['amount'];
                            $data[$product->name.'-'.$product->id]['total_price'] = $op['amount'];
                        }else if(array_key_exists('combo_id',$op)){
                            $combo = Combo::where('id', $op['combo_id'])->first();
                            $data[$combo->name.'-'.$combo->id]['image'] = $combo->image;
                            $data[$combo->name.'-'.$combo->id]['quantity'] = $op['quantity'];
                            $data[$combo->name.'-'.$combo->id]['name'] = $combo->name;
                            $data[$combo->name.'-'.$combo->id]['price'] = $op['amount'];
                            $data[$combo->name.'-'.$combo->id]['total_price'] = $op['amount'];
                        }else if(array_key_exists('ingredient_id',$op)){
                            $ingredient = Ingredient::where('id', $op['ingredient_id'])->first();
                            $data[$ingredient->name.'-'.$ingredient->id]['image'] = $ingredient->image;
                            $data[$ingredient->name.'-'.$ingredient->id]['quantity'] = $op['quantity'];
                            $data[$ingredient->name.'-'.$ingredient->id]['name'] = $ingredient->name;
                            $data[$ingredient->name.'-'.$ingredient->id]['price'] = $op['amount'];
                            $data[$ingredient->name.'-'.$ingredient->id]['total_price'] = $op['amount'];
                        }
                    }
                    $products['customer_email'] =$completeOrderData[$ky]['customer_email'];
                    $products['customer_name'] =$completeOrderData[$ky]['customer_name'];
                    $products['id'] = $ky.'-'.$key;
                    $products['pay_amount'] = $corder['pay_amount'];
                    $products['total_amount'] = $corder['total_amount'];
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

                    break 1;
                }
            }
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
        $explodeData = explode('-',$id);
        $ky = $explodeData[0];
        $order_id = $explodeData[1];

        $printData = [];
        $printData['sub_total'] = 0;
        $printData['pay_total'] = 0;
        $printOrdersData = [];


        $orderData = session()->get('demoCompleteOrderData');
        $printorder = [];
        // dd($orderData);
        $printorder = $orderData[$ky];

        $printOrdersData = [];
        foreach($printorder as $key=>$order){
            if($key != 'table' && $key != 'customer_name' && $key != 'customer_number' && $key != 'customer_email' && $key != 'ordered' && $key == $order_id){
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
        // $orderData = Order::where('payed', 1)->whereHas('tableOrder', function($q) use($id){
        //     $q->where('order_id', $id);
        // })->get();
        // $orders = [];
        // $printData['sub_total'] = 0;
        // $printData['pay_total'] = 0;
        // foreach($orderData as $order){
        //     $data = [];
        //     $orderProData = $order->orderProduct;
        //         foreach($orderProData as $orderPro){
        //             if($orderPro->product){
        //                 $printOrdersData[$order->id.'-'.$orderPro->product->id.'-product']['quantity'] = $orderPro->quantity;
        //                 $printOrdersData[$order->id.'-'.$orderPro->product->id.'-product']['name'] = $orderPro->product->name;
        //                 $printOrdersData[$order->id.'-'.$orderPro->product->id.'-product']['price'] = $orderPro->amount;
        //             }
        //             if($orderPro->combo){
        //                 $printOrdersData[$order->id.'-'.$orderPro->combo->id.'-combo']['quantity'] = $orderPro->quantity;
        //                 $printOrdersData[$order->id.'-'.$orderPro->combo->id.'-combo']['name'] = $orderPro->combo->name;
        //                 $printOrdersData[$order->id.'-'.$orderPro->combo->id.'-combo']['price'] = $orderPro->amount;
        //             }
        //             if($orderPro->ingredient){
        //                 $printOrdersData[$order->id.'-'.$orderPro->ingredient->id.'-ingredient']['quantity'] = $orderPro->quantity;
        //                 $printOrdersData[$order->id.'-'.$orderPro->ingredient->id.'-ingredient']['name'] = $orderPro->ingredient->name;
        //                 $printOrdersData[$order->id.'-'.$orderPro->ingredient->id.'-ingredient']['price'] = $orderPro->amount;
        //             }

        //         }
        //         $printData['sub_total'] += $order->pay_amount;
        //         $printData['pay_total'] += $order->pay_amount;
        // }
        // $allTax = Tax::where('status', 1)->get();
        // $taxes = [];
        // foreach($allTax as $tax){
        //     if($tax->tax_type == 'percentage'){
        //         $taxValue = ($printData['sub_total'] * $tax->tax_value) / 100;
        //         $taxes[$tax->id]['name'] = $tax->name;
        //         $taxes[$tax->id]['value'] = $taxValue;
        //         $printData['pay_total'] += $taxValue;
        //     }else{
        //         $taxes[$tax->id]['name'] = $tax->name;
        //         $taxes[$tax->id]['value'] = $tax->tax_value;
        //         $printData['pay_total'] += $tax->tax_value;
        //     }
        // }

        // $printData['taxes'] = $taxes;
        // $setting = Setting::pluck('value','type');
        // if($orderData[0]->purchase_type == 'dinein') $type='Dine In';
        // elseif($orderData[0]->purchase_type == 'takeaway') $type='Take Away';
        // elseif($orderData[0]->purchase_type == 'delivery') $type='Delivery';

        // date_default_timezone_set($setting['time_zone']);
        // $Date = date('m-d-Y', time());
        // $Time = date('H:i', time());
        // $printData['current_date'] = $Date;
        // $printData['current_time'] = $Time;
        // $printData['purchase_type'] = $type;
        // $printData['table'] = $orderData[0]->tableOrder->table->number;
        // $printData['customer_name'] = $order->tableOrder->customer->name;
        // $printData['footer'] = $setting['print_bill_footer'];
        // $printData['logo'] = $setting['logo'];
        // return response()->json(['printData' => $printData, 'printOrdersData' => $printOrdersData]);
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
        $completeOrderData = session()->get('demoCompleteOrderData');
        // dd($completeOrderData);
        $datarange = $request->daterange;
        $datetoarray = explode(' - ', $datarange);
        $from = date('Y-m-d', strtotime("-1 day", strtotime($datetoarray[0])));;
        $to = date('Y-m-d', strtotime("+1 day", strtotime($datetoarray[1])));

        $completed_orders = [];
        // dd('1');
        // dd($completeOrderData);
        foreach($completeOrderData as $k=>$completeOrder){
            foreach($completeOrder as $key=>$corder){
                if($key != 'table' && $key != 'customer_name' && $key != 'customer_number' && $key != 'customer_email' && $key != 'ordered'){
                    if($corder['created_at'] >= $from && $corder['created_at'] <= $to){
                        if($request->search){
                            if(str_contains($completeOrder['customer_email'], $request->search) || str_contains($key, $request->search)){
                                $tableOrder = [];
                                $tableOrder['customer']['email'] = $completeOrder['customer_email'];
                                $tableOrder['customer']['name'] = $completeOrder['customer_name'];
                                $tableOrder['customer']['phone'] = $completeOrder['customer_number'];
                                $date = $corder['created_at'];
                                $d = $date->format('F d,Y \A\t h:i A');
                                $completed_orders[$k.'-'.$key]['create'] = $d;
                                $completed_orders[$k.'-'.$key]['created_at'] = $corder['created_at'];
                                $completed_orders[$k.'-'.$key]['id'] = $k.'-'.$key;
                                $completed_orders[$k.'-'.$key]['order_product_count'] = count($corder['order_product']);
                                $completed_orders[$k.'-'.$key]['ordered'] = 1;
                                $completed_orders[$k.'-'.$key]['pay_amount'] = $corder['pay_amount'];
                                $completed_orders[$k.'-'.$key]['payed'] = 1;
                                $completed_orders[$k.'-'.$key]['purchase_type'] = $corder['purchase_type'];
                                $completed_orders[$k.'-'.$key]['total_amount'] = $corder['total_amount'];
                                $completed_orders[$k.'-'.$key]['updated_at'] = $corder['created_at'];
                                $completed_orders[$k.'-'.$key]['user_id'] = 1;
                                $completed_orders[$k.'-'.$key]['table_order'] = $tableOrder;
                            }
                        }else{
                            $tableOrder = [];
                            $tableOrder['customer']['email'] = $completeOrder['customer_email'];
                            $tableOrder['customer']['name'] = $completeOrder['customer_name'];
                            $tableOrder['customer']['phone'] = $completeOrder['customer_number'];
                            $date = $corder['created_at'];
                            $d = $date->format('F d,Y \A\t h:i A');
                            $completed_orders[$k.'-'.$key]['create'] = $d;
                            $completed_orders[$k.'-'.$key]['created_at'] = $corder['created_at'];
                            $completed_orders[$k.'-'.$key]['id'] = $k.'-'.$key;
                            $completed_orders[$k.'-'.$key]['order_product_count'] = count($corder['order_product']);
                            $completed_orders[$k.'-'.$key]['ordered'] = 1;
                            $completed_orders[$k.'-'.$key]['pay_amount'] = $corder['pay_amount'];
                            $completed_orders[$k.'-'.$key]['payed'] = 1;
                            $completed_orders[$k.'-'.$key]['purchase_type'] = $corder['purchase_type'];
                            $completed_orders[$k.'-'.$key]['total_amount'] = $corder['total_amount'];
                            $completed_orders[$k.'-'.$key]['updated_at'] = $corder['created_at'];
                            $completed_orders[$k.'-'.$key]['user_id'] = 1;
                            $completed_orders[$k.'-'.$key]['table_order'] = $tableOrder;
                        }
                    }
                }
            }
        }

        $firstArray = array_key_first($completed_orders);

        // dd($completed_orders);
        // $datarange = $request->daterange;
        // $datetoarray = explode(' - ', $datarange);
        // $from = date($datetoarray[0]);
        // $to = date($datetoarray[1]);
        // $search = $request->search;


        // $completed_orders = Order::withCount('orderProduct')->with('tableOrder')->with('tableOrder.customer');
        
        // if($search){
        //     $completed_orders = $completed_orders->whereHas('tableOrder', function($query) use ($search) {
        //         $query->where('order_id','LIKE', '%'.$search.'%')->orWhereHas('customer', function($query2) use ($search) {
        //             $query2->where('name','LIKE', '%'.$search.'%')->orWhere('email','LIKE', '%'.$search.'%');
        //         });
        //     });
        // }

        // $completed_orders = $completed_orders->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->where('ordered', 1)->where('payed', 1)->orderBy('id', 'desc')->get();
                
        // foreach($completed_orders as $completed_order){
        //     $date = $completed_order->created_at;
        //     $completed_order->create = $date->format('F d,Y \A\t h:i A');
        // }

        return response()->json(['completed_orders' => $completed_orders, 'first_array' => $firstArray]);

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
