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

        $parameters = array($request->user()->username,
                            $request->get('priceDataID'),
                            $request->get('quantity'));
        try{
            $inserted = DB::insert('INSERT INTO orders (username, priceDataID, quantity) VALUES (?, ?, ?)', $parameters);
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