<?php

namespace app\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{

    public function create(Request $request)
    {
        //Customize error messages
        try{
            $this->validate($request, [
                'username' => 'required|unique:users|max:45',
                'email' => 'required|email|unique:users|max:255',
                'password' => 'required|max:32'
            ]);
        } catch (\Exception $e){
            $response = $e->getResponse();
            $content = json_decode($response->getContent(), true);
            $content['message'] = "Validation error";
            $response->setContent(json_encode($content));

            return $response;
        }

        $user = User::create($request->all());

        return response()->json($user);
    }
}