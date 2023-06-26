<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\ReturnProduct;
use App\Models\Product\ReturnProductDetails;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Traits\ImageHandleTraits;
use Exception;
use DB;

class ReturnProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=ReturnProduct::all();
        return view('product.returnproduct.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.returnproduct.create');
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
            $data=new ReturnProduct;
            $data->driver_name = $request->driver_name;
            $data->helper = $request->helper;
            $data->garir_number = $request->garir_number;
            $data->invoice_number = $request->invoice_number;
            $data->note = $request->note;
            $data->sub_total = $request->sub_total;
            $data->vat_amount = $request->vat_amount;
            $data->discount_amount = $request->discount_amount;
            $data->other_charge = $request->other_charge;
            $data->total = $request->total;
            $data->status = 0;
            $data->company_id=company()['company_id'];
            $data->created_by= currentUserId();

            if($data->save()){
                if($request->product_id){
                    foreach($request->product_id as $key => $value){
                        // dd($request->all());
                        if($value){
                            $details = new ReturnProductDetails;
                            $details->return_product_id=$data->id;
                            $details->product_id=$request->product_id[$key];
                            $details->qty=$request->qty[$key];
                            $details->unite_style_id=$request->unite_style_id[$key];
                            $details->free=$request->free[$key];
                            $details->free_tk=$request->free_tk[$key];
                            $details->free_ratio=$request->free_ratio[$key];
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
     * @param  \App\Models\Product\ReturnProduct  $returnProduct
     * @return \Illuminate\Http\Response
     */
    public function show(ReturnProduct $returnProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product\ReturnProduct  $returnProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturnProduct $returnProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product\ReturnProduct  $returnProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReturnProduct $returnProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product\ReturnProduct  $returnProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturnProduct $returnProduct)
    {
        //
    }
}
