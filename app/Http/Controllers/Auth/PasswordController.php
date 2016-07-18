<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use Input;
use DB;
use Validator;
use Hash;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function getReset() {
        return view('auth.password');
    }

    public function postReset(Request $request){
        $data = Input::all();
        
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        );
         $validator = Validator::make($data, $rules);
         if(Input::get('email')){
            $user = User::where('email', '=', Input::get('email'))->count();         
            if($user == 0){
                   $validator->getMessageBag()->add('email', 'The old password is incorrect.');
                   return redirect()->back()->withInput()->withErrors($validator->errors());
            }
        }
         
        if ($validator->fails()) {
             return redirect()->back()->withInput()->withErrors($validator->errors());
             
        }else {
            
            $user = User::where('email', '=', Input::get('email'))->first(); 
            $user->password = Hash::make(Input::get('password'));
            $user->save();
            Session::flash('flash_message', 'password changed successfully!');
            return redirect('/auth/login');
        }
    }
}
