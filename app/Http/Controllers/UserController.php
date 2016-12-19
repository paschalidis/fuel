<?php

namespace app\Http\Controllers;

use app\Mappers\QueryMapper;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;

class UserController extends Controller
{

    public function login(Request $request){
        //Customize error messages
        try{
            $this->validate($request, [
                'username' => 'required|max:45',
                'password' => 'required|max:32'
            ]);
        } catch (\Exception $e){
            $response = $e->getResponse();
            $content = json_decode($response->getContent(), true);
            $content['message'] = "Validation error";
            $response->setContent(json_encode($content));

            return $response;
        }

        $queryBuilder = new QueryMapper(['username' => $request->get('username'), 'password' => $request->get('password')], 'users');
        $user = $queryBuilder->get();

        if(!empty($user)){
            $token = str_random(60);
            $user = User::find($user[0]->username);
            $user->setAttribute('api_token', $token);
            $user->setAttribute('api_token_expire_time', time() + 3600);
            $user->save();
            return response()->json(['api_token' => $user->api_token]);
        } else {
            return response()->json(["message"=>"invalid credentials"]);
        }
    }

    public function register(Request $request)
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

    public function info(){
        return response()->json(Auth::user());
    }
}