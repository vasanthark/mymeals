<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Meal;
use App\Offer;
use App\Day;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use Input;
use Validator;
use DB;

class DayController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //$meals = Meal::orderBy('meal_date', 'desc')->get();
        $days = Day::orderBy('day_id', 'asc')->get();
        return view('admin.day.index', compact('days'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $day   = Day::find($id);
        $old_file = $day->day_image;
        
        $meal  = Meal::getMeal(); 
        $meal->prepend('--Select Meal--', '');
        
        $offers  = Offer::getOffer(); 
        
        
        return view('admin.day.edit', compact('day','meal','offers','old_file'));
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
        
        $messages = [
            'meal_id.required' => 'Please select meal.',
        ]; 
        
        if(Input::file()){
            $this->validate($request, [
                'day_image' => 'Mimes:jpeg,png,gif',
                'meal_id' => 'required',
            ],$messages);
        }else{
            $this->validate($request, [
                'meal_id' => 'required',
            ],$messages);
        }
        
        $day = Day::find($id);           
        $day->meal_id  = $data['meal_id'];
        $day->offer_id = $data['offer_id'];  
        $day->price    = $data['price'];
        
        if (Input::file())
        {     
            $image_obj = Input::file('day_image');
            $destinationPath = public_path() . '/uploads/days/'; // upload path
            $extension = $image_obj->getClientOriginalExtension(); // getting image extension
            $fileName  = rand(11111, 99999) . time() . '.' . $extension; // renameing image
            $image_obj->move($destinationPath, $fileName); // uploading file to given path   
            $day->day_image   = $fileName;
        }
 
        $day->save();   
        
        Session::flash('flash_message', 'Infos updated successfully!');
        return redirect('/admin/days');
        
    }
}
