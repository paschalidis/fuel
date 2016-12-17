<?php

namespace app\Http\Controllers;

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

        $fields = $this->_request->get('fields', '*');

        if(strcasecmp($fields, '*') != 0){
            $gasStation = new GasStation();
            $columns = $gasStation->getColumnList();

            $fields = explode(",", $fields);
            foreach ($fields as $field){
                if(!in_array($field, $columns)){
                    $content = array(
                        $field => array("The " . $field . " field does not exist"),
                        'message' => 'Invalid field',
                    );

                    return response()->json($content, 400);
                }
            }
        }

        $GasStations = GasStation::all($fields);

        return response()->json($GasStations);
    }

    public function count(){
        $GasStations = GasStation::all()->count();
        return response()->json($GasStations);
    }
}