<?php
/**
 * Tabela é sysuser
 */
namespace App\Http\Controllers;
  
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
  
use Illuminate\Database\Eloquent\ModelNotFoundException;
  
class UserController extends Controller{

  
    public function index(){
        $users  = User::all();
        return response()->json($users);
    }
  
    public function get($id){
        $user  = User::find($id);
        return response()->json($user);
    }
  
    public function create(Request $request){
        $user = User::create($request->all());
        return response()->json($user,201);
    }
  
    public function delete($id){
        $user  = User::find($id);
        $user->delete();
        return response()->json('deleted');
    }
  
    public function update(Request $request,$id){
        $user  = User::find($id);
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->role = $request->input('role');
        $user->save();
        return response()->json($user);
    }
  
}