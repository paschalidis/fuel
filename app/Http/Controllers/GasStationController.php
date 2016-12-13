<?php

namespace app\Http\Controllers;

use App\Models\GasStation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GasStationController extends Controller
{

    public function index(){
        $GasStations = GasStation::all();
        return response()->json($GasStations);
    }
}