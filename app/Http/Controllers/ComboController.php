<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Combo;
use App\Models\Product;
use App\Models\ComboProduct;
use Illuminate\Support\Facades\Validator;
use File;
class ComboController extends Controller
{
    /**
     * Get Product List
     *
     * @param Request $request
     * 
     * @return Json
     * 
     */
    public function getproductlist()
    {
        $products = Product::where('status', 1)->get();

        return response()->json(['products' => $products]);
    }

    /**
     * Get Combo List
     *
     * @param Request $request
     * 
     * @return Json
     * 
     */
    public function getcombolist()
    {
        $combos = Combo::withCount('comboProducts')->orderBy('status', 'desc')->get();
        foreach($combos as $combo){
            $date = $combo->created_at;
            $combo->create = $date->format('g:i A');
        }
        return response()->json(['combo' => $combos]);
    }

    /**
     * Add Combo Data In Database
     *
     * @param Request $request
     * 
     * @return Json
     * 
     */
    public function addcombo(Request $request)
    {
        $combocontent = $request->only('name','image', 'price','products','foodType','status');
        $products = explode(",",$request->products);

        $validator = Validator::make($combocontent, [
            'name' => 'required',
            'price' => 'required',
            'products' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

        $file = $request->file('image');
        $image_name = 'combo/'.rand(100000,999999).".".$file->GetClientOriginalExtension();
        $file->move(public_path('storage/combo/'),$image_name);

        $combo = new Combo();
        $combo->name = $request->name;
        $combo->price = $request->price;
        $combo->image = $image_name ? $image_name : $request->image;
        $combo->food_type = $request->foodType;
        $combo->status = $request->status;
        $combo->save();

        if($products){
            foreach ($products as $product) {
                $product_combo = new ComboProduct();
                $product_combo->combo_id = $combo->id;
                $product_combo->product_id = $product;
                $product_combo->save();
            }
        }

        return response()->json(['success' => 'combo added sucecessfully'], 200);

    }

    /**
     * Search Product Data In Database
     *
     * @param Request $request
     * 
     * @return Json
     * 
     */
    public function search_product(Request $request)
    {
        $products = Product::where('name','LIKE','%'.$request->product.'%')->get();

        return response()->json(['products' => $products]);
    }

    /**
     * Get Single Combo Data In Database
     *
     * @param Request $request
     * 
     * @return Json
     * 
     */
    public function getSingleCombo(Request $request)
    {
        $combo = Combo::with('comboProducts.product')->where('slug', $request->slug)->first();
        return response()->json(['combo' => $combo], 200);
    }

    /**
     * Edit Combo Data In Database
     *
     * @param Request $request
     * 
     * @return Json
     * 
     */
    public function editCombo(Request $request)
    {
        $combocontent = $request->only('id','name','image', 'price','products','foodType','status');
        $products = explode(",",$request->products);

        $validator = Validator::make($combocontent, [
            'name' => 'required',
            'price' => 'required',
            'products' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

        $combo = Combo::where('id', $request->id)->first();
        $image_name = $combo->image;
        if($request->file('image'))
    	{
            $validatorimage = Validator::make($combocontent, [
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                ]
            );

            if ($validatorimage->fails()) {
                return response()->json(['error' => $validatorimage->messages()], 401);
            }

            $file = $request->file('image');
            $image_name = 'combo/'.rand(100000,999999).".".$file->GetClientOriginalExtension();
            $file->move(public_path('storage/combo/'),$image_name);


            $path = public_path()."/storage/$product->image";
            $result = File::exists($path);

            if($result)
            {
                File::delete($path);
            }

        }

        $combo->name = $request->name;
        $combo->price = $request->price;
        $combo->image = $image_name;
        $combo->food_type = $request->foodType;
        $combo->status = $request->status;
        $combo->save();

        ComboProduct::where('combo_id',$combo->id)->delete();

        if($products){
            foreach ($products as $product) {
                $product_combo = new ComboProduct();
                $product_combo->combo_id = $combo->id;
                $product_combo->product_id = $product;
                $product_combo->save();
            }
        }

        return response()->json(['success' => 'combo updated sucecessfully'], 200);
    }

    /**
     * Remove Combo Data In Database
     *
     * @param Request $request
     * 
     * @return Json
     * 
     */
    public function removeCombo(Request $request)
    {
        $combo = Combo::find($request->id);
        $path = public_path()."/storage/$combo->image";
        $combo->delete();
        $result = File::exists($path);

        if($result)
        {
            File::delete($path);
        }

        return response()->json(['success' => 'Combo removed successfully']);
    }
}
