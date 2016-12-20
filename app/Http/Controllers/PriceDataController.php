<?php

namespace app\Http\Controllers;

use App\Models\PriceData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Mappers\QueryMapper;
use DB;
use Illuminate\Support\Facades\App;

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

    public function update(Request $request, $priceDataId){

        $values = $request->all();

        if(empty($values)){
            return response()->json(['message' => 'No values to update'], 400);
        }

        if(is_null($request->user())){
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        //Check if user is owner from gas station
        $owner = DB::select("SELECT gas.username FROM gasstations AS gas
                              INNER JOIN pricedata as p
                              ON p.gasStationID = gas.gasStationID
                              WHERE p.priceDataID = ?
                              AND gas.username = ?", [$priceDataId, $request->user()->username]);

        if(empty($owner)){
            return response()->json(['message' => 'Permission Denied.'], 401);
        }

        $input = array();
        try{
            $where = 'where priceDataID = ?';
            $valuesString = "";
            foreach ($values as $column => $value){
                $valuesString .= ' ' . $column  . ' = ? ,';
                $input[] = $value;
            }

            $valuesString = rtrim($valuesString, ',');

            $update = 'update pricedata set ';
            array_push($input, $priceDataId);

            $affected = DB::update($update . $valuesString . $where, $input);

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