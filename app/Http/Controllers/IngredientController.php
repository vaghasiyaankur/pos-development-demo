<?php

namespace App\Http\Controllers;

use App\Models\IngredientCategory;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Http\Request;

class IngredientController extends Controller
{

    /**
     * Get Ingredient Data
     *
     * @return Json
     * 
     */
    public function getingredientlist(Request $request)
    {
        $slug = $request->slug;
        $ingcategory = IngredientCategory::where('slug', $slug)->first();
        $ingredients = Ingredient::where('ingredient_category_id', $ingcategory->id)->orderBy('status', 'desc')->get();

        return response()->json(['ingcategory' => $ingcategory , 'ingredients' => $ingredients]);
    }

    /**
     * Add Ingredient In Database
     *
     * @return Json
     * 
     */
    public function addingredient(Request $request)
    {
        $ingredientcontent = $request->only('ingcategory_slug', 'name', 'id','image', 'price');

        $validator = Validator::make($ingredientcontent, [
            'name' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

        $file = $request->file('image');
        $image_name = 'ingredient/'.rand(100000,999999).".".$file->GetClientOriginalExtension();
        $file->move(public_path('storage/ingredient/'),$image_name);

        $category = IngredientCategory::where('slug', $request->ingcategory_slug)->first();

        $ingredient = new Ingredient();
        $ingredient->name = $request->name;
        $ingredient->price = $request->price;
        $ingredient->image = $image_name ? $image_name : $request->image;
        $ingredient->ingredient_category_id = $category->id;
        $ingredient->save();

        return response()->json(['success' => 'ingredient added sucecessfully'], 200);

    }

    /**
     * Edit Ingredient In Database
     *
     * @return Json
     * 
     */
    public function editingredient(Request $request)
    {
        $ingredientcontent = $request->only('categrory_slug', 'name', 'id','image', 'price', 'status');

        $validator = Validator::make($ingredientcontent, [
            'name' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

        $ingredient = Ingredient::where('id', $request->id)->first();
        $image_name = $ingredient->image;
        if($request->file('image'))
    	{
            $validatorimage = Validator::make($ingredientcontent, [
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                ]
            );

            if ($validatorimage->fails()) {
                return response()->json(['error' => $validatorimage->messages()], 401);
            }


            $file = $request->file('image');
            $image_name = 'ingredient/'.rand(100000,999999).".".$file->GetClientOriginalExtension();
            $file->move(public_path('storage/ingredient/'),$image_name);


        $path = public_path()."/storage/$ingredient->image";
        $result = File::exists($path);

        if($result)
        {
            File::delete($path);
        }

        }

        $ingredient->name = $request->name;
        $ingredient->status = $request->status;
        $ingredient->image = $image_name;
        $ingredient->price = $request->price;
        $ingredient->save();

        return response()->json(['success' => 'Ingredient Edited SuccessFully'], 200);

    }

    /**
     * Get Single Ingredient
     *
     * @return Json
     * 
     */
    public function getIngredientSingleData(Request $request)
    {
        $ingredient = Ingredient::where('id', $request->id)->first();
        return response()->json(['content' => $ingredient]);
    }

    /**
     * Delete Ingredient In Database
     *
     * @return Json
     * 
     */
    public function removeIngredint(Request $request)
    {
        $ingredient = Ingredient::find($request->id);

        $path = public_path()."/storage/$ingredient->image";
        $result = File::exists($path);

        if($result)
        {
            File::delete($path);
        }
        $ingredient->delete();

        return response()->json(['success' => 'Ingredient removed successfully']);
    }
}
