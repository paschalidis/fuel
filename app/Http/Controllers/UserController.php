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

        if(empty($user)){
            return response()->json(["message"=>"Username or Password is incorrect"], 400);
        }

        $token = str_random(60);
        $user = User::find($user[0]->username);
        $user->setAttribute('api_token', $token);
        $user->setAttribute('api_token_expire_time', time() + 3600);
        $user->save();

        return response()->json(['api_token' => $user->api_token, 'message' => 'Successfully Login']);
    }

    public function register(Request $request)
    {
        //Customize error messages
        try{
            $this->validate($request, [
                'username' => 'required|unique:users|max:45',
                'email' => 'required|email|unique:users|max:255',
                'password' => 'required|max:32',
                'userType' => 'required'
            ]);
        } catch (\Exception $e){
            $response = $e->getResponse();
            $content = json_decode($response->getContent(), true);
            $content['message'] = "Validation error";
            $response->setContent(json_encode($content));

            return $response;
        }

        //Check if user group exist
        $userType = $request->get('userType');
        $group = \DB::select('SELECT * FROM groups WHERE groupID = ?', [$userType]);

        if(empty($group)){
            return response()->json(["message"=>"Error Invalid User Type"], 400);
        }

        User::create($request->all());

        //Add user to Group Permission
        try{
            $inserted = \DB::insert('INSERT INTO user_has_group (username, groupID)
                                    VALUES (?, ?)', [$request->get('username'), $userType]);
        } catch (\Exception $e){
            $message = $e->getMessage();
            if(isset($e->errorInfo[2])){
                $message = $e->errorInfo[2];
            }
            return response()->json(['message' => $message], 400);
        }

        if(!$inserted){
            return response()->json(['message' => 'Error on user registration. Please try again.'], 400);
        }

        $token = str_random(60);
        $user = User::find($request->get('username'));
        $user->setAttribute('api_token', $token);
        $user->setAttribute('api_token_expire_time', time() + 3600);
        $user->save();
        return response()->json(['api_token' => $user->api_token, 'message' => 'Successfully registration.']);
    }

    public function info(){
        return response()->json(Auth::user());
    }
}