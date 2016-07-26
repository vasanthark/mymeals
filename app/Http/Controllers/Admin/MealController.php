<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Meal;
use App\Item;
use App\Offer;
use App\Day;
use App\MealsItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use Input;
use Validator;
use DB;

class MealController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //$meals = Meal::orderBy('meal_date', 'desc')->get();
        $meals = Meal::orderBy('meal_id', 'desc')->get();
        return view('admin.meal.index', compact('meals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */  
    public function create() {
        $items = Item::orderBy('name', 'asc')->get();
        return view('admin.meal.create', compact('offer','items'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        
        $data = $request->all();
        $fileName = '';
        
        $messages = [
            'item_id.required' => 'Items required.',
        ];      
        $validator = Validator::make($data, Meal::rules(),$messages);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        
        if (Input::file())
        {     
            $image_obj = Input::file('meal_image');
            $destinationPath = public_path() . '/uploads/meal/'; // upload path
            $extension = $image_obj->getClientOriginalExtension(); // getting image extension
            $fileName  = rand(11111, 99999) . time() . '.' . $extension; // renameing image
            $image_obj->move($destinationPath, $fileName); // uploading file to given path
            
        }
        
        $meal = new Meal;
        $meal->title = $data['title'];
        $meal->meal_image = $fileName;
        $meal->status = $data['status']; 
        $meal->save();
        $meal->item()->attach($data['item_id']);
        $meal->save();
       
        Session::flash('flash_message', 'Meal created successfully!');
        return redirect('/admin/meals');
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
        $mealsitems = array();
        $meal  = Meal::find($id);
        $old_file = $meal->meal_image;
        // All items
        $items = Item::orderBy('name', 'asc')->get();
        // Existing items
        $mealsitems = $meal->item()->lists("items.item_id")->toArray();
        
        return view('admin.meal.edit', compact('meal','mealsitems','items','old_file'));
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
       
        $fileName = '';
        if(Input::file()){
            $this->validate($request, [
                'title' => 'required', 
                'meal_image' => 'Mimes:jpeg,png,gif',
                'item_id' => 'required',
            ]);
        }else{
            $this->validate($request, [
                'title' => 'required', 
                'item_id' => 'required',
            ]);
        }
//        $validator = Validator::make($data, Meal::rules($id));
//        if ($validator->fails()) {
//            return redirect()->back()->withInput()->withErrors($validator->errors());
//        }
        $meal = Meal::find($id);
         if (Input::file())
        {     
            $image_obj = Input::file('meal_image');
            $destinationPath = public_path() . '/uploads/meal/'; // upload path
            $extension = $image_obj->getClientOriginalExtension(); // getting image extension
            $fileName  = rand(11111, 99999) . time() . '.' . $extension; // renameing image
            $image_obj->move($destinationPath, $fileName); // uploading file to given path
            
        }else{
            $fileName = $data['meal_image'];
        }
        
        $meal->title = $data['title'];
        $meal->meal_image = $fileName;
        $meal->status = $data['status'];  
        $meal->item()->sync($data['item_id']);        
        $meal->save();   
        
        Session::flash('flash_message', 'meal updated successfully!');
        return redirect('/admin/meals');
        
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
        // Delete meal
        $days_exist = Day::where(['meal_id' => $id])->get();
        if(count($days_exist) > 0)
        {
            $numItems = count($days_exist);
            $i = 0;
            $days = '';
            foreach($days_exist as $key=>$value) {
              if(++$i === $numItems) {
                $days .= $value->name;
              }else{
                $days .= $value->name.',';
              }
            }    
            Session::flash('flash_message', 'This meal is assigned on "'.$days.'" .So you cant delete this meal!!!'); 
            Session::flash('alert-class', 'alert-danger');
            return redirect('/admin/meals/');
        }
        $meal = Meal::find($id);
        $meal->delete();
        Session::flash('flash_message', 'meal deleted successfully!');        
        return redirect('/admin/meals');
    }

}
