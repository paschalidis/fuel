<?php

namespace app\Http\Controllers;

use App\Models\PriceData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PriceDataController extends Controller
{

    public function getPriceData(Request $request, $gasStationId)
    {
        $fields = $request->get('fields', '*');

        if(strcasecmp($fields, '*') != 0){
            $gasStation = new PriceData();
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

            if(!in_array('gasStationID', $fields)){
                $fields[] = 'gasStationID';
            }
        }

        $priceData = PriceData::all($fields)->where("gasStationID", "=", $gasStationId);

        return response()->json($priceData);
    }
}