<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\Meal;
use App\User;
use App\Day;
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
    public function index(Request $request) {
        
        $search_infos = (isset($request))?$request->all():array();
        
        if(!empty($search_infos))
        {      
            $search_str = "1";
            if(isset($search_infos['order_username']) && $search_infos['order_username']!="")
             $search_str .= " AND (order_username LIKE '%".$search_infos['order_username']."%' )";
               
            if(isset($search_infos['meal_date']) && $search_infos['meal_date']!="")
            $search_str .= " AND meal_date='".$search_infos['meal_date']."' ";
            
            if(isset($search_infos['status']) && $search_infos['status']!="")
            $search_str .= " AND status='".$search_infos['status']."' "; 
                        
            $orders = Order::whereRaw($search_str)->orderBy('meal_date', 'desc')->get();
            
        }else{
            $orders = Order::orderBy('meal_date', 'desc')->get();
        }    
         
        
        return view('admin.order.index', compact('orders','search_infos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $users = User::where('role', '=', '2')->where('status', '=', '1')->orderBy('username', 'asc')->get();

        /* Get all days */
        $dayinfos = Day::where('status', '=', '1')->orderBy('day_id', 'asc')->get()->lists('name', 'day_id');

        return view('admin.order.create', compact('users', 'dayinfos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        $data = $request->all();
        
        if ($data['user_id'] == '-1') {
            $validator1 = Validator::make($data, User::rules());
            $validator2 = Validator::make($data, UserInfo::rules());
            if ($validator1->fails() and $validator2->fails()) {
                $errors = $validator1->errors();
                $errors->merge($validator2->errors());
                return redirect()->back()->withInput()->withErrors($errors);
            }
        }

        $messages = [
            'user_id.required' => 'Please choose any user.',
            'day_id.required'  => 'Please choose any day.',
            'meal_id.required' => 'Meal required.',
        ];
            
        $validator = Validator::make($data, Order::rules(), $messages);
        if ($validator->fails()) {           
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        if ($data['user_id'] == '-1') {
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
        
        if(!empty($data['day_id']))
        {    
            $days_id = $data['day_id'];
            $user_datas = UserInfo::where("user_id","=",$data['user_id'])->get()->first(); 
            $order_username = $user_datas->first_name." ".$user_datas->last_name;
            $order_phone    = $user_datas->phone;
            $order_address  = $user_datas->address;
            $order_lat_long = $user_datas->latitude."~".$user_datas->longitude;
            foreach($days_id as $dayid)
            {  
                $order = new Order;
                $order->user_id = $data['user_id'];
                $order->meal_id = $data['meal_id'][$dayid];
                $order->day_id  = $dayid;
                $order->qty     = $data['qty'][$dayid];
                $order->subtotal    = $data['subtotal'][$dayid];
                $order->offer_price = 0;
                $order->grandtotal  = $data['grandtotal'][$dayid];
                $order->status = 0;
                $order->meal_title = $data['meal_title'][$dayid];
                $order->meal_item  = $data['meal_item'][$dayid];
                $order->meal_date  = $data['meal_date'][$dayid];
                $order->order_username  = $order_username ;
                $order->order_phone     = $order_phone;
                $order->order_address   = $order_address;
                $order->order_lat_long  = $order_lat_long;
                $order->save();
            }    


            Session::flash('flash_message', 'Order created successfully!');
            return redirect('/admin/orders');
        }    
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
        $order = Order::find($id);        
        return view('admin.order.edit', compact('order'));
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
        
        $order = Order::find($id);
        $order->qty    = $data['qty'];
        $order->grandtotal    = $data['grandtotal'];
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

    public function price() {
        // Day id
        $id  = $_GET['id'];
        $qty = $_GET['qty'];
        $subtotal = 0;
        $offer = 0;
        $grandtotal = 0;
        $name = '';

        //Day model
        $days = Day::where('day_id', '=', $id)->first();
        $subtotal = $days->price * $qty;

//        //Meals Offer
//        if ($days->offer_id != 0) {
//            $offer = $days->offer->offer_price;
//        }

        //Grandtotal
        // $grandtotal = $subtotal - $offer;
     //   $grandtotal = $subtotal;

        //Meal Items
//        $items = MealsItem::where('meal_id', '=', $id)->get();
//        foreach ($items as $item) {
//            $name .= $item->item->name . ',';
//        }
//        if ($name != '') {
//            $result = rtrim($name, ",");
//        } else {
//            $result = 'No Item';
//        }

       // echo $subtotal . "++" . $offer . "++" . $grandtotal;
        
        $arr = array();
        $arr[0] = $subtotal;
        $arr[1] = $id;
        $arr[2] = $qty;

        echo json_encode($arr);
        exit();
    }

    public function mealdetails(Request $request) {
        $datainfos = array();
        $input = $request;
        if ($request->isMethod('post') && $request->ajax()) {
            $dayids = $input['day_ids'];
            $datainfos = Day::whereIn("day_id",$dayids)->get();
            
            $returnHTML = view('admin.order.mealdetail')->with('datainfos', $datainfos)->render();            
            return response()->json(array('success' => true, 'html' => $returnHTML));
        }
    }

}
