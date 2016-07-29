<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Item;
use App\ItemType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use Input;
use Validator;
use DB;

class ItemController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $items = Item::orderBy('item_id', 'desc')->get();
        return view('admin.item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */  
    public function create() {
        $itemtypes = ItemType::getItemTypes();
        $itemtypes->prepend('--Select Item Type--', '');
        return view('admin.item.create', compact('itemtypes'));
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
            'item_type_id.required' => 'Item Type required.',
            'name.required' => 'Item name required.',
            'item_image.required' => 'Item image required.',
        ];  
         
        $validator = Validator::make($data, Item::rules(),$messages);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        
        if (Input::file())
        {     
            $image_obj = Input::file('item_image');
            $destinationPath = public_path() . '/uploads/items/'; // upload path
            $extension = $image_obj->getClientOriginalExtension(); // getting image extension
            $fileName  = rand(11111, 99999) . time() . '.' . $extension; // renameing image
            $image_obj->move($destinationPath, $fileName); // uploading file to given path
            
        }
        
        $adsmodel = new Item;
        $adsmodel->name = $data['name'];
        $adsmodel->item_image = $fileName;
        $adsmodel->item_type_id = $data['item_type_id'];
        $adsmodel->save();
        
        Session::flash('flash_message', 'Item created successfully!');
        return redirect('/admin/items');
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
        
        $itemtypes = ItemType::getItemTypes();
        $itemtypes->prepend('--Select Item Type--', '');
        
        $item = Item::find($id);
        $old_file = $item->item_image;
        return view('admin.item.edit', compact('item','itemtypes','old_file'));
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
            'item_type_id.required' => 'Item Type required.',
            'name.required' => 'Item name required.',
        ];  
         
        $validator = Validator::make($data, Item::rules($id),$messages);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        
         $item = Item::find($id);    
        if (Input::file())
        {     
            $image_obj = Input::file('item_image');
            $destinationPath = public_path() . '/uploads/items/'; // upload path
            $extension = $image_obj->getClientOriginalExtension(); // getting image extension
            $fileName  = rand(11111, 99999) . time() . '.' . $extension; // renameing image
            $image_obj->move($destinationPath, $fileName); // uploading file to given path
            $item->item_image = $fileName; 
        }
        
        $item->update($data);
        
        Session::flash('flash_message', 'item updated successfully!');
        return redirect('/admin/items');
        
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
        // Delete item
        $item = Item::find($id);
        $item->delete();
        Session::flash('flash_message', 'item deleted successfully!');        
        return redirect('/admin/items');
    }

}
