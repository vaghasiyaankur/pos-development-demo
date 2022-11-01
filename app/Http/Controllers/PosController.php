<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Combo;
use App\Models\IngredientCategory;
use App\Models\Ingredient;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\TableOrder;
use App\Models\Table;
use App\Models\OrderProductIngredient;
use App\Models\ProductIngredient;
use App\Models\ProductSize;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Cookie;
use Session;
use Auth;
use Laravel\Ui\Presets\React;

class PosController extends Controller
{
    /**
     * Get Category featured List
     *
     * @return Json
     *
     */
    public function getcategoryfeturedlist()
    {
        $categories = Category::where('status', 1)->withCount('activeproducts')->get();
        $products = Product::where('status', 1)->withCount('productIngredients')->withCount('productSize')->get();
        $total = Product::where('status', 1)->count();
        foreach ($categories as $category) {
            if (file_exists('storage/'.$category->image)) {
                $category['image_show'] = true;
            }else{
                $category['image_show'] = false;
            }
        }
        return response()->json(['categories' => $categories, 'products' => $products, 'total' => $total]);
    }

    /**
     * Get Product List
     *
     * @return Json
     *
     */
    public function getproductslist(Request $request)
    {
        if($request->id == 0){
            $products = Product::whereNotNull('category_id')->withCount('productIngredients')->withCount('productSize');
        }else{
            $products = Product::where('category_id', $request->id)->withCount('productIngredients')->withCount('productSize');
        }

        if ($request->combo) {
            $products = new Combo;
        }

        if ($request->ingredient) {
            $products = Ingredient::whereHas('ingCategory', function($q){
                $q->where('name', '!=', 'size');
            });
        }

        if($request->veg){
            $products = $products->where('food_type', 1);
        }

        $products = $products->where('status', 1)->get();

        return response()->json(['products' => $products]);
    }

    /**
     * Get Product Data For Pos Page
     *
     * @return Json
     *
     */
    public function getProductPosData(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        $ingredient = ProductIngredient::where('product_id', $product->id)->pluck('ingredient_id');
        $ingredientCategories = IngredientCategory::where('name', '!=', 'size')->where('status', 1)
        ->whereHas('activeingredients.productIngredients', function($q) use ($product){
            $q->where('product_id', $product->id);
        })
        ->with(['activeingredients'=> function($q) use ($ingredient){
            $q->whereIn('id', $ingredient);
        }])
        ->get();
        $sizes = ProductSize::with('size')->where('product_id', $product->id)->get();
        return response()->json(['product' => $product, 'ingredientCategories' => $ingredientCategories, 'sizes' => $sizes]);
    }

    /**
     * Add Product in Cart
     *
     * @return Json
     *
     */
    public function addtocart(Request $request)
    {
        $stores = session()->get('demoCartData');

        $productId = $request->productId;
        $Quantity = $request->Quantity;
        $sizeId = $request->sizeId;
        $ingArray = $request->ingArray;
        $combo = $request->combo;
        $ingre = $request->ingredient;
        if($stores){
            foreach($stores as $key=>$store){
                if($productId == $store['product'] && $sizeId == $store['size'] && $ingArray == $store['ingredient']){
                    $stores[$key]['quantity'] = $store['quantity'] + 1;
                    session()->put('demoCartData', $stores);
                    return 1;
                }
            }
        }
        $demoCartData = ['product' => $productId, 'quantity' => $Quantity, 'size' => $sizeId, 'ingredient' => $ingArray, 'combo' => $combo,'ingre'=>$ingre];
        session()->push('demoCartData', $demoCartData);
        return 1;

    }

    /**
     * Get Cart Detail
     *
     * @return Json
     *
     */
    public function getCart(Request $request)
    {
        // $stores = session()->forget('demoOrderData');
        $stores = session()->get('demoCartData');
        $cartData = [];
        $total = 0;
        if($stores){
            foreach($stores as $key=>$data){
                if($data['combo'] == "true"){
                    $product = Combo::where('id' , $data['product'])->first();
                    $price = $product->price;
                }else if($data['ingre'] == "true"){
                    $product = Ingredient::where('id' , $data['product'])->first();
                    $price = $product->price;
                }else{
                    $product = Product::where('id' , $data['product'])->first();
                    $ingredientId = explode(',', $data['ingredient']);
                    $ingredient = Ingredient::whereIn('id', $ingredientId)->get();
                    $size = ProductSize::with('size')->where('size_id', $data['size'])->first();
                    $ingredientString = '';
                    $price = $product->price;
                    foreach($ingredient as $ing){
                        $price += $ing->price;
                        $ingredientString .= $ing->name.', ';
                    }

                    $cartData[$key]['ingredient'] = substr($ingredientString, 0, -2);
                    $cartData[$key]['size'] = @$size->size->name;
                    $price += @$size->price;
                }
                $quantity = $data['quantity'];
                $price = $price * $quantity;
                $cartData[$key]['product'] = $product;
                $cartData[$key]['quantity'] = $quantity;
                $cartData[$key]['price'] = $price;
                $total += $price;
            }
        }
        return response()->json(['cart' => $cartData, 'total' => $total]);
    }

