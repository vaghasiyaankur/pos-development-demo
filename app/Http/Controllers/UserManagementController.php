<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Setting;
use App\Models\Permission;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Redirect;
use Auth;   
use Carbon\Carbon;

class UserManagementController extends Controller
{

    /**
     * Get user List
     *
     * @return Json
     * 
     */
    public function getuserlist(Request $request)
    {
        $super_admin = User::where('type','super_admin')->get();
        $sub_admin = User::where('type','sub_admin')->get();
        $kitchen_manager = User::where('type','kitchen_manager')->get();
        $waiter = User::where('type','waiter')->get();
        return response()->json(['super_admin' => $super_admin,'sub_admin' => $sub_admin,'kitchen_manager' => $kitchen_manager,'waiter' => $waiter]);
    }

    /**
     * Add user In Database
     *
     * @return Json
     * 
     */
    public function adduser(Request $request)
    {
        $usercontent = $request->only('name', 'email', 'password', 'password_confirmation', 'photo', 'govt_id', 'active', 'type');

        $validator = Validator::make($usercontent, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:8|same:password',
            'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'type' => 'required',
            'govt_id' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

        $photoFile = $request->file('photo');
        $image_name = 'user/'.rand(100000,999999).".".$photoFile->GetClientOriginalExtension();
        $photoFile->move(public_path('storage/user/'),$image_name);

        $govtIdImage = $request->file('govt_id');
        $govt_id_image_name = 'govId/'.rand(100000,999999).".".$govtIdImage->GetClientOriginalExtension();
        $govtIdImage->move(public_path('storage/govId/'),$govt_id_image_name);


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->photo = $image_name ? $image_name : $request->image;
        $user->type = $request->type;
        $user->govt_id = $govt_id_image_name ? $govt_id_image_name : $request->govt_id;
        $user->active = 1;
        $user->save();

        return response()->json(['success' => 'User added sucecessfully'], 200);

    }

    /**
     * Edit User Data In Database
     *
     * @return Json
     * 
     */
    public function edituser(Request $request)
    {
        $usercontent = $request->only('id', 'name', 'photo', 'govt_id', 'active', 'type');

        $validator = Validator::make($usercontent, [
            'name' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

        $user = User::where('id', $request->id)->first();
        $image_name = $user->photo;
        if($request->file('photo'))
    	{
            $validatorimage = Validator::make($usercontent, [
                'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                ]
            );

            if ($validatorimage->fails()) {
                return response()->json(['error' => $validatorimage->messages()], 401);
            }


            $file = $request->file('photo');
            $image_name = 'user/'.rand(100000,999999).".".$file->GetClientOriginalExtension();
            $file->move(public_path('storage/user/'),$image_name);


        $path = public_path()."/storage/$user->image";
        $result = File::exists($path);

        if($result)
        {
            File::delete($path);
        }

        }


        $govt_id_image_name = $user->govt_id;
        if($request->file('govt_id'))
    	{
            $validatorimage = Validator::make($usercontent, [
                'govt_id' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
                ]
            );

            if ($validatorimage->fails()) {
                return response()->json(['error' => $validatorimage->messages()], 401);
            }


            $file = $request->file('govt_id');
            $govt_id_image_name = 'govId/'.rand(100000,999999).".".$file->GetClientOriginalExtension();
            $file->move(public_path('storage/govId/'),$govt_id_image_name);


        $path = public_path()."/storage/$user->govt_id";
        $result = File::exists($path);

        if($result)
        {
            File::delete($path);
        }

        }
        
        $user->name = $request->name;
        $user->photo = $image_name ? $image_name : $request->image;
        $user->type = $request->type;
        $user->govt_id = $govt_id_image_name ? $govt_id_image_name : $request->govt_id;
        $user->active = $user->active;
        $user->save();

        return response()->json(['success' => 'User Edited SuccessFully'], 200);

    }

    /**
     * Get Single User Data
     *
     * @return Json
     * 
     */
    public function getUserSingleData(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        return response()->json(['content' => $user]);
    }

    /**
     * Get User Data
     *
     * @return Json
     * 
     */
    public function getUserData()
    {
        $user = Auth::user();
        return $user;
    }

    /**
     * Send Current Login User passcode and logo  for scrren lock page 
     *
     * @return Json
     * 
     */
    public function userPasscode()
    {
        $indexper = Permission::where('function', 'Index')->count();
        $logo_image = Setting::where('type', 'light_icon')->first();
        $logo_image_path = 'storage/'.@$logo_image->value;


        return response()->json(['passcode' => 0000, 'indexpermission' => $indexper, 'logo_image' => $logo_image_path]);
    }

    /**
    * Set Lock Scrren Enable And Disable
    * @param Request $request
    * @param LockSet $request->lock  (ex. 0 or 1)
    */
    public function lockEnableDisable(Request $request)
    {
        // $update = User::where('id', Auth::user()->id)->update(['lock_enable' => $request->lock]);
        return 'success';
    }

    /**
    * To Get Live Date And Time For LockScreen Page
    * @param Request $request
    */
    public function liveDateTime(Request $request)
    {
        $time = Carbon::now()->format('h:i A');
        $date = Carbon::now()->format('l F j,Y');
        return response()->json(['time' => $time, 'date' => $date]);
    }

    
}
