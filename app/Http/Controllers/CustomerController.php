<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\CustomerGroup;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $status;

    public function __construct(){
        $this -> status = \Config::get('constants.rec_status');
    }


    public function index(Request $request)
    {
        //
        $key = $request->k;
        $per_page = \Config::get('constants.pagination_count');
        
        $customer = new Customer;
        
        if (!$key) 
            $customers = $customer->where('status', $this -> status)
            ->orderBy('created_at', 'desc')
            ->paginate($per_page);
        else
            $customers = $customer->where('status', $this -> status)
            ->where('number','LIKE', "%$key%")
            ->orderBy('created_at', 'desc')
            ->paginate($per_page);
        
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        //
        $customer = new Customer;
        $customer = $customer->where('id', $id)->first();
        if(!$customer){
            $request->session()->flash('info', "Requested Offer not found!");
            return redirect()->route('offers.index');
        }
        $customer_group = CustomerGroup::where('status',  $this -> status)->get();
        return view('customers.show',compact('customer','customer_group'));
        // return abort(404);
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
        $customer = new Customer;
        $customer = $customer->where('id', $id)->first();
        if(!$customer){
            $request->session()->flash('info', "Requested Offer not found!");
            return redirect()->route('offers.index');
        }
        $customer_group = CustomerGroup::where('status',  $this -> status)->get();
        return view('customers.edit',compact('customer','customer_group'));
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
        //
        $this->validate($request, [
            "group" => "required",
        ],[
            'group.required' => 'Group is required',
        ]);

        try {
            $customer = Customer::find($id);
            $customer-> group = $request-> group;
            $customer-> save();
        } catch (\Exception  $e) {
            $request->session()->flash('info', "Error occure on updating customer, try later!");
            return back();
        }
        $request->session()->flash('success', "Customer updated successfully");
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return abort(404);
    }
}
