<?php
namespace App\Http\Controllers;
// use Symfony\Component\HttpFoundation\Response as Response2;

use App\User;
use App\UserInfo;
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
              'meassage'  => [],    
              'id' => [],
              'username'=> [],
            ];             
            if (Auth::attempt(array('username' => $username, 'password' => $password,'role'=>2, 'status'=>'1'))){
                $response = [
                  'meassage'  => 'success',    
                  'id' => Auth::id(),
                  'username'=> $username,
                ]; 
            }else{        
                $response = [
                    'meassage'  => 'wrong',    
                    'id' => '',
                    'username'=> $username,
                ]; 
            }
               
            $articlecounts = count($response['articles']);                 
          
        }catch (Exception $e){
            $statusCode = 400;
        }finally{          
            echo '<pre>';
            print_r($response);
            exit;
//            return response()->json([$response, $statusCode]);
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
              'meassage'  => [],    
              'errors' => [],
            ]; 
            
            $validator1 = Validator::make($data, User::rules());
            $validator2 = Validator::make($data, UserInfo::rules());
            
            if ( $validator1->fails() or $validator2->fails() ) {
                $errors = $validator1->errors(); 
                $errors->merge($validator2->errors());  
                 $response = [
                    'meassage'  => 'wrong',    
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
                    'meassage'  => 'success',    
                    'errors'=> 'null',
                ]; 
            }
                         
        }catch (Exception $e){
            $statusCode = 400;
        }finally{          
//            echo '<pre>';
//            print_r($response);
//            exit;
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
              'meassage'  => [],    
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
                    'meassage'  => 'wrong',    
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
                    'meassage'  => 'success',    
                    'errors'=> 'null',
                ]; 
            }
                         
        }catch (Exception $e){
            $statusCode = 400;
        }finally{          
//            echo '<pre>';
//            print_r($response);
//            exit;
            return response()->json([$response, $statusCode]);
        }   
    }
}
