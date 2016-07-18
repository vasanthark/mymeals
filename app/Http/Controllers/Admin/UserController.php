<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\UserInfo;
use App\Helpers\MyFuncs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use Input;
use DB;
use Validator;
use Hash;


class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */  
    public function create() {
        return view('admin.user.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        
        
        $validator1 = Validator::make($data, User::rules());
        $validator2 = Validator::make($data, UserInfo::rules());
        if ($validator1->fails()) {
            return redirect()->back()->withInput()->withErrors($validator1->errors());
        }
        if ($validator2->fails()) {
            return redirect()->back()->withInput()->withErrors($validator2->errors());
        }
        $location =$data['address'].', madurai, tamilnadu, india';
        $latlong    =  MyFuncs::lat_long($location);
        $map        =  explode(',' ,$latlong);
        $mapLat     =  $map[0];
        $mapLong    =  $map[1];        
        
        $usermodel = new User;
        $usermodel->username = $data['username'];
        $usermodel->password = Hash::make($data['password']);
        $usermodel->email = $data['email'];
        $usermodel->status = $data['status'];        
        $usermodel->save();
        
        $userinfo = new UserInfo;
        $userinfo->timestamps = false;  
        $userinfo->user_id = $usermodel->id;
        $userinfo->first_name = $data['first_name'];
        $userinfo->last_name = $data['last_name'];
        $userinfo->phone = $data['phone'];
        $userinfo->address = $data['address'];
        $userinfo->latitude = $mapLat;
        $userinfo->longitude = $mapLong;
        $userinfo->save();
        
        
        Session::flash('flash_message', 'User created successfully!');
        return redirect('/admin/users');
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
        $user = User::find($id);
        $userinfo = UserInfo::where('user_id', '=', $id)->first();
        return view('admin.user.edit', compact('user','userinfo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id) {
        $data = $request->except(['_method', '_token']);
        
            $this->validate($request, [
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'phone' => 'numeric',
            ]);
        
       $location =$data['address'].', madurai, tamilnadu, india';
        $latlong    =  MyFuncs::lat_long($location);
        $map        =  explode(',' ,$latlong);
        $mapLat     =  $map[0];
        $mapLong    =  $map[1];        
        
        $usermodel = User::find($id);
        $usermodel->email = $data['email'];
        $usermodel->status = $data['status'];        
        $usermodel->save();
        
        $userinfo = UserInfo::where('user_id', '=', $id)->first();
        $userinfo->timestamps = false;  
        $userinfo->user_id = $id;
        $userinfo->first_name = $data['first_name'];
        $userinfo->last_name = $data['last_name'];
        $userinfo->phone = $data['phone'];
        $userinfo->address = $data['address'];
        $userinfo->latitude = $mapLat;
        $userinfo->longitude = $mapLong;
        $userinfo->save();
        
        Session::flash('flash_message', 'user updated successfully!');
        return redirect('/admin/users');
        
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
        // Delete user
        $user = User::find($id);        
        $userinfo = UserInfo::where('user_id', '=', $id)->first();
        $user->delete();
        $userinfo->delete();
        Session::flash('flash_message', 'User deleted successfully!');        
        return redirect('/admin/users');
    }

}
