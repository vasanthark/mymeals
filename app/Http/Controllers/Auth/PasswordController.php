<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Session;
use Input;
use DB;
use Validator;
use Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller {
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
    public function __construct(Guard $auth, PasswordBroker $passwords) {
        $this->auth = $auth;
        $this->passwords = $passwords;
        $this->middleware('guest');
    }

    public function getEmail() {
        return view('auth.password');
    }

    public function postEmail(Request $request) {
        $this->validate($request, ['email' => 'required']);

        $response = $this->passwords->sendResetLink($request->only('email'), function($message) {
            $message->subject('Password Reminder Reset Link');
        });

        switch ($response) {
            case PasswordBroker::RESET_LINK_SENT:
                Session::flash('flash_message', trans($response));
                return redirect()->back()->with('status', trans($response));

            case PasswordBroker::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }

    public function getReset($token = null) {
        if (is_null($token))
            App::abort(404);

        return View::make('auth.reset')->with('token', $token);
    }

    public function postReset(Request $request) {

        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $credentials = $request->only(
                'email', 'password', 'password_confirmation', 'token'
        );

        $response = $this->passwords->reset($credentials, function($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        switch ($response) {
            case PasswordBroker::INVALID_PASSWORD:
            case PasswordBroker::INVALID_TOKEN:
            case PasswordBroker::INVALID_USER:
                return redirect()->back()->withErrors(['error' => trans($response)]);

            case PasswordBroker::PASSWORD_RESET:
                Session::flash('flash_message', trans($response));
                return redirect('/auth/login');
        }
    }

//    public function postReset(Request $request) {
//        $data = Input::all();
//
//        $rules = array(
//            'email' => 'required|email',
//            'password' => 'required|confirmed',
//            'password_confirmation' => 'required',
//        );
//        $validator = Validator::make($data, $rules);
//        if (Input::get('email')) {
//            $user = User::where('email', '=', Input::get('email'))->count();
//            if ($user == 0) {
//                $validator->getMessageBag()->add('email', 'The old password is incorrect.');
//                return redirect()->back()->withInput()->withErrors($validator->errors());
//            }
//        }
//
//        if ($validator->fails()) {
//            return redirect()->back()->withInput()->withErrors($validator->errors());
//        } else {
//
//            $user = User::where('email', '=', Input::get('email'))->first();
//            $user->password = Hash::make(Input::get('password'));
//            $user->save();
//            Session::flash('flash_message', 'password changed successfully!');
//            return redirect('/auth/login');
//        }
//    }
}
