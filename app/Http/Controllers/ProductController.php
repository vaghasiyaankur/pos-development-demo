<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Ingredient;
use App\Models\ProductIngredient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get Product List
     *
     * @return Json
     * 
     */
    public function getproductlist(Request $request)
    {
        $slug = $request->slug;
        $products = new Product;
        $category = null;
        if ($slug) {
            $category = Category::where('slug', $slug)->first();
            $products = $products->where('category_id', $category->id);
        }
        $products = $products->orderBy('status', 'desc')->get();


        return response()->json(['category' => $category, 'products' => $products]);
    }

    /**
     * Add Product In Database
     *
     * @return Json
     * 
     */
    public function addproduct(Request $request)
    {
        $productcontent = $request->only('category_slug', 'name', 'id','image', 'price','categoryId','ingredient','status','description','foodType','sizes');
        $ingredients = explode(",",$request->ingredient);
        $validator = Validator::make($productcontent, [
            'name' => 'required',
            'price' => 'required',
            'categoryId' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

        $file = $request->file('image');
        $image_name = 'product/'.rand(100000,999999).".".$file->GetClientOriginalExtension();
        $file->move(public_path('storage/product/'),$image_name);


        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->image = $image_name ? $image_name : $request->image;
        $product->category_id = $request->categoryId;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->food_type = $request->foodType;
        $product->save();
        if($ingredients){
            foreach ($ingredients as $ing) {
                if($ing){
                    $product_ing = new ProductIngredient();
                    $product_ing->product_id = $product->id;
                    $product_ing->ingredient_id = $ing;
                    $product_ing->save();
                }
            }
        }

        foreach($request->sizes as $k=>$s){
            $product_size = new ProductSize();
            $product_size->size_id = $k;
            $product_size->product_id = $product->id;
            $product_size->price = $s;
            $product_size->save();
        }

        $category = Category::where('id',$request->categoryId)->first('slug');

        return response()->json(['success' => 'product added sucecessfully','category'=>$category], 200);

    }

    /**
     * Edit Product In Database
     *
     * @return Json
     * 
     */
    public function editproduct(Request $request)
    {
        $productcontent = $request->only('category_slug', 'name', 'id','image', 'price','categoryId','ingredient','status','description','foodType','sizes');
        $ingredients = explode(",",$request->ingredient);

        $validator = Validator::make($productcontent, [
            'name' => 'required',
            'price' => 'required',
            'categoryId' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

        $product = Product::where('id', $request->id)->first();
        $image_name = $product->image;
        if($request->file('image'))
    	{
            $validatorimage = Validator::make($productcontent, [
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                ]
            );

            if ($validatorimage->fails()) {
                return response()->json(['error' => $validatorimage->messages()], 401);
            }


            $file = $request->file('image');
            $image_name = 'product/'.rand(100000,999999).".".$file->GetClientOriginalExtension();
            $file->move(public_path('storage/product/'),$image_name);


        $path = public_path()."/storage/$product->image";
        $result = File::exists($path);

        if($result)
        {
            File::delete($path);
        }

        }

        $product->name = $request->name;
        $product->image = $image_name;
        $product->category_id = $request->categoryId;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->food_type = $request->foodType;
        $product->save();
        foreach($request->sizes as $k=>$s){
            if($k != 0){
                $checksize = ProductSize::where('size_id', $k)->where('product_id', $product->id)->count();
                if($checksize){
                    $product_size = ProductSize::where('size_id', $k)->where('product_id', $product->id)->first();
                    $product_size->price = $s;
                    $product_size->save();
                }else{

                    $product_size = new ProductSize();
                    $product_size->size_id = $k;
                    $product_size->product_id = $product->id;
                    $product_size->price = $s;
                    $product_size->save();
                }
            }
        }


        ProductIngredient::where('product_id',$product->id)->delete();

        foreach ($ingredients as $ing) {
            if($ing){
                $product_ing = new ProductIngredient();
                $product_ing->product_id = $product->id;
                $product_ing->ingredient_id = $ing;
                $product_ing->save();
            }
        }

        $category = Category::where('id',$request->categoryId)->first('slug');

        return response()->json(['success' => 'Product Edited SuccessFully','category'=>$category], 200);

    }

    /**
     * Get Single Product Data
     *
     * @return Json
     * 
     */
    public function getProductSingleData(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        return response()->json(['content' => $product]);
    }

    /**
     * Add Product Page Data In Database
     *
     * @return Json
     * 
     */
    public function getaddproductpagedata(Request $request)
    {
        $ingredients = Ingredient::where('status',1)->whereHas('ingCategory', function($q){
            $q->where('name', '!=', 'size');
        })->get();

        $sizes = Ingredient::where('status',1)->whereHas('ingCategory', function($q){
            $q->where('name', 'size');
        })->get();

        $categoriewithslug = Category::where('status',1)->pluck('name','slug')->toArray();
        $categories = Category::where('status',1)->pluck('name','id')->toArray();

        return response()->json(['ingredients' => $ingredients, 'sizes' => $sizes, 'categories' => $categories, 'categoriewithslug'=>$categoriewithslug]);

    }

    /**
     * Edit Product Page Data In Database
     *
     * @return Json
     * 
     */
    public function geteditproductpagedata(Request $request)
    {
        $product = Product::where('slug', $request->slug)->with('category')->first();

        $ingredients = Ingredient::whereHas('ingCategory', function($q){
            $q->where('name', '!=', 'size');
        })->get();

        $sizes = Ingredient::whereHas('ingCategory', function($q){
            $q->where('name', 'size');
        })->get();

        $selectIng = Ingredient::whereHas('ingCategory', function($q){
            $q->where('name', '!=', 'size');
        })
        ->whereHas('productIngredients', function($q) use ($product){
            $q->where('product_id', $product->id);
        })
        ->get();

        $selectSize = ProductSize::where('product_id', $product->id)->get();
        foreach($selectSize as $ss){
            $s = $sizes->where('id', $ss->size_id)->first();
            $sizeIndex = $sizes->search(function($size) use ($ss){
                return $size->id === $ss->size_id;
            });
            $sizes[$sizeIndex]['price'] = $ss->price;
        }

        $categoriewithslug = Category::where('status',1)->pluck('name','slug')->toArray();
        $categories = Category::where('status',1)->pluck('name','id')->toArray();


        return response()->json(['ingredients' => $ingredients, 'sizes' => $sizes, 'product' => $product , 'categories' => $categories , 'selectIng' => $selectIng , 'selectSize' => $selectSize, 'categoriewithslug'=>$categoriewithslug]);

    }

    /**
     * Remove Product Data In Database
     *
     * @return Json
     * 
     */
    public function removeProduct(Request $request)
    {
        $product = product::find($request->id);
        $path = public_path()."/storage/$product->image";
        $product->delete();
        $result = File::exists($path);

        if($result)
        {
            File::delete($path);
        }

        return response()->json(['success' => 'Product removed successfully']);
    }

    /**
     * Ingredient Search
     *
     * @return Json
     * 
     */
    public function searchIngredients(Request $request)
    {
        $searchIng = $request->searchIng;
        $ingredients = Ingredient::whereHas('ingCategory', function($q){
            $q->where('name', '!=', 'size');
        })->where('name','LIKE','%'.$searchIng.'%')->get();
        return response()->json(['ingredients' => $ingredients]);
    }
}
