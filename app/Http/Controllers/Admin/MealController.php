<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Meal;
use App\Item;
use App\Offer;
use App\MealsItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use Validator;
use DB;

class MealController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $meals = Meal::orderBy('meal_date', 'desc')->get();
        return view('admin.meal.index', compact('meals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */  
    public function create() {
        $offer = Offer::getOffer();
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
        
        $messages = [
            'item_id.required' => 'Items required.',
        ];
        
        $data['meal_date'] = date('Y-m-d', strtotime($data['meal_date']));
        
        $validator = Validator::make($data, Meal::rules(),$messages);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        
        $meal = new Meal;
        $meal->offer_id = $data['offer_id'];
        $meal->title = $data['title'];
        $meal->price = $data['price'];
        $meal->meal_date = date('Y-m-d', strtotime($data['meal_date']));
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
        $meal    = Meal::find($id);
        
        $results = MealsItem::where('meal_id', '=', $id)->get();
        foreach($results as $result){
            $mealsitems[] = $result['item_id'];
        }
                       
        $items = Item::orderBy('name', 'asc')->get();
        $offer = Offer::getOffer();
        $mealsdate = date('d-m-Y', strtotime($meal->meal_date));
        return view('admin.meal.edit', compact('meal','mealsdate','offer','mealsitems','items'));
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
        
        $data['meal_date'] = date('Y-m-d', strtotime($data['meal_date']));
        
        $validator = Validator::make($data, Meal::rules($id));
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        
        $meal = Meal::find($id);   
        $meal->offer_id = $data['offer_id'];
        $meal->title = $data['title'];
        $meal->price = $data['price'];
        $meal->meal_date = date('Y-m-d', strtotime($data['meal_date']));
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
        $meal = Meal::find($id);
        $meal->delete();
        Session::flash('flash_message', 'meal deleted successfully!');        
        return redirect('/admin/meals');
    }

}
