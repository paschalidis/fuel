<?php

namespace app\Http\Controllers;

use app\Mappers\QueryMapper;
use App\Models\GasStation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GasStationController extends Controller
{

    protected $_request;

    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

    public function index(){

        $queryMapper = new QueryMapper($this->_request->all(), 'gasstations');

        try{
            $GasStations = $queryMapper->get();
        } catch (\Exception $e){
            $message = $e->getMessage();
            if(isset($e->errorInfo[2])){
                $message = $e->errorInfo[2];
            }
            return response()->json(['message' => $message], 400);
        }

        return response()->json($GasStations);
    }

    public function count(){
        $GasStations = GasStation::all()->count();
        return response()->json($GasStations);
    }
}