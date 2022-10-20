<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get Category List
     *
     * @return Json
     * 
     */
    public function getcategorylist()
    {
        $categories = Category::withCount('products')->orderBy('status', 'desc')->get();
        return response()->json(['content' => $categories]);
    }

    /**
     * Add Category In Database
     *
     * @return Json
     * 
     */
    public function addcategory(Request $request)
    {
        $categorycontent = $request->only('name', 'id','image');


        $validator = Validator::make($categorycontent, [
            'name' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

        $file = $request->file('image');
        $image_name = 'category/'.rand(100000,999999).".".$file->GetClientOriginalExtension();
        $file->move(public_path('storage/category/'),$image_name);
        $category = new Category();
        $category->name = $request->name;
        $category->image = $image_name ? $image_name : $request->image;
        $category->save();

        return response()->json(['success' => 'category added sucecessfully'], 200);

    }

    /**
     * Edit Category List
     *
     * @return Json
     * 
     */
    public function editcategory(Request $request)
    {
        $categorycontent = $request->only('name', 'id','image','status');

        $validator = Validator::make($categorycontent, [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

        $category = Category::where('id', $request->id)->first();
        $image_name = $category->image;
        if($request->file('image'))
    	{
            $validatorimage = Validator::make($categorycontent, [
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                ]
            );

            if ($validatorimage->fails()) {
                return response()->json(['error' => $validatorimage->messages()], 401);
            }


            $file = $request->file('image');
            $image_name = 'category/'.rand(100000,999999).".".$file->GetClientOriginalExtension();
            $file->move(public_path('storage/category/'),$image_name);


        $path = public_path()."/storage/$category->image";
        $result = File::exists($path);

        if($result)
        {
            File::delete($path);
        }

        }

        $category->name = $request->name;
        $category->image = $image_name;
        $category->status = $request->status;
        $category->save();

        return response()->json(['success' => 'Category Edited SuccessFully'], 200);

    }

    /**
     * Single Category Data
     *
     * @return Json
     * 
     */
    public function getCategorySingleData(Request $request)
    {
        $category = Category::where('id', $request->id)->first();
        return response()->json(['content' => $category]);
    }

    /**
     * Delete Category Data In Database
     *
     * @param Request $request
     * 
     * @return Json
     * 
     */
    public function deleteCategoryData(Request $request)
    {
        $category = Category::find($request->id);

        $path = public_path()."/storage/$category->image";
        $result = File::exists($path);

        if($result)
        {
            File::delete($path);
        }

        $category->delete();

        $categories = Category::withCount('products')->get();
        return response()->json(['content' => $categories]);
    }
}
