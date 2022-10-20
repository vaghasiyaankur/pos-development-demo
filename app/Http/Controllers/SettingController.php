<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use DateTimeZone;
use Illuminate\Http\Request;
use File;

class SettingController extends Controller
{

    /**
     * Get Setting Page Data
     *
     * @return Json
     * 
     */
    public function getSettingData()
    {
        $setting = Setting::pluck('value','type');
        $timeZone = DateTimeZone::listIdentifiers();
        return response()->json(['setting' => $setting, 'timeZone' => $timeZone],200);
    }

    /**
     * Edit Setting Page Data In Database
     *
     * @return Json
     * 
     */
    public function edit_setting(Request $request)
    {
        $setting = $request->toarray();

        $get_logo = Setting::where('type',"logo")->first('value');
        $logo_file = $request->file('logo');

        if ($logo_file) {
            $logo_image_name = 'setting/'.rand(100000,999999).".".$logo_file->GetClientOriginalExtension();
            $logo_file->move(public_path('storage/setting/'),$logo_image_name);

            $path = public_path()."/storage/".@$get_logo->value;
            $result = File::exists($path);

            if($result && $get_logo->value != 'setting/logo.png')
            {
                File::delete($path);
            }
        }else{
            $logo_image_name = $get_logo->value;
        }

        $get_fav_icon = Setting::where('type',"fav_icon")->first('value');
        $fav_icon_file = $request->file('fav_icon');
        if ($fav_icon_file) {
            $fav_icon_image_name = 'setting/'.rand(100000,999999).".".$fav_icon_file->GetClientOriginalExtension();
            $fav_icon_file->move(public_path('storage/setting/'),$fav_icon_image_name);
            $path = public_path()."/storage/".@$get_fav_icon->value;
            $result = File::exists($path);

            if($result && $get_fav_icon->value != 'setting/fav_icon.png')
            {
                File::delete($path);
            }
        }else{
            $fav_icon_image_name = $get_fav_icon->value;
        }

        foreach ($setting as $key => $val) {
            if ($key == "logo" || $key == "fav_icon") {
                if ($key == "logo") {
                    Setting::where('type',$key)->update(['value'=>$logo_image_name]);
                }else{
                    Setting::where('type',$key)->update(['value'=>$fav_icon_image_name]);
                }
            }else{
                Setting::where('type',$key)->update(['value'=>$val]);
            }
        }
        return response()->json(['success'=>'Settings changed successfully']);
    }

}