    /**
     * Remove Cart Detail
     *
     * @return Json
     *
     */
    public function removeCart(Request $request)
    {
        $stores = session()->get('demoCartData');
        unset($stores[$request->index]);
        session()->put('demoCartData', $stores);
        return 'success';
    }

    /**
     * Cart Product Quantity Update
     *
     * @return Json
     *
     */
    public function changeCartQuantity(Request $request)
    {
        // dd($request->all());
        $stores = session()->get('demoCartData');
        if($request->action == 'plus'){
            $newValue = $stores[$request->index]['quantity'] + 1;
            $stores[$request->index]['quantity'] = $newValue;
        }

        if($request->action == 'minus'){
            $newValue = $stores[$request->index]['quantity'] - 1;
            if($newValue > 0){
                $stores[$request->index]['quantity'] = $newValue;
            }else{
                unset($stores[$request->index]);
            }
        }
        session()->put('demoCartData', $stores);
        return 'success';

    }

    /**
     * Cart To Order Save
     *
     * @return Json
     *
     */
    public function saveOrder(Request $request)
    {
            // session()->forget('demoOrderData');
            // session()->forget('demoCartData');
            // return 21;
        // dd(session()->get('demoCartData'));
        $cartProduct = session()->get('demoCartData');
        $cartData = [];
        $total = 0;
        $purchaseType = $request->purchase;
        $description = $request->description;


        foreach($cartProduct as $key=>$data){
            if($data['combo'] == "true"){
                $product = Combo::where('id' , $data['product'])->first();
                $price = $product->price;
            }else if($data['ingre'] == "true"){
                $product = Ingredient::where('id' , $data['product'])->first();
                $price = $product->price;
            }else{
                $product = Product::where('id' , $data['product'])->first();
                $ingredientId = explode(',', $data['ingredient']);
                $ingredients = Ingredient::whereIn('id', $ingredientId)->get();
                $size = ProductSize::with('size')->where('size_id', $data['size'])->first();
                $price = $product->price;
                $ingredientString = '';
                foreach($ingredients as $ing){
                    if($ing){
                        $price += $ing->price;
                        $ingredientString .= $ing->name.', ';
                    }
                }
                $cartData[$key]['size'] = @$size->size->name;
                $price += @$size->price;
            }
            $quantity = $data['quantity'];
            $price = $price * $quantity;
            $cartData[$key]['price'] = $price;
            $total += $price;
        }


        // $stores = session()->get('demoCartData');
        // session()->put('demoCartData', $stores);


        $stores = session()->get('demoOrderData');

        $table = Table::where('number',$request->orderTable)->first();
        $fullOrder = [];
        $demoOrderData = ['pay_amount' => $total, 'total_amount' => $total, 'purchase_type' => $purchaseType, 'description' => $description];
        // dd($cartProduct);
        $orderproduct = [];
        foreach($cartProduct as $key=>$data){
            $ingredients = explode(',', $data['ingredient']);
            $orderproducting = [];
            foreach($ingredients as $ik => $ingredient){
                if($ingredient){
                   $orderproducting[$ik] = $ingredient;
                }
            }


                if($data['combo'] == "true"){
                    $orderproduct[$key]['combo_id'] = $data['product'];
                }else if($data['ingre'] == "true"){
                    $orderproduct[$key]['ingredient_id'] = $data['product'];
                }else{
                    $orderproduct[$key]['product_id'] = $data['product'];
                }
                $orderproduct[$key]['amount'] = $cartData[$key]['price'];
                $orderproduct[$key]['quantity'] = $data['quantity'];
                $orderproduct[$key]['orderproductingredient'] = $orderproducting;

            }
        $demoOrderData['order_product'] = $orderproduct;
        $demoOrderData['created_at'] = \Carbon\Carbon::now();
        $rand = rand(10,1000);
        $loop = 0;
        if($stores){
            foreach($stores as $key => $store){
                if($store['table'] == $table->id){
                    if(array_key_exists($rand,$store)){
                        $rand = rand(1000,2000);
                        if(array_key_exists($rand,$store)){
                            $rand = rand(2000,3000);
                        }
                    }

                    $store[$rand] = $demoOrderData;
                    $fullOrder[$key] = $store;
                    $loop = 1;
                }else{
                    $fullOrder[$key] = $store;
                }
            }
            if(!$loop){
                $count = count($stores);
                $fullOrder[$count]['table'] = $table->id;
                $fullOrder[$count]['customer_name'] = $request->customerName;
                $fullOrder[$count]['customer_number'] = $request->contactNumber;
                $fullOrder[$count]['customer_email'] = $request->customerEmail;
                $fullOrder[$count]['ordered'] = 0;
                $fullOrder[$count][$rand] = $demoOrderData;
            }

        }else{
            $fullOrder[0]['table'] = $table->id;
            $fullOrder[0]['customer_name'] = $request->customerName;
            $fullOrder[0]['customer_number'] = $request->contactNumber;
            $fullOrder[0]['customer_email'] = $request->customerEmail;
            $fullOrder[0]['ordered'] = 0;
            $fullOrder[0][$rand] = $demoOrderData;
        }
        session()->forget('demoOrderData');
        session()->put('demoOrderData', $fullOrder);
        // dd($stores);
        // if($stores){
        //     foreach($stores as $k => $store){
        //         foreach($store as $tid=>$orders){
        //             if($table->id == $tid){
        //                 $fullOrder[$k][$tid][$rand] = $demoOrderData;
        //                 $loop = 1;

        //     dd($fullOrder);
        //                 session()->push('demoOrderData', $fullOrder[$k]);
        //             }
        //         }
        //     }
        // }
        // if($loop == 0){
        //     $fullOrder[$table->id][$rand] = $demoOrderData;
        //     dd($fullOrder);
        //     session()->push('demoOrderData', $fullOrder);
        // }
        session()->forget('demoCartData');
        // session()->forget('demoOrderData');
        // dd(session()->get('demoOrderData'));
        return 'success';



        // $order = new Order();
        // $order->pay_amount = $total;
        // $order->total_amount = $total;
        // $order->purchase_type = $purchaseType;
        // $order->description = $description;
        // $order->user_id = Auth::user()->id;
        // $order->save();

        // foreach($cartProduct as $key=>$data){
        //     $ingredients = explode(',', $data['ingredient']);
        //     $orderproduct = new OrderProduct();
        //     $orderproduct->order_id = $order->id;
        //     if($data['combo'] == "true"){
        //         $orderproduct->combo_id = $data['product'];
        //     }else if($data['ingre'] == "true"){
        //         $orderproduct->ingredient_id = $data['product'];
        //     }else{
        //         $orderproduct->product_id = $data['product'];
        //     }
        //     $orderproduct->amount = $cartData[$key]['price'];
        //     $orderproduct->quantity = $data['quantity'];
        //     $orderproduct->save();

        //     foreach($ingredients as $ingredient){
        //         if($ingredient){
        //             $ing = new OrderProductIngredient();
        //             $ing->order_product_id = $orderproduct->id;
        //             $ing->ingredient_id = $ingredient;
        //             $ing->save();
        //         }
        //     }
        // }

        // $table = Table::where('number',$request->orderTable)->orderByRaw('RAND()')->first();

        // $table->current = 'Running';
        // $table->save();

        // $customer = Customer::updateOrCreate([
        //     'phone'   => $request->contactNumber,
        // ],[
        //     'email'     => $request->get('customerEmail'),
        //     'name'     => $request->get('customerName'),
        // ]);

        // $tableorder = new TableOrder();
        // $tableorder->order_id = $order->id;
        // $tableorder->table_id = $table->id;
        // $tableorder->customer_id = $customer->id;
        // $tableorder->save();

        // session()->forget('demoCartData');
        // return 'success';
    }
    

