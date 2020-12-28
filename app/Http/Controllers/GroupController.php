<?php

namespace App\Http\Controllers;

use Redirect;
use Illuminate\Http\Request;

use App\CustomerGroup;
use App\OfferGroupMap;

class GroupController extends Controller
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
        
        $customer_group = new CustomerGroup;
        if (!$key) 
            $group_items = $customer_group->where('status', $this -> status)
            ->orderBy('created_at', 'desc')
            ->paginate($per_page);
        else
            $group_items = $customer_group->where('status', $this -> status)
            ->where('name','LIKE', "%$key%")
            ->orderBy('created_at', 'desc')
            ->paginate($per_page);
        return view('groups.index', compact('group_items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('groups.create');
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
            "name" => "required|unique:customer_groups|max:255",
        ],[
            'name.required' => 'Group name is required',
        ]);

        $customer_group = new CustomerGroup;

        $customer_group->name = $request-> name;
        $customer_group->description = ($request-> description) ? $request-> description : '' ;
        $customer_group->status = $this -> status;
        $customer_group->save();

        
        $request->session()->flash('success', "New group inserted successfully");
        return back();
        // return Redirect::back();
       
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
        $customer_group = new CustomerGroup;
        $group_item = $customer_group->where('id', $id)->first();
        if(!$group_item){
            $request->session()->flash('info', "Requested group not found!");
            return redirect()->route('groups.index');
        }
        return view('groups.show', compact('group_item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request ,$id)
    {
        $customer_group = new CustomerGroup;
        $group_item = $customer_group->where('id', $id)->first();
        if(!$group_item){
            $request->session()->flash('info', "Requested Group not found!");
            return redirect()->route('groups.index');
        }
        return view('groups.edit', compact('group_item'));
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
            "name" => "required|max:255|unique:customer_groups,name,".$id,
        ],[
            'name.required' => 'Group name is required',
        ]);

        $customer_group = CustomerGroup::find($id);
        $customer_group->name =  $request->name;
        $customer_group->description =  ($request-> description) ? $request-> description : '';
        $customer_group->save();

        $request->session()->flash('success', "Group updated successfully");
        return back();
        // return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $check_group_linked = OfferGroupMap::where('group_id', $id)->count();
        if($check_group_linked){
            $request->session()->flash('info', "Requested Group can't delete!");
        }else{
            $customer_group = CustomerGroup::find($id);
            if(!$customer_group){
                $request->session()->flash('info', "Requested Group not found!");
            }else{
                $customer_group->delete();
                $request->session()->flash('success', "Group Deleted!");
            }
        }
        return back();
    }
}
