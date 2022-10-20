<?php

namespace App\Http\Controllers;

use App\Models\IngredientCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class IngredientCategoryController extends Controller
{
    /**
     * Get Ingredient Category List
     *
     * @return Json
     * 
     */
    public function getingcategorylist()
    {
        $ingcategories = IngredientCategory::withCount('ingredients')->with('ingredients')->orderBy('status', 'desc')->get();
        foreach ($ingcategories as $ingcategory) {
            if ($ingcategory->ingredients_count != 0) {
                $ingcategory['image'] = $ingcategory->ingredients[0]->image;
            }
        }
        return response()->json(['content' => $ingcategories]);
    }

    /**
     * Add Ingredient Category In Database
     *
     * @return Json
     * 
     */
    public function addingcategory(Request $request)
    {
        $ingcategorycontent = $request->only('name', 'id');

        $validator = Validator::make($ingcategorycontent, [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

        $ingcategory = new IngredientCategory();
        $ingcategory->name = $request->name;
        $ingcategory->save();

        return response()->json(['success' => 'ingredient category added sucecessfully'], 200);

    }

    /**
     * Edit Ingredient Category In Database
     *
     * @return Json
     * 
     */
    public function editingcategory(Request $request)
    {
        $ingcategorycontent = $request->only('name', 'id','image', 'status');

        $validator = Validator::make($ingcategorycontent, [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

        $ingcategory = IngredientCategory::where('id', $request->id)->first();
        $ingcategory->name = $request->name;
        $ingcategory->status = $request->status;
        $ingcategory->save();

        return response()->json(['success' => 'IngredientCategory Edited SuccessFully'], 200);

    }

    /**
     * Get Single Ingredient Category
     *
     * @return Json
     * 
     */
    public function getIngCategorySingleData(Request $request)
    {
        $ingcategory = IngredientCategory::where('id', $request->id)->first();
        return response()->json(['content' => $ingcategory]);
    }

    /**
     * Remove Ingredient Category In Database
     *
     * @return Json
     * 
     */
    public function removeIngcategory(Request $request)
    {
        $ingcategory = IngredientCategory::find($request->id);
        $ingcategory->delete();
        return response()->json(['success' => 'Ingredient Category removed successfully']);
    }
}
