<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use App\Post;
use Illuminate\Support\Facades\Auth; 
use Validator;

class UserController extends Controller{

    public $successStatus = 200;
     
    public function posts(){
        $post = Post::orderBy('created_at','desc');
       return Post::whereBetween('id',[1,10])->get();
    }

    public function register(Request $request){
       $validator = Validator::make($request->all(),[
           'name' => 'required',
           'email' => 'required|email',
           'password' => 'required',
           'c_password' => 'required|same:password',
       ]);
    if($validator->fail()){
        return response()->json(['error'=> $validator->errors()],401);
    }
    else{
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken; 
        $success['name'] =  $user->name;
    return response()->json(['success' => $success],200);
    }
}
  
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(['success'=> $success],200);
        }
        else
        return response()->json(['error' => 'Unauthorised'],401);
    }

    public function details(){
        $user = Auth::user();
        return response()->json(['success' => $user],200);
    }
    
    public function logout(){
        if(Auth::check()){
            Auth::user()->AuthAccessToken()->delete();
            return response()->json(['success' => 'User Logout successfully.'],200);
        }
    }
}