<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Get All taxes 
     * 
     * @return Json
     * 
     */
    public function taxes()
    {
        $taxes = Tax::all();
        return response()->json(['taxes' => $taxes]);
    }

    /**
     * Add & Update Tax in Database
     *
     * @param Request $request
     * 
     * @return Json
     * 
     */
    public function taxAddUpdate(Request $request)
    {
        if($request->id){
            $tax = Tax::where('id', $request->id)->first();
        }else{
            $tax = new Tax;
        }
        if($tax){
            $tax->name = $request->name;
            $tax->tax_type = $request->tax_type;
            $tax->tax_value = $request->tax_value;
            $tax->status = $request->status;
            $tax->save();
        }
        if($request->id){
            return response()->json(['success'=> 'Tax updated successfully.']);
        }else{
            return response()->json(['success'=> 'Tax added successfully.']);
        }
    }

    /**
     * Delete Tax in Database
     *
     * @param Request $request
     * 
     * @return Json
     * 
     */
    public function taxDelete(Request $request)
    {
        Tax::where('id', $request->id)->delete();
        return response()->json(['success' => 'success']);
    }

    /**
     * Tax Status Change
     *
     * @param Request $request
     * 
     * @return Json
     * 
     */
    public function taxStatusChange(Request $request)
    {
        $tax = Tax::where('id', $request->id)->update(['status' =>  $request->value]);
        return 'success';
    }

    /**
     * Get Single Tax Data
     *
     * @param Request $request
     * 
     * @return Json
     * 
     */
    public function getSingleData(Request $request)
    {
        $id = $request->id;
        $tax = Tax::where('id', $id)->first();
        return response()->json(['tax' => $tax]);
    }
}
