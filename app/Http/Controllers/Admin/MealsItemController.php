<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MealsItem;
use App\Meal;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use Validator;
use DB;

class MealsItemController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $mealsitems = MealsItem::all();
        return view('admin.mealsitem.index', compact('mealsitems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */  
    public function create() {
        $meal = Meal::getMeal();
        $item = Item::getItem();
        return view('admin.mealsitem.create', compact('meal','item'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, MealsItem::rules());
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        
        $meal = new MealsItem;
        $meal->timestamps = false;
        $meal->item_id = $data['item_id'];
        $meal->meal_id = $data['meal_id'];        
        $meal->save();
        
        Session::flash('flash_message', 'MealsItem created successfully!');
        return redirect('/admin/mealsitems');
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
        $mealsitem = MealsItem::find($id);
        $meal = Meal::getMeal();
        $item = Item::getItem();
        return view('admin.mealsitem.edit', compact('mealsitem','meal','item'));
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
        
        $validator = Validator::make($data, MealsItem::rules($id));
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        
        $meal = MealsItem::find($id);   
        $meal->timestamps = false;
        $meal->item_id = $data['item_id'];
        $meal->meal_id = $data['meal_id'];        
        $meal->save();
        
        Session::flash('flash_message', 'MealsItem updated successfully!');
        return redirect('/admin/mealsitems');
        
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
        // Delete meal
        $meal = MealsItem::find($id);
        $meal->delete();
        Session::flash('flash_message', 'meal deleted successfully!');        
        return redirect('/admin/mealsitems');
    }

}
