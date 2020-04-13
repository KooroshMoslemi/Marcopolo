<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    //


    public function registerUser(Request $request)
    {
        $this->validate($request, [
            'name' 		=> 'required',
            'email'	 	=> 'required|email|unique:users|max:255',
            'password' => 'min:8|required_with:password_confirmation',
            'password_confirmation' => 'min:8|same:password'
        ]);
        return User::create([
            'password'   => bcrypt($request->password),
            'email'      => $request->email,
            'name'       => $request->name
        ]);

    }

    /* @POST
     */
    public function login(Request $request){

        $user = User::where('email', $request['email'])->first();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($user->is_active == 1) {
            if (\Auth::attempt([
                'email' => $request->email,
                'password' => $request->password])
            ) {
                return redirect('/');
            }
        }
        return redirect('/')->with('error', 'Invalid Credentials');
    }
    /* GET
    */
    public function logout(Request $request)
    {
        if(\Auth::check())
        {
            \Auth::logout();
            $request->session()->invalidate();
        }
        return  redirect('/');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                return redirect('/');

            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id
                ]);

                Auth::login($newUser);

                return redirect()->back();
            }

        } catch (Exception $e) {
            return redirect('auth/google');
        }
    }



}
