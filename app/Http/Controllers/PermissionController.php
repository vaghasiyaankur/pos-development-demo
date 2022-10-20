<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Permission;
use Auth;

class PermissionController extends Controller
{

    /**
     * Check User Or Admin Is Not Login For Routes
     *
     * @return Json
     * 
     */
    public function checknotlogin()
    {
        if(!Auth::check()){
            return response()->json(['success' => 'success'], 200);
        }else{
            $user = Auth::user(); 
            $indexper = Permission::where('function', 'Index')->where($user->type, 1)->count();
            return response()->json(['failed' => 'failed', 'indexper' => $indexper], 401);
        }
    }

     /**
     * Check User Or Admin Is Login For Routes
     *
     * @return Json
     * 
     */
    public function checklogin(Request $request)
    {
        if(Auth::check()){
            $lock = Auth::user()->lock_enable;
            if($lock){
                return response()->json(['success' => 0, 'lock' => 1], 200);
            }
            $page = $request->page;
            $type = Auth::user()->type;
            $permission = Permission::where('function', $page)->where($type, 1)->count();
            if($permission){
                return response()->json(['success' => 1, 'lock' => 0], 200);
            }else{
                return response()->json(['success' => 0, 'lock' => 0], 200);
            }
        }else{
            return response()->json(['failed' => 'failed'], 401);
        }
    }

     /**
     * Check User Permission
     *
     * @return Json
     * 
     */
    public function checkheaderpermission()
    {
        if(Auth::check()){
            $type = Auth::user()->type;
            $permissions = Permission::get();
            $data = [];
            foreach($permissions as $permission){
                $data[$permission->function] = @$permission->$type;
            }

            return response()->json(['permissions' => $data], 200);
        }else{

            return response()->json(['permissions' => []], 200);
        }
    }
}
