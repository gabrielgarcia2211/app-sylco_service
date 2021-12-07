<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        User::create([
            'username' => 'gabriel21',
            'name' => 'arturo',
            'password' => Hash::make('hola'),
            'email' => 'garciaquinteroga@gmail.com',
        ]);
    }

    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request){
        $this->validateLogin($request);
        return $this->sendLoginResponse($request);
    }

    protected function validateLogin(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
       
    }

    public function sendLoginResponse(Request $request){

        $user = User::where('email',$request['email'])->first();

        if(!is_null($user) && Hash::check( $request['password'] , $user->password )){
            return response()->json([
                'response' => true,
                'message' => 'Welcome'
            ]);
        }else{
            return response()->json([
                'response' => false,
                'message' => '¡data incorrect!'
            ]);
        }     

    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        $ingresoError= array();

        try{

            $user = Socialite::driver('google')->stateless()->user();
            $user = User::where('email',$user->email)->get();

            if(sizeof($user)==1){
                $this->guard()->login($user[0]);
                return redirect('/home');
            }
            array_push($ingresoError,"¡Correo Electronico no Registrado!");
            return view('auth.login')->with(compact('ingresoError'));


        } catch (\Exception $e) {

            array_push($ingresoError,"¡Ah ocurrido un error!");
            return view('auth.login')->with(compact('ingresoError'));

        }



    }

    public function logout(Request $request){
        $this->guard()->logout();
        return $this->loggedOut($request) ?: redirect('/');

    }
}
