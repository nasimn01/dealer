<?php

namespace App\Http\Controllers\Do;

use App\Http\Controllers\Controller;

use App\Models\Do\D_o;
use App\Models\Do\D_o_detail;
use App\Models\Product\Product;
use App\Models\Do\DoReceiveHistory;
use App\Models\Stock\Stock_model;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Traits\ImageHandleTraits;
use App\Models\Settings\Unit;
use Exception;
use DB;
use Carbon\Carbon;

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
            $data->do_date = $request->do_date;
            $data->bill_id = $request->bill_id;
            $data->reference_num = $request->reference_num;
            $data->total_qty = $request->total_qty;
            $data->total_amount = $request->total_amount;
            // $data->vat_amount = $request->vat_amount;
            // $data->discount_amount = $request->discount_amount;
            // $data->other_charge = $request->other_charge;
            // $data->paid = $request->paid;
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
                            $details->dp=$request->dp[$key];
                            $details->sub_total=$request->sub_total[$key];
                            //$details->receive_qty=$request->qty[$key];
                            //$details->receive_free_qty=$request->free[$key];
                            // $details->unite_style_id=$request->unite_style_id[$key];
                            // $details->free=$request->free[$key];
                            // $details->free_tk=$request->free_tk[$key];
                            // $details->free_ratio=$request->free_ratio[$key];
                            // $details->basic=$request->basic[$key];
                            // $details->discount_percent=$request->discount_percent[$key];
                            // $details->vat_percent=$request->vat_percent[$key];
                            // $details->amount=$request->amount[$key];
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

    public function DoRecive()
    {
        // $data=D_o::findOrFail(encryptor('decrypt',$id));
        // return $data;
        return view('do.doreceive');
    }

    public function doDataGet(Request $request)
    {
        $product_id=$request->product_id;
        $dodetail=D_o_detail::where('product_id', $product_id)->pluck('do_id');
        $dodata=D_o::whereIn('id', $dodetail)->pluck('reference_num')->toArray();
        return $dodata;
        return response()->json($dodata,200);
    }

    public function UnitDataGet(Request $request)
    {
        $productId=$request->product_id;
        $unitStyleId=Product::where('id', $productId)->pluck('unit_style_id');
        $unit=Unit::whereIn('unit_style_id', $unitStyleId)->where('name','pcs')->pluck('qty');
        return $unit;
        return response()->json($unit,200);
    }


    public function DoRecive_edit(Request $request,$id)
    {
        //dd($request->all());
        try{
            $data=D_o::findOrFail(encryptor('decrypt',$id));
            $data->status=$request->status;
            $data->updated_by=currentUserId();
            if($data->save()){
                // foreach()
                foreach($request->receive_qty as $key => $value){
                    if($value){
                        $dodetail=D_o_detail::find($request->do_details_id[$key]);
                        $dodetail->receive_qty=($dodetail->receive_qty + $request->receive_qty[$key]);
                        $dodetail->receive_free_qty=($dodetail->receive_free_qty + $request->receive_free_qty[$key]);
                        if($dodetail->save()){
                            $stock=new Stock_model;
                            $stock->do_id=$data->id;
                            $stock->stock_date=$request->stock_date;
                            $stock->chalan_no=$request->chalan_no;
                            $stock->batch_no_id=$request->batch_no_id[$key];
                            $stock->unit_style_id=$request->unit_style_id[$key];
                            $stock->quantity=$request->receive_qty[$key]+$request->receive_free_qty[$key];
                            $stock->dp=$request->dp[$key];
                            $stock->tp=$request->tp[$key];
                            $stock->tp_free=$request->tp_free[$key];
                            $stock->mrp=$request->mrp[$key];
                            $stock->ex_date=$request->ex_date;
                            $stock->adjust=$request->adjust[$key];
                            $stock->remark=$request->remark[$key];
                            $stock->status=0;
                            $stock->company_id=company()['company_id'];
                            $stock->created_by= currentUserId();
                            if($stock->save()){

                            $history=new DoReceiveHistory;
                            $history->do_id=$request->do_id;
                            $history->supplier_id=$request->supplier_id;
                            $history->do_date=$request->do_date;
                            $history->stock_date=$request->stock_date;
                            $history->status=$request->status;
                            $history->chalan_no=$request->chalan_no;
                            $history->product_id=$request->product_id[$key];
                            $history->batch_no_id=$request->batch_no_id[$key];
                            $history->unit_style_id=$request->unit_style_id[$key];
                            $history->ctn=$request->ctn[$key];
                            $history->pcs=$request->pcs[$key];
                            $history->receive_free_qty=$request->receive_free_qty[$key];
                            $history->receive_qty=$request->receive_qty[$key];
                            $history->so=$request->so[$key];
                            $history->so_free=$request->so_free[$key];
                            $history->dp=$request->dp[$key];
                            $history->tp=$request->tp[$key];
                            $history->tp_free=$request->tp_free[$key];
                            $history->mrp=$request->mrp[$key];
                            $history->adjust=$request->adjust[$key];
                            $history->remark=$request->remark[$key];
                            $history->company_id=company()['company_id'];
                            $history->created_by= currentUserId();
                            $history->save();
                            }
                        }
                    }
                }
            }
            Toastr::success('Receive Successfully !');
            return redirect()->route(currentUser().'.docontroll.index');
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->withInput();
        }
    }

}
