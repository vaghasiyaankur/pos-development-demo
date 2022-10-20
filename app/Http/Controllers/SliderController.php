<?php 
 
namespace App\Http\Controllers;
 
use App\Models\Slider;
 
 
class SliderController extends Controller
{

    /**
     * Get Slider Table Data
     *
     * @return Json
     * 
     */
    public function index()
    {
        $sliderImg = Slider::get();
        return response()->json($sliderImg);
         
    }
}