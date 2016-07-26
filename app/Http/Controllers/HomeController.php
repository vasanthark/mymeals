<?php
namespace App\Http\Controllers;
// use Symfony\Component\HttpFoundation\Response as Response2;

use App\User;
use App\UserInfo;
use App\Meal;
use App\Item;
use App\Offer;
use App\Day;
use App\Order;
use App\TempOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SebastianBergmann\RecursionContext\Exception;
use Illuminate\Routing\ResponseFactory;
use App\Helpers\MyFuncs;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */    
    
    public function login($username,$password)
    {                             
         try{            
            $statusCode = 200;
            $response = [
              'message'  => [],    
              'id' => [],
              'username'=> [],
            ];             
            if (Auth::attempt(array('username' => $username, 'password' => $password,'role'=>2, 'status'=>'1'))){
                $response = [
                  'message'  => 'success',    
                  'id' => Auth::id(),
                  'username'=> $username,
                ]; 
            }else{        
                $response = [
                    'message'  => 'wrong',    
                    'id' => '',
                    'username'=> $username,
                ]; 
            }
                         
        }catch (Exception $e){
            $statusCode = 400;
        }finally{          
            return response()->json([$response, $statusCode]);
        }   
    } 
     public function mealdays($day)
    {             
         
         try{            
            $statusCode = 200;
            $response = array();     
            $i = 0;
            if($day != 'null'){
                $days = Day::where('name','=',$day)->orderBy('day_id', 'asc')->first();
                 $response[$days->name][] = [
                    'day_id'  => $days->day_id,
                    'day'  => $days->name,    
                    'meal_id' => $days->meal_id, 
                    'meal_name'=> $days->meal->title,
                    'meal_image'=> $days->meal->meal_image,
                    'meal_date'=> date('Y-m-d', strtotime($day)),
                    'items' => $days->meal->item()->lists("items.name")->toArray(),
                    'price'=> $days->price,
                ];
            }  else {
                for($i=0;$i<7;$i++){
                    $day = date('l', strtotime("+".$i." day"));
                 $days = Day::where('name','=',$day)->orderBy('day_id', 'asc')->first();
                    $response[$days->name][] = [
                       'day_id'  => $days->day_id,
                       'day'  => $days->name,    
                       'meal_id' => $days->meal_id, 
                       'meal_image'=> $days->meal->meal_image,
                       'meal_name'=> $days->meal->title,
                       'meal_date'=> date('Y-m-d', strtotime("+".$i." day")),
                       'items' => $days->meal->item()->lists("items.name")->toArray(),
                       'price'=> $days->price,
                   ];
                }
            }
            
        }catch (Exception $e){
            $statusCode = 400;
        }finally{          
            return response()->json([$response, $statusCode]);
        }   
    } 
    public function oreder($userid, $dayid, $mealid, $mealdate){
            $today = date('Y-m-d').' 00:00:00';
            
        try{            
            $statusCode = 200;
            
            if($dayid != 'null' && $mealid != 'null' && $mealdate != 'null'){
                $day = Day::where('day_id','=',$dayid)->first();
                $check_old = TempOrder::where('user_id','=',$userid)
                            ->where('day_id','=',$dayid)
                            ->where('meal_id','=',$mealid)
                            ->where('meal_date','=',$mealdate)                            
                            ->where('updated_at','>',$today)
                            ->first();
                if($check_old){
                    $check_old->user_id = $userid;
                    $check_old->day_id = $dayid;
                    $check_old->meal_id  = $mealid;
                    $check_old->meal_date  = $mealdate;
                    $check_old->qty  = 1;
                    $check_old->subtotal = $day->price;
                    $check_old->offer_price = 0;
                    $check_old->grandtotal = $day->price;
                    $check_old->save();
                }else{
                    $temporeder = new TempOrder;
                    $temporeder->user_id = $userid;
                    $temporeder->day_id = $dayid;
                    $temporeder->meal_id  = $mealid;
                    $temporeder->meal_date  = $mealdate;
                    $temporeder->qty  = 1;
                    $temporeder->subtotal = $day->price;
                    $temporeder->offer_price = 0;
                    $temporeder->grandtotal = $day->price;
                    $temporeder->save();
                }
            }
            
            $temporeders = TempOrder::where('user_id','=',$userid)->where('updated_at','>',$today)->orderBy('temporder_id', 'asc')->get();            
            if($temporeders->isEmpty()){
                $response[] = [
                    'user_id'  => $userid, 
                    'day_id' => $dayid,
                    'meal_id' => $mealid,
                    'meal_name' => '',
                    'meal_date' => $mealdate,
                    'qty' => '0',
                    'subtotal' => '0',
                    'offer_price' => '0',
                    'grandtotal' => '0',
                    
                ]; 
            }else{
                foreach ($temporeders as $oreder){
                    $response[$oreder->temporder_id] = [
                        'user_id'  => $oreder->user_id, 
                        'day_id' => $oreder->day_id,
                        'meal_id' => $oreder->meal_id,
                        'meal_name' => $oreder->meal->title,
                        'meal_date' => $oreder->meal_date,
                        'qty' => $oreder->qty,
                        'subtotal' => $oreder->subtotal,
                        'offer_price' => $oreder->offer_price,
                        'grandtotal' => $oreder->grandtotal,
                    ];
                }
            }
                         
        }catch (Exception $e){
            $statusCode = 400;
        }finally{    
            return response()->json([$response, $statusCode]);
        }   
    }
    public function deleteorder($userid, $dayid, $mealid, $mealdate){
         
        try{            
            $statusCode = 200;
            
            $today = date('Y-m-d').' 00:00:00';
            $temporeders = TempOrder::where('user_id','=',$userid)
                            ->where('day_id','=',$dayid)
                            ->where('meal_id','=',$mealid)
                            ->where('meal_date','=',$mealdate)                            
                            ->where('updated_at','>',$today)
                            ->first();
            
            if($temporeders->delete()){
                $response = [
                    'message'  => 'success',   
                ]; 
            }else{
                $response = [
                    'message'  => 'wrong',   
                ]; 
            }
        }catch (Exception $e){
            $statusCode = 400;
        }finally{    
            return response()->json([$response, $statusCode]);
        }   
    }
    
     public function updateqty($userid, $dayid, $mealid, $mealdate, $qty, $subtotal){
//        $data = array();
//        $data['userid'] =  ($userid != 'null')? $userid : '';
//        $data['dayid'] = ($dayid != 'null')? $dayid : '';
//        $data['mealid'] = ($mealid != 'null')? $mealid : '';
//        $data['mealdate'] = ($mealdate != 'null')? $mealdate : '';
         
        try{            
            $statusCode = 200;
            
            $today = date('Y-m-d').' 00:00:00';
            $temporeders = TempOrder::where('user_id','=',$userid)
                            ->where('day_id','=',$dayid)
                            ->where('meal_id','=',$mealid)
                            ->where('meal_date','=',$mealdate)                            
                            ->where('updated_at','>',$today)
                            ->first();
            
            if($temporeders){
                $temporeders->qty = $qty;
                $temporeders->grandtotal = $subtotal * $qty;
                $temporeders->save();
                    $response[$temporeders->temporder_id] = [
                       'message'  => 'success',  
                    ];
                
            }else{
                $response = [
                     'message'  => 'wrong',   
                ]; 
            }
                         
        }catch (Exception $e){
            $statusCode = 400;
        }finally{    
            return response()->json([$response, $statusCode]);
        }   
    }
    
    public function checkout($userid){
         
        try{            
            $statusCode = 200;
            
            $today = date('Y-m-d').' 00:00:00';
            $temporeders = TempOrder::where('user_id','=',$userid)
                            ->where('updated_at','>',$today)
                            ->get();
            
            if($temporeders->isEmpty()){
                $response[$userid] = [
                    'message'  => 'wrong',
                ]; 
            }else{
                foreach ($temporeders as $temp){
                    $order = new Order;
                $order->user_id = $temp->user_id;
                $order->meal_id = $temp->meal_id;
                $order->day_id  = $temp->day_id;
                $order->qty     = $temp->qty;
                $order->subtotal    = $temp->subtotal;
                $order->offer_price = $temp->offer_price;
                $order->grandtotal  = $temp->grandtotal;
                $order->status = 0;
                $order->meal_title = $temp->meal->title;
                $order->meal_item  = implode(" , ",$temp->meal->item()->lists("items.name")->toArray());
                $order->meal_date  = $temp->meal_date;
                $order->order_username  = $temp->user->username ;
                $order->order_phone     = $temp->user->userInfo->phone;
                $order->order_address   = $temp->user->userInfo->address;
                $order->order_lat_long  = $temp->user->userInfo->latitude."~".$temp->user->userInfo->longitude;
                $order->save();
                $temp->delete();
                }
                $response[$userid] = [
                        'message'  => 'success',  
                    ];
            }
            
        }catch (Exception $e){
            $statusCode = 400;
        }finally{    
            return response()->json([$response, $statusCode]);
        }   
    }
    public function registration($fname, $lname, $uname, $pwd, $email, $address, $phone){
        $data = array();
        $data['first_name'] =  ($fname != 'null')? $fname : '';
        $data['last_name'] = ($lname != 'null')? $lname : '';
        $data['username'] = ($uname != 'null')? $uname : '';
        $data['password'] = ($pwd != 'null')? $pwd : '';
        $data['email'] = ($email != 'null')? $email : '';
        $data['address'] = ($address != 'null')? $address : '';
        $data['phone'] = ($phone != 'null')? $phone : '';
        $data['status'] = 1;
        $data['latitude'] = '';
        $data['longitude'] = '';      
            
        try{            
            $statusCode = 200;
            
            $response = [
              'message'  => [], 
              'id' => [],
              'errors' => [],
            ]; 
            
            $validator1 = Validator::make($data, User::rules());
            $validator2 = Validator::make($data, UserInfo::rules());
            
            if ( $validator1->fails() or $validator2->fails() ) {
                $errors = $validator1->errors(); 
                $errors->merge($validator2->errors());  
                 $response = [
                    'message'  => 'wrong',
                    'id' => 0,
                    'errors'=> $errors,
                ]; 
            }else{
                $mapLat = '';
                $mapLong = '';
                if($data['address'] != ''){
                    $location = $data['address'] . ', madurai, tamilnadu, india';

                    $latlong = MyFuncs::lat_long($location);
                    $map = explode(',', $latlong);
                    $mapLat = $map[0];
                    $mapLong = $map[1];
                }
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
                
                $response = [
                    'message'  => 'success', 
                    'id' => $usermodel->id,
                    'errors'=> 'null',
                ]; 
            }
                         
        }catch (Exception $e){
            $statusCode = 400;
        }finally{          
            return response()->json([$response, $statusCode]);
        }   
    }
        
    
    public function guest($uname, $email, $address, $phone){
        $data = array();
        $data['first_name'] =  '';
        $data['last_name'] = '';
        $data['username'] = ($uname != 'null')? $uname : '';
        $data['password'] = MyFuncs::getRandomString(9);
        $data['email'] = ($email != 'null')? $email : '';
        $data['address'] =  ($address != 'null')? $address : '';
        $data['phone'] = ($phone != 'null')? $phone : '';
        $data['status'] = 1;
        $data['latitude'] = '';
        $data['longitude'] = '';      
            
        try{            
            $statusCode = 200;
            
            $response = [
              'message'  => [],   
              'id' =>[],
              'errors' => [],
            ];             
            
            $validator = Validator::make($data, [
                'email'    => 'required|email',
                'username' => 'required',           
                'address' => 'required',
                'phone' => 'required',
            ]);
            if ( $validator->fails()) {
                 $response = [
                    'message'  => 'wrong',  
                    'id' => 0,
                    'errors'=> $validator->errors(),
                ]; 
            }else{
                $mapLat = '';
                $mapLong = '';
                if($data['address'] != ''){
                    $location = $data['address'] . ', madurai, tamilnadu, india';

                    $latlong = MyFuncs::lat_long($location);
                    $map = explode(',', $latlong);
                    $mapLat = $map[0];
                    $mapLong = $map[1];
                }
                
                $usermodel = new User;
                $usermodel->username = $data['username'];
                $usermodel->password = Hash::make($data['password']);
                $usermodel->email = $data['email'];
                $usermodel->role = 3;
                $usermodel->status = $data['status'];
                $usermodel->save();

                $userinfo = new UserInfo;
                $userinfo->timestamps = false;
                $userinfo->user_id = $usermodel->id;
                $userinfo->first_name = $data['username'];
                $userinfo->last_name = $data['last_name'];
                $userinfo->phone = $data['phone'];
                $userinfo->address = $data['address'];
                $userinfo->latitude = $mapLat;
                $userinfo->longitude = $mapLong;
                $userinfo->save();
                
                $response = [
                    'message'  => 'success',  
                    'id' => $usermodel->id,
                    'errors'=> 'null',
                ]; 
            }
                         
        }catch (Exception $e){
            $statusCode = 400;
        }finally{          
            return response()->json([$response, $statusCode]);
        }   
    }
}
