<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\Meal;
use App\User;
use App\UserInfo;
use App\Helpers\MyFuncs;
use App\MealsItem;
use App\OrdersItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use Validator;
use DB;
use Hash;

class OrderController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */  
    public function create() {        
        $users = User::where('role','=','2')->where('status','=','1')->orderBy('username', 'asc')->get();
        
        /* Get today meals */
        $today = date("Y-m-d");
        $meal  = Meal::getMeal($today); 
    
        if(count($meal)==0)
        {   
            Session::flash('flash_message', 'Meals are not available for order today!!!');   
            Session::flash('alert-class', 'alert-danger');
            return redirect('/admin/orders');
        }    
            
        $meal->prepend('--Select Meal--', '');
        
        return view('admin.order.create', compact('users','meal'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        
        $data = $request->all();
        
        if($data['user_id'] == '-1'){
            $validator1 = Validator::make($data, User::rules());
            $validator2 = Validator::make($data, UserInfo::rules());
            if ($validator1->fails() and $validator2->fails()) {
                $errors = $validator1->errors(); 
                $errors->merge($validator2->errors());          
                return redirect()->back()->withInput()->withErrors($errors);
            }
        }
        
        $messages = [
            'user_id.required' => 'User required.',
            'meal_id.required' => 'Meal required.',            
        ];
                
        
        $validator = Validator::make($data, Order::rules(),$messages);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        
        if($data['user_id'] == '-1'){
            $location = $data['address'] . ', madurai, tamilnadu, india';

            $latlong = MyFuncs::lat_long($location);
            $map = explode(',', $latlong);
            $mapLat = $map[0];
            $mapLong = $map[1];

            $usermodel = new User;
            $usermodel->username = $data['username'];
            $usermodel->password = Hash::make($data['password']);
            $usermodel->email = $data['email'];
            $usermodel->status = 1;
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
            
            $data['user_id'] = $usermodel->id;
        }  
        $order = new Order;
        $order->user_id  = $data['user_id'];
        $order->meal_id  = $data['meal_id'];   
        $order->qty      = $data['qty'];   
        $order->subtotal = $data['subtotal'];
        $order->offer_price = $data['offer'];
        $order->grandtotal  = $data['grandtotal'];        
        $order->status   = $data['status'];
        $order->save();

       
        Session::flash('flash_message', 'Order created successfully!');
        return redirect('/admin/orders');
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
        $name = '';
        $order    = Order::find($id);     
        $items_res = MealsItem::where('meal_id','=',$order->meal_id)->get();
        foreach ($items_res as $item){
            $name .= $item->item->name.',';
        }        
        if($name != ''){
            $items = rtrim($name, ",");       
        }else{
            $items = 'No Item';
        }
        return view('admin.order.edit', compact('order','items'));
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
            'status' => 'required',
        ]);
               
        
        $order = Order::find($id);           
        $order->status = $data['status'];                
        $order->save();                
        Session::flash('flash_message', 'Order updated successfully!');
        return redirect('/admin/orders');
        
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
        // Delete order
        $order = Order::find($id);
        $order->delete();
        Session::flash('flash_message', 'Order deleted successfully!');        
        return redirect('/admin/orders');
    }
    
    public function price(){
        $id = $_GET['id'];  
        $qty = $_GET['qty'];
        $subtotal = 0;
        $offer = 0;
        $grandtotal = 0;
        $name = '';
        
        //Meals price
        $meals = Meal::where('meal_id','=',$id)->first();        
        $subtotal = $meals->price * $qty;
        
        //Meals Offer
        if($meals->offer_id != 0){
            $offer = $meals->offer->offer_price;
        }
        
        //Grandtotal
        $grandtotal = $subtotal - $offer;
        
        //Meal Items
        $items = MealsItem::where('meal_id','=',$id)->get();
        foreach ($items as $item){
            $name .= $item->item->name.',';
        }        
        if($name != ''){
            $result = rtrim($name, ",");       
        }else{
            $result = 'No Item';
        }
        
        
                
        echo $subtotal."++".$offer."++".$grandtotal."++".$result;
    }

}
