<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Profiles;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
         $user = new User;
        // $user->uid = $request->uid;
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->password = bcrypt($data['password']);
        $user->email = $data['email'];
        $user->ip = $_SERVER['REMOTE_ADDR'];
        $user->api_token = $user->generateToken();
        $user->api_id = $user->generateToken();
        $user->save();

        // create the user profile
        $prof = new Profiles;
        $prof->uid = $user->id;
        $prof->picture = 'img/profileM.png';
        $prof->save();


        return $user;
    }
    // /**
    //  * Create a new user instance after a valid registration.
    //  *
    //  * @param  array  $data
    //  * @return \App\User
    //  */
    //  protected function registered(Request $request)
    // {
    //     $user = new User;
    //     // $user->uid = $request->uid;
    //     $user->firstname = $request->firstname;
    //     $user->lastname = $request->lastname;
    //     $user->password = $request->password;
    //     $user->email = $request->email;
    //     $user->api_token = $user->generateToken();
    //     $user->save();

    //     return response()->json(['data' => $user->toArray()], 201);
    // }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function getAcc(Request $request)
    {
        $user = new User;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->api_token = $user->generateToken();
        $user->api_id = $user->generateToken();
        $user->save();

        return response()->json(['data' => $user->toArray()], 201);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
     protected function registeredBy(Request $request)
    {
        $user = new User;
        // $user->uid = $request->uid;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->password = $request->password;
        $user->email = $request->email;
        $user->api_token = $user->generateToken();
        $user->api_id = $user->generateToken();
        $user->save();

        return response()->json(['data' => $user->toArray()], 201);
    }
    

}
