<?php

namespace App\Http\Controllers;
  
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
  

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;

// use Log;

class AuthController extends Controller{

    /*
     * This method supports basic auth and access token 
     */
    public function login(Request $request){
        $username = $password = null;

        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];
        }else{
            $username = $request->input('email');
            if (empty($username)) {
                $username = $request->input('username');  
            }
            $password = $request->input('password');            
        }

        if (empty($username) || empty($password)){
            throw new ValidationException('User and/or passwords not informed!');
        }

        $user = User::where([
                                ['email', '=', strtolower(trim($username))],
                                ['password', '=', md5(trim($password))]
                ])->first();
        
        if ($user){
            $user->access_token = md5(date('d-m-Y H:i:s'));
            $user->save();
            return $user;

        }else{
            throw new AuthorizationException('User or password invalid!');
        }

    }


    /**
     * This method works with access_token in Bearer attribute in header
     */
    public function logout(Request $request){
        $token = null; 
        if(!empty($request->header('Authorization'))){
            $token = $request->header('Authorization');
            preg_match('/Bearer\s(\S+)/', $token, $matches);
            $token = $matches[1];
        }else{
            $token = $request->header('access_token');
        }

        if (empty($token)){
            throw new ValidationException('AuthController - Token not informed!');
        }

        $user = User::where('access_token', $token)->first();
        if ($user){
            $user->access_token = null;
            $user->save();
        }else{
            throw new AuthorizationException('Invalid Token!');
        }

        return "Logout success!";
    }

    /**
     * Register a new user
     */
    public function register(Request $request){

        $user  = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = md5($request->input('password'));
        $user->save();

        if ( $user->save() ){
            $user->password = null;
            return response()->json($user,201);
        }else{
            throw new \Exception('Fail to register a new user!');
        }        

    }
    
    
}