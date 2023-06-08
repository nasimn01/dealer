<?php

namespace App\Http\Controllers\Do;

use App\Http\Controllers\Controller;

use App\Models\Do\D_o;
use App\Models\Do\D_o_detail;
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
        $data=D_o::all();
        return view('do.index',compact('data'));
        // return view('product.group.purchase');
    }

    public function DoRecive(Request $request,$id)
    {
        $data=D_o_detail::where('do_id',encryptor('decrypt',$id))->get();
        // return $data;
        return view('do.doreceive',compact('data'));
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
        // dd($request->all());
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
            $data->status = 0;
            $data->company_id=company()['company_id'];
            $data->created_by= currentUserId();

            if($data->save()){
                if($request->product_id){
                    foreach($request->product_id as $key => $value){
                        // dd($request->all());
                        if($value){
                            $details = new D_o_detail;
                            $details->do_id=$data->id;
                            $details->product_id=$request->product_id[$key];
                            $details->qty=$request->qty[$key];
                            $details->unite_style_id=$request->unite_style_id[$key];
                            $details->free=$request->free[$key];
                            $details->price=$request->price[$key];
                            $details->basic=$request->basic[$key];
                            $details->discount_percent=$request->discount_percent[$key];
                            $details->vat_percent=$request->vat_percent[$key];
                            $details->amount=$request->amount[$key];
                            $details->save();
                        }
                    }
                }
            Toastr::success('Create Successfully!');
            return redirect()->route(currentUser().'.docontroll.index');
            } else{
            Toastr::warning('Please try Again!');
             return redirect()->back();
            }

        }
        catch (Exception $e){
            dd($e);
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
