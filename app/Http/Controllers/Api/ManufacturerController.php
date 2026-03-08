<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManufacturingManage;

class ManufacturerController extends Controller
{
    public function index()
        {
            $manufacturers = ManufacturingManage::select('id','logo')->limit(10)->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'logo' => asset('storage/products/'.$item->logo)
                    ];
                });

            return response()->json([
                'status' => true,
                'data' => $manufacturers
            ]);
        }
}