    /**
     * Next Avilable Table Check For Reservation
     *
     * @return Json
     *
     */
    public function getavaliableTable()
    {
        $table = Table::where('current','!=','Deactive')->pluck('number');
        return response()->json(['table' => $table]);
    }

    /**
     * Available customer on order going project or not..
     *
     * @param Request $request
     * @param TableNumber $request->table
     *
     * @return Json
     *
     */
    public function checkCustomerOnGoingOrder(Request $request)
    {
        $tableorder = TableOrder::where('table_id', $request->table)->with('customer')->orderBy('id', 'desc')->whereHas('orders', function($q){
            $q->where('payed', 0);
        })->first();
        if($tableorder){
            return response()->json(['getDetail' => 1, 'tableorder' => $tableorder]);
        }else{
            return response()->json(['getDetail' => 0]);
        }
    }

    /**
     * Customer Detail Find Using Contact Number
     *
     * @param Request $request
     * @param ContactNumber $request->phone
     *
     * @return Json
     *
     */
    public function findCustomerThroughNumber(Request $request)
    {
        $customer = Customer::where('phone', $request->phone)->orderBy('id', 'desc')->first();
        if($customer){
            return response()->json(['getDetail' => 1, 'customer' => $customer]);
        }else{
            return response()->json(['getDetail' => 0]);
        }
    }

}
