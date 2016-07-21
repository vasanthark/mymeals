<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Meal;
use App\Offer;
use App\Day;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
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
        
        $meal  = Meal::getMeal(); 
        $meal->prepend('--Select Meal--', '');
        
        $offers  = Offer::getOffer(); 
        
        
        return view('admin.day.edit', compact('day','meal','offers'));
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
        $validator = Validator::make($data, Day::rules($id),$messages);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        
        $day = Day::find($id);           
        $day->meal_id  = $data['meal_id'];
        $day->offer_id = $data['offer_id'];  
        $day->price    = $data['price'];
        $day->save();   
        
        Session::flash('flash_message', 'Infos updated successfully!');
        return redirect('/admin/days');
        
    }
}
