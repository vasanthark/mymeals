<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Offer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use Input;
use DB;
use Validator;



class OfferController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $offers = Offer::all();
        return view('admin.offer.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */  
    public function create() {
        return view('admin.offer.create');
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
        $validator = Validator::make($data, Offer::rules());
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
       

        if (Input::file())
        {     
            $image_obj = Input::file('offer_image');
            print_r($image_obj);
            $destinationPath = public_path() . '/uploads/offer/'; // upload path
            $extension = $image_obj->getClientOriginalExtension(); // getting image extension
            $fileName  = rand(11111, 99999) . time() . '.' . $extension; // renameing image
            $image_obj->move($destinationPath, $fileName); // uploading file to given path
            
        }
        
        $offermodel = new Offer;
        $offermodel->offer_name = $data['offer_name'];
        $offermodel->offer_type = $data['offer_type'];
        $offermodel->offer_image = $fileName;
        $offermodel->offer_price = $data['offer_price'];
        $offermodel->status = $data['status'];
        $offermodel->save();
        
        Session::flash('flash_message', 'Offer created successfully!');
        return redirect('/admin/offers');
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
        $offer = Offer::find($id);
        $old_file = $offer->offer_image;
        return view('admin.offer.edit', compact('offer','old_file'));
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
                'offer_name' => 'required|unique:offers,offer_type,' . ($id ? "$id" : 'NULL') . ',offer_id',
                'offer_image' => 'Mimes:jpeg,png,gif',
                'offer_price' => 'required',
                'status' => 'required',
            ]);
        }else{
            $this->validate($request, [
                'offer_name' => 'required|unique:offers,offer_type,' . ($id ? "$id" : 'NULL') . ',offer_id',
                'offer_price' => 'required',
                'status' => 'required',
            ]);
        }
        
        $offermodel = Offer::find($id); 
         if (Input::file())
        {     
            $image_obj = Input::file('offer_image');
            print_r($image_obj);
            $destinationPath = public_path() . '/uploads/offer/'; // upload path
            $extension = $image_obj->getClientOriginalExtension(); // getting image extension
            $fileName  = rand(11111, 99999) . time() . '.' . $extension; // renameing image
            $image_obj->move($destinationPath, $fileName); // uploading file to given path
            
        }else{
            $fileName = $data['offer_image'];
        }
            
        $offermodel->offer_name = $data['offer_name'];
        $offermodel->offer_type = $data['offer_type'];
        $offermodel->offer_image = $fileName;
        $offermodel->offer_price = $data['offer_price'];
        $offermodel->status = $data['status'];
        $offermodel->save();
        
        Session::flash('flash_message', 'offer updated successfully!');
        return redirect('/admin/offers');
        
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
        // Delete offer
        $offer = Offer::find($id);
        $offer->delete();
        Session::flash('flash_message', 'Offer deleted successfully!');        
        return redirect('/admin/offers');
    }

}
