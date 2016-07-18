<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\User;
use App\Item;
use App\Offer;
use App\UserInfo;
use App\Helpers\MyFuncs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
//use Symfony\Component\HttpFoundation\Response as Response2;
use Session;
use Input;
use DB;
use Validator;
use Hash;

class DashboardController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $user_count = User::count();
        $item_count = Item::count();
        $offer_count = Offer::count();
        return view('admin.dashboard.index',compact('user_count','item_count','offer_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return Response2
     */
    public function getProfile() {
        $id = Auth::user()->getId();
        $user = User::find($id);
        $userinfo = UserInfo::where('user_id', '=', $id)->first();
        return view('admin.dashboard.profile', compact('user','userinfo'));
    }

    public function postProfile() {
        $location =Input::get('address').', madurai, tamilnadu, india';
        $latlong    =  MyFuncs::lat_long($location);
        $map        =  explode(',' ,$latlong);
        $mapLat     =  $map[0];
        $mapLong    =  $map[1];  
        
        $id = Auth::user()->getId();
        $user = User::find($id);
        $user->email = Input::get('email');
        $user->save();
        $userinfo = UserInfo::where('user_id', '=', $id)->first();
        $userinfo->timestamps = false;        
        $userinfo->first_name = Input::get('first_name');
        $userinfo->last_name = Input::get('last_name');
        $userinfo->phone = Input::get('phone');
        $userinfo->address = Input::get('address');
        $userinfo->latitude = $mapLat;
        $userinfo->longitude = $mapLong;
        $userinfo->save();
        return redirect('/admin/profile');
    }
    
    public function getChangepassword() {
        return view('admin.dashboard.changepassword');
    }

    public function postChangepassword(Request $request){
        $data = Input::all();
        
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required',
        );
         $validator = Validator::make($data, $rules);
         
        if(Input::get('old_password')){
            if (!Auth::validate(array('username' => Auth::user()->username, 'password' => Input::get('old_password')))) {
                $validator->getMessageBag()->add('password', 'The old password is incorrect.');
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }
        }
         
         if ($validator->fails()) {
             return redirect()->back()->withInput()->withErrors($validator->errors());
             
        }else {
            
             $user = User::find(Auth::user()->id);
             
            $user->password = Hash::make(Input::get('new_password'));
            $user->save();
             Session::flash('flash_message', 'password update successfully!');
            return redirect('/admin/changepassword');
        }
    }
    

}
