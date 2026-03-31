<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
     public function index()
        {
            $sliders = Slider::select('id','image')->get();

            $data = $sliders->map(function ($slider) {
                return [
                    'id' => $slider->id,
                    'image' => asset('storage/sliders/'.$slider->image)
                ];
            });

            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        }
}
