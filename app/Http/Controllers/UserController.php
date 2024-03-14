<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use App\Mail\RegisterActivate;
use App\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Rules\Email;
use Illuminate\Validation\Rule;
class UserController extends Controller
{
    public function index(){
        
        $users = User::with('role')->get();
        return response()->json(["user"=>$users],200);
    }

    public function store(Request $request){
        $validate = Validator::make($request->all(),[
            'name'  =>  'required',
            'email' =>  ['required','email','unique:users',new Email],
            'password'  =>  'required|confirmed|min:8',
            'role_id'   =>  'required|numeric|between:1,4'
        ]);
        if($validate->fails()){
            return response()->json([
                "Error"=>$validate->errors()
            ],422);
        }
        $code = Crypt::encrypt(rand(100000,999999));
        $user=User::create([
            'name'  =>  $request->name,
            'email' =>  $request->email,
            'password'   =>  Hash::make($request->password),
            'code'  =>  $code,
            'role_id'    =>  $request->role_id ?? 2
            
        ]);
        $signed_route = URL::temporarySignedRoute(
            'activate',
            now()->addMinutes(15),
            ['user'=>$user->id]
        );
        Mail::to($user->email)->send(new RegisterActivate($signed_route));
        return response()->json([
            'msg'   =>  "User created succesfully, we send you a confirmation email ",
            'data'  =>  $user
        ],201);
    }

    public function show(int $id){
        $user = User::with('role')->find($id);
        if($user){
            
            return response()->json(["user"=>$user],200);
        }
        return response()->json(["msg"=>"User not found"],404);
    }

    public function edit(int $id){
        $user = User::find($id);
        if($user){
            return response()->json(["user"=>$user],200);
        }
        return response()->json(["msg"=>"User not found"],404);
    }

    public function update(Request $request, int $id){
        $request->all();
        $user = User::find($id);
        if(!$user){
            return response()->json(["msg"=>"User not found"],404);
        }

        $validate = Validator::make($request->all(),[
            'name'  =>  'required',
            'email' =>  ['required','email',Rule::unique('users')->ignore($user->id),new Email],
            'password'  =>  'sometimes|confirmed|min:8',
            'role_id'   =>  'required|numeric|between:1,3'
        ]);
        if($validate->fails()){
            return response()->json([
                "Error"=>$validate->errors()
            ],422);
        }
        $user->name = $request->get('name',$user->name);
        $user->email = $request->get('email',$user->email);
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->role_id = $request->get('role_id',$user->role_id);
        $user->save();
        return response()->json(["msg"=>"User updated succesfully","user"=>$user],200);
        
        
    }

    public function destroy(int $id){
        $user = User::find($id);
        if(!$user){
            return response()->json(["msg"=>"User not found"],404);
        }
        $user->status=false;
        return response()->json(["msg"=>"User deleted succesfully"],200);
    }

    public function roles(){
        $roles = Role::all();
        return response()->json(["roles"=>$roles],200);
    }
   
}
