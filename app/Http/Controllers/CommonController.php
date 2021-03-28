<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    /**
     * get car model
     */
    public function getModel ($car_type_id) 
    {
        $models   = CarModel::select('id','name')->where('car_type_id', $car_type_id)->get();
        return response()->json($models);
    }
}
