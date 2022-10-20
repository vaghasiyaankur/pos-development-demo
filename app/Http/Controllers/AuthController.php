<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Admin Or User Login  
     *
     * @param Request $request
     * 
     * @return Json 
     * 
     */
    public function login(Request $request)
    {
        $logincontent = $request->only('email','password');

        //valid credential
        $validator = Validator::make($logincontent, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

        $userdata = array(
            'email' => $request->email ,
            'password' => $request->password
          );

        if (Auth::attempt($userdata))
        {   
            $user = Auth::user(); 
            $indexper = Permission::where('function', 'Index')->where($user->type, 1)->count();
            return response()->json(['success' => 'Login sucecessfully', 'indexper' => $indexper], 200);
        }else{   
              $error = [
                'message' => [
                    'Your Email Or Password is Wrong!!',   
                ]
              ];
              return response()->json(['error' => $error], 401);
        }
    }

    /**
     * Admin Or User Logout  
     * 
     * @return [type]
     * 
     */
    public function logout()
    {
        $user = Auth::logout();
        return redirect('/login');
    }
}
