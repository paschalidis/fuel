<?php

namespace app\Http\Controllers;

use App\Models\PriceData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Mappers\QueryMapper;

class PriceDataController extends Controller
{

    public function index(Request $request)
    {
        $queryMapper = new QueryMapper($request->all(), 'pricedata');

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

    public function update(Request $request, $fuelTypeID, $fuelSubTypeID, $gasStationId){

        $values = $request->all();

        if(empty($values)){
            return response()->json(['message' => 'No values to update'], 400);
        }

        $input = array();
        try{
            $where = 'where gasStationID = ? and fuelTypeID =? and fuelSubTypeID = ?';
            $valuesString = "";
            foreach ($values as $column => $value){
                $valuesString .= ' ' . $column  . ' = ? ,';
                $input[] = $value;
            }

            $valuesString = rtrim($valuesString, ',');

            $update = 'update pricedata set ';
            array_push($input, $gasStationId);
            array_push($input, $fuelTypeID);
            array_push($input, $fuelSubTypeID);
            $affected = \DB::update($update . $valuesString . $where, $input);

        } catch (\Exception $e){
            $message = $e->getMessage();
            if(isset($e->errorInfo[2])){
                $message = $e->errorInfo[2];
            }
            return response()->json(['message' => $message], 400);
        }

        return response()->json(['message' => 'Price Data Updated Successfully', 'updated' => $affected]);
    }
}