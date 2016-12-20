<?php

namespace app\Http\Controllers;

use App\Models\PriceData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Mappers\QueryMapper;
use DB;

class OrderController extends Controller
{
    public function getOrders(Request $request)
    {
        if(is_null($request->user())){
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        //Get orders of user
        $queryMapper = new QueryMapper(['owner' => $request->user()->username], 'orders');
        $orders = $queryMapper->get();

        if(empty($orders)){
            return response()->json(['message' => 'No Orders Found.'], 200);
        }

        return response()->json($orders);
    }

    public function create(Request $request)
    {
        //Customize error messages
        try{
            $this->validate($request, [
                'priceDataID' => 'required|max:11',
                'quantity' => 'required',
            ]);
        } catch (\Exception $e){
            $response = $e->getResponse();
            $content = json_decode($response->getContent(), true);
            $content['message'] = "Validation error";
            $response->setContent(json_encode($content));

            return $response;
        }

        if(is_null($request->user())){
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $clientName = $request->user()->username;
        $priceDataID = $request->get('priceDataID');
        $quantity = $request->get('quantity');

        //Get price data values
        $priceDataParameters = array('priceDataID' => $priceDataID,
                                     'fields' => 'gasStationID,fuelPrice,fuelName');

        $queryMapper = new QueryMapper($priceDataParameters,'pricedata');
        $priceData = $queryMapper->get();

        if(empty($priceData)){
            return response()->json(['message' => 'Fuel Not Exist.'], 400);
        }
        $priceData = $priceData[0];

        //Get gas station values
        $queryMapper->setTable('gasstations');
        $queryMapper->setParameters(array('gasStationID' => $priceData->gasStationID, 'fields' => 'username'));

        $gasStation = $queryMapper->get();

        if(empty($priceData)){
            return response()->json(['message' => 'Gas Station Not Exist.'], 400);
        }
        $gasStation = $gasStation[0];

        $parameters = array($clientName,
                            $priceDataID,
                            $quantity,
                            $priceData->fuelPrice,
                            $priceData->fuelName,
                            $gasStation->username);
        try{
            $inserted = DB::insert('INSERT INTO orders (client, priceDataID, quantity, fuelPrice, fuelName, owner)
                                    VALUES (?, ?, ?, ?, ?, ?)', $parameters);
        } catch (\Exception $e){
            $message = $e->getMessage();
            if(isset($e->errorInfo[2])){
                $message = $e->errorInfo[2];
            }
            return response()->json(['message' => $message], 400);
        }

        if(!$inserted){
            return response()->json(['message' => 'Error on order creation. Please try again.'], 400);
        }
        return response()->json(['message' => 'Order Created Successfully']);
    }
}