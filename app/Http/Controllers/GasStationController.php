<?php

namespace app\Http\Controllers;

use App\Models\GasStation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SoapBox\Formatter\Formatter;

class GasStationController extends Controller
{

    protected $parameters;
    public function __construct(Request $request)
    {
        $this->parameters = $request->all();
    }

    public function index(){
        $GasStations = GasStation::all();
        return response()->json($GasStations);
    }
}