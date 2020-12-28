<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Offer;
use App\CustomerGroup;
use App\OfferGroupMap;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $status;
    private $file_upload_path;

    public function __construct(){
        $this -> status = \Config::get('constants.rec_status');
        $this -> file_upload_path = \Config::get('constants.banner_upload');
    }

    public function index(Request $request)
    {
        //
        $key = $request->k;
        $per_page = \Config::get('constants.pagination_count');
        
        $offers = new Offer;
        
        if (!$key) 
            $offers_items = $offers->where('status', $this -> status)
            ->orderBy('created_at', 'desc')
            ->paginate($per_page);
        else
            $offers_items = $offers->where('status', $this -> status)
            ->where('name','LIKE', "%$key%")
            ->orderBy('created_at', 'desc')
            ->paginate($per_page);
        return view('offers.index', compact('offers_items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $offer = new Offer;
        $customer_group = CustomerGroup::where('status',  $this -> status)->get();
        return view('offers.create',compact('customer_group', 'offer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $this->validate($request, [
            "name" => "required|max:255|unique:offers",
            "offer_groups" => "required",
            "banner" => "required|mimes:jpeg,jpg,png|max:10000",  // max 10000kb
            "offer_status" => "required",
        ],[
            'name.required' => 'Offer name is required',
            'offer_groups.required' => 'Offer Group is required',
            'banner.required' => 'Banner image is required',
            'offer_status.required' => 'Offer status is required',
        ]);


        try {
            $banner_file_path = $request->file('banner')->store($this -> file_upload_path);
            $banner_file_name = basename($banner_file_path);
    
            $offers = new Offer;
    
            $offers-> name = $request-> name;
            $offers-> description = ($request-> description) ? $request-> description : '' ;
            $offers-> banner_image = $banner_file_name;
            $offers-> validity = $request -> offer_status;
            $offers-> status = $this -> status;
    
            $offers-> save();

            $offer_id = $offers -> id;

            /**
                * add multiple groups to this offer
            */
            $this -> offer_group_map($request -> offer_groups, $offer_id);
    

        } catch (\Exception  $e) {
            $request->session()->flash('info', "Error occure on adding Offer, try later!");
            return back();
        }
       

        $request->session()->flash('success', "New Offer added successfully");
        return back();
      
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        $offer = new Offer;
        $offer_item = $offer->where('id', $id)->first();
        if(!$offer_item){
            $request->session()->flash('info', "Requested Offer not found!");
            return redirect()->route('offers.index');
        }
        
        $customer_group = CustomerGroup::where('status',  $this -> status)->get();
        return view('offers.show', compact('offer_item', 'customer_group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $offer = new Offer;
        $offer_item = $offer->where('id', $id)->first();
        if(!$offer_item){
            $request->session()->flash('info', "Requested Offer not found!");
            return redirect()->route('offers.index');
        }
        $customer_group = CustomerGroup::where('status',  $this -> status)->get();
        return view('offers.edit', compact('offer_item', 'customer_group'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
     
        $this->validate($request, [
            "name" => "required|max:255|unique:offers,name,".$id,
            "offer_groups" => "required",
            "banner" => "mimes:jpeg,jpg,png|max:10000",  // max 10000kb
            "offer_status" => "required",
        ],[
            'name.required' => 'Offer name is required',
            'offer_groups.required' => 'Offer Group is required',
            'offer_status.required' => 'Offer status is required',
        ]);

        try {
            $offer = Offer::find($id);
          
            $old_banner_image = $offer-> banner_image;

            if ($request->file('banner')){

                $this -> delete_image_file($old_banner_image);

                $banner_file_path = $request->file('banner')->store($this -> file_upload_path);
                $banner_file_name = basename($banner_file_path);
                $offer-> banner_image = $banner_file_name;
            }

            $offer-> name = $request-> name;
            $offer-> description = ($request-> description) ? $request-> description : '' ;
            $offer-> validity = $request -> offer_status;
            $offer-> save();

            /**
                * add multiple groups to this offer
            */
            $offer_id = $offer -> id;
            OfferGroupMap::where('offer_id', $offer_id)->delete();
            $this -> offer_group_map($request -> offer_groups, $offer_id);


        } catch (\Exception  $e) {
            
            $request->session()->flash('info', "Error occure on updating Offer, try later!");
            return back();
        }
       

        $request->session()->flash('success', "Offer updated successfully");
        return back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $offer_item = Offer::find($id);
        if(!$offer_item){
            $request->session()->flash('info', "Requested Offer not found!");
        }else{
            $old_banner_image = $offer_item-> banner_image;
            $this -> delete_image_file($old_banner_image);
            $offer_item->delete();
            OfferGroupMap::where('offer_id', $id)->delete();
            $request->session()->flash('success', "Offer Deleted!");
        }
        return back();
    }


    /***
        * additional call functions here
    */
    public function offer_group_map($offer_groups, $offer_id){
        foreach ($offer_groups as $item) {
            $offer_group_map = new OfferGroupMap;
            $offer_group_map -> offer_id = $offer_id;
            $offer_group_map -> group_id = $item;
            $offer_group_map -> save();
        }  
    }

    public function delete_image_file($old_banner_image){
        $file_path = Storage::path($this -> file_upload_path.$old_banner_image);

        if (file_exists($file_path)) {
            unlink($file_path);
        }
        return true;
    }

    public function update_offer_status(Request $request){
        $offer_id = $request -> offer_id;
        $offer_item = Offer::find($offer_id);
        $update_value = null;
        foreach ($offer_item->offer_status as $key => $value){
            if($key != $offer_item -> validity)
                $update_value = $key;
        }
       
        if(!$update_value){
            $request->session()->flash('error', "Error on updating offer");
        }
        
            
        
        $offer_item-> validity = $update_value;
        $offer_item-> save();

        return response()->json(['success'=>'Offer status Updated']);
    }


    public function send_notification(Request $request){
        $offer_id = $request -> id;
        $offer_item = Offer::find($offer_id);
        if(!$offer_item){
            $request->session()->flash('info', "Requested Offer not found!");
        }else{
            $temp = $offer_item->offer_groups;
            $fcm_tokens = [];
            $in = 1;
            foreach ($temp as $row){
                foreach($row -> map_groups -> customer as $customer){
                   $fcm_tokens['fcm'][$in] = $customer  -> fcm_token;
                   $in ++;
                }
            }

            // send fcm tokens here
                // $fcm_tokens
            // return from fcm request
            $request->session()->flash('success', "Notification sent.");

        }
        return back();
    }
}
