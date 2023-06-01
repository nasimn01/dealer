<?php

namespace App\Http\Controllers\Do;

use App\Http\Controllers\Controller;

use App\Models\Do\D_o;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Traits\ImageHandleTraits;
use Exception;

class DOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('do.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $data=new D_o;
            $data->supplier_id = $request->supplier_id;
            $data->bill_id = $request->bill_id;
            $data->do_date = $request->do_date;
            $data->sub_total = $request->sub_total;
            $data->vat_amount = $request->vat_amount;
            $data->discount_amount = $request->discount_amount;
            $data->other_charge = $request->other_charge;
            $data->paid = $request->paid;
            $data->total = $request->total;

            $data->company_id=company()['company_id'];
            $data->created_by= currentUserId();

            if($data->save()){
            Toastr::success('Create Successfully!');
            return redirect()->route(currentUser().'.docon.index');
            } else{
            Toastr::warning('Please try Again!');
             return redirect()->back();
            }

        }
        catch (Exception $e){
            // dd($e);
            return back()->withInput();

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Do\D_o  $d_o
     * @return \Illuminate\Http\Response
     */
    public function show(D_o $d_o)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Do\D_o  $d_o
     * @return \Illuminate\Http\Response
     */
    public function edit(D_o $d_o)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Do\D_o  $d_o
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, D_o $d_o)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Do\D_o  $d_o
     * @return \Illuminate\Http\Response
     */
    public function destroy(D_o $d_o)
    {
        //
    }
}
