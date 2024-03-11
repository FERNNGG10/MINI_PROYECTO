<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Mail\LoginCode;
use App\Mail\RegisterActivate;
use App\Models\User;
use App\Rules\Email;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','activate']]);
    }
    public function register(Request $request){

        $validate = Validator::make($request->all(),[
            'name'  =>  'required',
            'email' =>  ['required','email','unique:users',new Email],
            'password'  =>  'required|confirmed|min:8'
        ]);
        if($validate->fails()){
            return response()->json([
                "Errorr"=>$validate->errors()
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

    public function activate(User $user){

        if(!$user){
            return response()->json("This account doesn't exist");
        }
        $user->status=true;
        $user->save();
        return response()->json("Your account has been activated",200);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {   
        $credentials = request(['email', 'password']);
        $user = User::where('email',request('email'))->first();
        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        else{
            if($this->verify_code($request,$user)){
                return $this->respondWithToken($token);
            }
            else{
                $code = Crypt::decrypt($user->code);
                Mail::to($user->email)->send(new LoginCode($code));
                return response()->json(["msg"=>"Insert Code, Check Your Email"],200);
            }
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function verify_code(Request $request,User $user){
      
        $codei = $request->input('code');
        $code = Crypt::decrypt($user->code);
        if($code == $codei ){
            $new_code = Crypt::encrypt(rand(100000,999999));
            $user->code = $new_code;
            $user->save();
            return true;
        }
        return false;
        
        
    }

    public function is_auth(){
       
        if(auth()){
            return true;
        }
        return false;
    }

}
