<?php

namespace App\Http\Controllers\Do;

use App\Http\Controllers\Controller;

use App\Models\Do\D_o;
use App\Models\Do\D_o_detail;
use App\Models\Product\Product;
use App\Models\Do\DoReceiveHistory;
use App\Models\Stock\Stock;
use App\Models\Settings\Supplier_balance;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Traits\ImageHandleTraits;
use App\Models\Settings\Unit;
use App\Models\User;
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
        $user=User::where('id',currentUserId())->where('role_id',3)->select('distributor_id')->first();
        return view('do.create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //dd($request->all());
        try{
            $data=new D_o;
            $data->supplier_id = $request->supplier_id;
            $data->do_date = date('Y-m-d', strtotime($request->do_date));
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
                if($request->balance > 0 ){
                    $supb= new Supplier_balance;
                    $supb->supplier_id = $request->supplier_id;
                    $supb->balance_date = now();
                    $supb->balance_amount = $request->balance;
                    $supb->status = 0;
                    $supb->company_id=company()['company_id'];
                    if($supb->save()){
                        if($request->product_id){
                            foreach($request->product_id as $key => $value){
                                // dd($request->all());
                                if($value){
                                    $details = new D_o_detail;
                                    $details->do_id=$data->id;
                                    $details->product_id=$request->product_id[$key];
                                    $details->qty=$request->qty[$key];
                                    $details->free=$request->free_qty[$key];
                                    $details->dp=$request->dp[$key];
                                    $details->dp_pcs=$request->dp_pcs[$key];
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
    public function show($id)
    {
        $doData=D_o::findOrFail(encryptor('decrypt',$id));
        //return $doData;
        return view('do.show',compact('doData'));
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
        $product_id = $request->product_id;
        $dodetails = D_o_detail::where('product_id', $product_id)->pluck('do_id', 'id');
        $dos = D_o::whereIn('id', $dodetails->values())->pluck('reference_num', 'id')->toArray();

        $response = [];

        foreach ($dos as $do_id => $reference_num) {
            $dodetail_id = $dodetails->search($do_id);
            if ($dodetail_id !== false) {
                $response[] = [
                    'dodetail_id' => $dodetail_id,
                    'do_id' => $do_id,
                    'reference_num' => $reference_num,
                ];
            }
        }

        return response()->json($response, 200);
    }



    // public function doDataGet(Request $request)
    // {
    //     $product_id=$request->product_id;
    //     $dodetail=D_o_detail::where('product_id', $product_id)->pluck('do_id');
    //     $dodata=D_o::whereIn('id', $dodetail)->pluck('reference_num')->toArray();
    //     //return $dodata;
    //     return response()->json($dodata,200);
    // }

    /* unit data get function use do screen, do receive screen, sales screen */
    public function UnitDataGet(Request $request)
    {
        $productId=$request->product_id;
        $unitStyleId=Product::where('id', $productId)->where('status',0)->pluck('unit_style_id');
        $unit=Unit::whereIn('unit_style_id', $unitStyleId)->pluck('qty');
        //$unit=Unit::whereIn('unit_style_id', $unitStyleId)->where('name','pcs')->pluck('qty');
        //return $unit;
        return response()->json($unit,200);
    }

    public function productUpdate(Request $request)
    {
        $productId = $request->input('product_id');
        $freeRatio = $request->input('free_ratio');
        $dpPrice = $request->input('dp_price');
        $freeQty = $request->input('free');

        $product = Product::find($productId);
        $product->free_ratio = $freeRatio;
        $product->dp_price = $dpPrice;
        $product->free = $freeQty;
        $product->save();
        return response()->json(['message' => 'Product updated successfully']);
    }

    public function getProductData(Request $request){
    $productId = $request->product_id;
    $getProduct = Product::where('id', $productId)->where('status', 0)->first();
    $unit=Unit::where('unit_style_id', $getProduct->unit_style_id)->first();
    //$unit=Unit::where('unit_style_id', $getProduct->unit_style_id)->where('name','pcs')->first();

    if ($getProduct) {
        $data = [
            'dp_price' => $getProduct->dp_price,
            'free_ratio' => $getProduct->free_ratio,
            'free' => $getProduct->free,
            'unit_qty' => $unit->qty,
        ];

        return response()->json($data, 200);
    }
    return response()->json(['error' => 'Product not found'], 404);
    }


    public function DoRecive_edit(Request $request)
    {
       // dd($request->all());
        try{
            if($request->product_id){
                foreach($request->product_id as $key => $value){
                    if($value){
                        $dodetail=D_o_detail::find($request->dodetail_id[$key]);
                        $dodetail->dp=$request->dp[$key];
                        $dodetail->dp_pcs=$request->dp_pcs[$key];
                        $dodetail->sub_total=($dodetail->qty*$request->dp[$key]);
                        $dodetail->receive_qty=($dodetail->receive_qty + $request->receive[$key]);
                        $dodetail->receive_free_qty=($dodetail->receive_free_qty + $request->free[$key]);
                        if($dodetail->save()){
                            $productDp=Product::find($request->product_id[$key]);
                            $productDp->dp_price=$request->dp_pcs[$key];
                            if($productDp->save()){
                                $check_batch=Stock::where('product_id',$request->product_id[$key])->where('dp_price',$request->dp[$key])->orderBy('id','DESC')->pluck('batch_id');
                                if(count($check_batch) > 0){
                                    $batch_id=$check_batch[0];
                                }else{
                                    $batch_id=rand(111,999).$request->product_id[$key].uniqid();
                                }
                                $stock=new Stock;
                                $stock->do_id=$request->do_id[$key];
                                $stock->chalan_no=$request->chalan_no;
                                $stock->stock_date=date('Y-m-d', strtotime($request->stock_date));
                                $stock->product_id=$request->product_id[$key];
                                $stock->batch_id=$batch_id;
                                $stock->totalquantity_pcs=$request->receive[$key];
                                $stock->quantity_free=$request->free[$key];
                                $stock->dp_price=$request->dp[$key];
                                $stock->dp_pcs=$request->dp_pcs[$key];
                                $stock->subtotal_dp_pcs=$request->subtotal_dp_pcs[$key];
                                $stock->tp_price=$request->tp_price[$key];
                                $stock->tp_free=$request->tp_free[$key];
                                $stock->mrp_price=$request->mrp_price[$key];
                                //$stock->ex_date=$request->ex_date;
                                // $stock->adjust=$request->adjust[$key];
                                // $stock->remark=$request->remark[$key];
                                $stock->status=1;
                                $stock->status_history=3;
                                $stock->company_id=company()['company_id'];
                                $stock->created_by= currentUserId();
                                if($stock->save()){

                                $history=new DoReceiveHistory;
                                $history->do_id=$request->do_id[$key];
                                $history->chalan_no=$request->chalan_no;
                                $history->stock_date=date('Y-m-d', strtotime($request->stock_date));
                                $history->product_id=$request->product_id[$key];
                                $history->batch_id=$batch_id;
                                $history->ctn=$request->ctn[$key];
                                $history->pcs=$request->pcs[$key];
                                $history->quantity_free=$request->free[$key];
                                $history->totalquantity_pcs=$request->receive[$key];
                                $history->dp_price=$request->dp[$key];
                                $history->dp_pcs=$request->dp_pcs[$key];
                                $history->subtotal_dp_pcs=$request->subtotal_dp_pcs[$key];
                                $history->tp_price=$request->tp_price[$key];
                                $history->tp_free=$request->tp_free[$key];
                                $history->mrp_price=$request->mrp_price[$key];
                                //$history->ex_date=$request->ex_date;
                                // $history->adjust=$request->adjust[$key];
                                // $history->remark=$request->remark[$key];
                                $history->status=1;
                                $history->company_id=company()['company_id'];
                                $history->created_by= currentUserId();
                                $history->save();
                                }
                            }
                        }
                    }
                }

            }
            Toastr::success('Receive Successfully !');
            // return $history->chalan_no;
            return redirect(route(currentUser().'.do.receivelist'));
        }catch(Exception $e){
            dd($e);
            return redirect()->back()->withInput();
        }
    }

    public function doReceiveList()
    {
        $data=DoReceiveHistory::groupBy('do_receive_histories.chalan_no')->get();
        // return $data;
        return view('do.receive-list',compact('data'));
    }
    public function showDoReceive($chalan_no)
    {
        $print_data=DoReceiveHistory::where('chalan_no',$chalan_no)->get();
        $stockDate = $print_data->first()->stock_date;
        $chalanNo = $print_data->first()->chalan_no;
        // return $print_data;
        return view('do.print-do-receive',compact('print_data', 'stockDate', 'chalanNo'));
    }


}
