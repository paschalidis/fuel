<?php

namespace app\Http\Controllers;

use App\Models\PriceData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Mappers\QueryMapper;

class PriceDataController extends Controller
{

    public function getPriceData(Request $request, $gasStationId)
    {
        $parameters = $request->all();
        $parameters['gasStationID'] = $gasStationId;
        $queryMapper = new QueryMapper($parameters, 'pricedata');

        try{
            $priceData = $queryMapper->get();
        } catch (\Exception $e){
            $message = $e->getMessage();
            if(isset($e->errorInfo[2])){
                $message = $e->errorInfo[2];
            }
            return response()->json(['message' => $message], 400);
        }

        return response()->json($priceData);
    }
}