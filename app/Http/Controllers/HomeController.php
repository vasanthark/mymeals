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
                $items_list = array();
                $days_img = array();
                
                $days = Day::where('name','=',$day)->orderBy('day_id', 'asc')->first();
                $item_ids = $days->meal->item()->orderBy('item_type_id', 'asc')->lists("items.item_id");
                $j=0;
                for($i=0;$i<7;$i++){
                   $select_day = date('l', strtotime("+".$i." day"));
                   $dayimage = Day::where('name','=',$select_day)->orderBy('day_id', 'asc')->first();
                   $days_img[$i]['image'] = $dayimage->day_image;
                }
                foreach($item_ids as $item_id){
                    $item = Item::find($item_id);
                    $items_list[$j]['name']=$item->name;
                    $items_list[$j]['image']=$item->item_image;
                    $items_list[$j]['type_id']=$item->item_type_id;
                    $items_list[$j]['type_name']=$item->itemType->type_name;
                    
//                    $items_list[$item->itemType->type_name][$i]['name'] = $item->name;
//                    $items_list[$item->itemType->type_name][$i]['image'] = $item->item_image;
                    ++$j;
                 }
                 
                 $response[$days->name][] = [
                    'day_id'  => $days->day_id,
                    'day'  => $days->name,    
                    'day_image' => $days_img,
                    'meal_id' => $days->meal_id, 
                    'meal_name'=> $days->meal->title,
                    'meal_image'=> $days->meal->meal_image,
                    'meal_date'=> date('Y-m-d', strtotime($day)),
                     'items' => $items_list,
//                    'items' => implode(", ",$days->meal->item()->lists("items.name")->toArray()),
                    'price'=> $days->price,
                ];
            }  else {
                $items_list = array();
                for($i=0;$i<7;$i++){
                    $day = date('l', strtotime("+".$i." day"));
                 $days = Day::where('name','=',$day)->orderBy('day_id', 'asc')->first();
                 $item_ids = $days->meal->item()->orderBy('item_type_id', 'asc')->lists("items.item_id");
                  $j=0;
                 foreach($item_ids as $item_id){
                    $item = Item::find($item_id);
                   $items_list[$j]['name']=$item->name;
                    $items_list[$j]['image']=$item->item_image;
                    $items_list[$j]['type_id']=$item->item_type_id;
                    $items_list[$j]['type_name']=$item->itemType->type_name;
                    ++$j;
                 }
                    $response[$days->name][] = [
                       'day_id'  => $days->day_id,
                       'day'  => $days->name,    
                       'day_image' => $days->day_image,
                       'meal_id' => $days->meal_id, 
                       'meal_image'=> $days->meal->meal_image,
                       'meal_name'=> $days->meal->title,
                       'meal_date'=> date('Y-m-d', strtotime("+".$j." day")),
                       'items' => $items_list,
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
    public function order($userid, $dayid, $mealid, $mealdate){
            $today = date('Y-m-d');
        try{            
            $statusCode = 200;
            
            if($dayid != 'null' && $mealid != 'null' && $mealdate != 'null'){
                $day = Day::where('day_id','=',$dayid)->first();
                $check_old = TempOrder::where('user_id','=',$userid)
                            ->where('day_id','=',$dayid)
                            ->where('meal_id','=',$mealid)
                            ->where('meal_date','=',$mealdate)                            
//                            ->where('updated_at','>',$today)                            
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
                    $temporeder_new = new TempOrder;
                    $temporeder_new->user_id = $userid;
                    $temporeder_new->day_id = $dayid;
                    $temporeder_new->meal_id  = $mealid;
                    $temporeder_new->meal_date  = $mealdate;
                    $temporeder_new->qty  = 1;
                    $temporeder_new->subtotal = $day->price;
                    $temporeder_new->offer_price = 0;
                    $temporeder_new->grandtotal = $day->price;
                    $temporeder_new->save();
                }
            }
            $total_cost = 0;
            $discount = 0;
            $total_payable = 0;
            $temporeders = TempOrder::where('user_id','=',$userid)->where('meal_date','>=',$today)->orderBy('temporder_id', 'asc')->get();            
            if($temporeders->isEmpty()){
                $response = [
                       'message'  => 'wrong',  
                    ];
            }else{
                $response = [
                       'message'  => 'success',  
                    ];
                foreach ($temporeders as $oreder){
                    $response['cart_page'][] = [
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
                    $total_cost += $oreder->grandtotal;
                    $discount += $oreder->offer_price;
                    
                }
                $total_payable = $total_cost + $discount;
                $response['cart_total'][]= [
                    'total_cost' => $total_cost,
                    'discount' => $discount,
                    'total_payable' => $total_payable,
                ];
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
            
            $today = date('Y-m-d');
            $temporeders = TempOrder::where('user_id','=',$userid)
                            ->where('day_id','=',$dayid)
                            ->where('meal_id','=',$mealid)
                            ->where('meal_date','=',$mealdate)                            
//                            ->where('updated_at','>',$today)
                            ->first();

            if($temporeders){
                $temporeders->delete();
                $total_cost = 0;
                $discount = 0;
                $total_payable = 0;
                $temporeders_new = TempOrder::where('user_id','=',$userid)->where('meal_date','>=',$today)->orderBy('temporder_id', 'asc')->get();            
                if($temporeders_new->isEmpty()){
                    $response = [
                           'message'  => 'wrong',  
                        ];
                }else{
                    $response = [
                       'message'  => 'success',  
                    ];
                    foreach ($temporeders_new as $oreder){
                        $response['cart_page'][] = [
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
                        $total_cost += $oreder->grandtotal;
                        $discount += $oreder->offer_price;

                    }
                    $total_payable = $total_cost + $discount;
                    $response['cart_total'][]= [
                        'total_cost' => $total_cost,
                        'discount' => $discount,
                        'total_payable' => $total_payable,
                    ];
                }
                
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
         
        try{            
            $statusCode = 200;
            
            $today = date('Y-m-d');
            $temporeders = TempOrder::where('user_id','=',$userid)
                            ->where('day_id','=',$dayid)
                            ->where('meal_id','=',$mealid)
                            ->where('meal_date','=',$mealdate)                            
//                            ->where('updated_at','>',$today)
                            ->first();
            
            if($temporeders){
                $temporeders->qty = $qty;
                $temporeders->grandtotal = $subtotal * $qty;
                $temporeders->save();
                    $response = [
                       'message'  => 'success',  
                    ];
                $total_cost = 0;
                $discount = 0;
                $total_payable = 0;
                $temporeders_new = TempOrder::where('user_id','=',$userid)->where('meal_date','>=',$today)->orderBy('temporder_id', 'asc')->get();            
                
                    foreach ($temporeders_new as $oreder){
                        $response['cart_page'][] = [
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
                        $total_cost += $oreder->grandtotal;
                        $discount += $oreder->offer_price;

                    }
                $total_payable = $total_cost + $discount;
                $response['cart_total'][]= [
                    'total_cost' => $total_cost,
                    'discount' => $discount,
                    'total_payable' => $total_payable,
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
            
            $today = date('Y-m-d');
            $temporeders = TempOrder::where('user_id','=',$userid)
                            ->where('meal_date','>=',$today)
                            ->get();
            
            if($temporeders->isEmpty()){
                $response = [
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
                $response = [
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
