<?php

namespace App\Http\Controllers\Auth;

use App\Profile;
use App\User;
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
            'name' => 'required|string|max:255',
            'plec' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $name = $data['name'];
        if ($data['plec'] == 'kobieta') {
            $pic_path = 'user_female.png';
            \Illuminate\Support\Facades\Storage::copy('public/user_female.png', 'public/'.$name.'/user_female.png');
        } else {
            $pic_path = 'user_male.png';
            \Illuminate\Support\Facades\Storage::copy('public/user_male.png', 'public/'.$name.'/user_male.png');            
        }
        $user = User::create([
            'name' => $data['name'],
            'plec' => $data['plec'],            
            'slug' => str_slug($data['name'],'-'),            
            'email' => $data['email'],
            'pic' => $pic_path,
            'password' => bcrypt($data['password']),
        ]);

        Profile::create(['user_id' => $user->id]);
        return $user;
    }


}
