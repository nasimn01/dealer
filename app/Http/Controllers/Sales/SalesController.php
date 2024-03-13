<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;

use App\Models\Sales\Sales;
use App\Models\Sales\SalesDetails;
use App\Models\Sales\TemporarySales;
use App\Models\Sales\TemporarySalesDetails;
use App\Models\Sales\SalesPayment;
use App\Models\Settings\Shop;
use App\Models\Settings\ShopBalance;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Traits\ImageHandleTraits;
use App\Models\Stock\Stock;
use \App\Models\Product\Product;
use App\Models\Settings\Unit;
use Carbon\Carbon;
use Exception;

class SalesController extends Controller
{

    public function index(Request $request)
    {
        $sales=TemporarySales::where('status',0)->where(company())->paginate(10);
        $userSr=User::where(company())->where('role_id',5)->get();
        return view('sales.index',compact('sales','userSr'));
    }
    public function salesClosingList(Request $request)
    {
        $sales = Sales::orderBy('id','DESC');
        // $sales = Sales::join('users', 'users.id', '=', 'sales.dsr_id')->where('sales.company_id', company())->select('sales.*', 'users.id', 'users.sr_id');
        $userSr=User::where(company())->where('role_id',5)->get();
        if ($request->sr_id)
        $sales->where('users.sr_id',$request->sr_id);

        $sales = $sales->paginate(25);


        return view('sales.salesClosingList',compact('sales','userSr'));
    }


    public function create()
    {
        $user=User::where('id',currentUserId())->where('role_id',3)->select('distributor_id')->first();
        $userSr=User::where(company())->where('role_id',5)->get();
        return view('sales.create',compact('user','userSr'));
    }
    public function selectedCreate()
    {
        $user=User::where('id',currentUserId())->where('role_id',3)->select('distributor_id')->first();
        $userSr=User::where(company())->where('role_id',5)->get();
        return view('sales.selectedCreate',compact('user','userSr'));
    }

    public function store(Request $request)
    { //dd($request->all());
        try{
            $data=new TemporarySales;
            $data->select_shop_dsr = $request->select_shop_dsr;
            $data->shop_id = $request->shop_id;
            $data->dsr_id = $request->dsr_id;
            $data->sr_id = $request->sr_id;
            $data->sales_date = date('Y-m-d', strtotime($request->sales_date));
            $data->total = $request->total;
            $data->status = 0;
            $data->company_id=company()['company_id'];
            $data->created_by= currentUserId();
            if($data->save()){
                if($request->subtotal_price){
                    foreach($request->subtotal_price as $key => $value){
                        if($value){
                            $details = new TemporarySalesDetails;
                            $details->tem_sales_id=$data->id;
                            $details->product_id=$request->product_id[$key];
                            $details->ctn=$request->ctn[$key];
                            $details->pcs=$request->pcs[$key];
                            $details->select_tp_tpfree=$request->select_tp_tpfree[$key];
                            $details->pcs_price=$request->per_pcs_price[$key];
                            $details->ctn_price=$request->ctn_price[$key];
                            $details->totalquantity_pcs=$request->totalquantity_pcs[$key];
                            $details->subtotal_price=$request->subtotal_price[$key];
                            $details->company_id=company()['company_id'];
                            $details->created_by= currentUserId();
                            if($details->save()){
                                $stock=new Stock;
                                $stock->tem_sales_id=$data->id;
                                $stock->product_id=$request->product_id[$key];
                                $stock->totalquantity_pcs=$request->totalquantity_pcs[$key];
                                $stock->status_history=0;
                                $stock->status=0;
                                if($request->select_tp_tpfree[$key]==1){
                                    $stock->tp_price=$request->per_pcs_price[$key];
                                }else{
                                    $stock->tp_free=$request->per_pcs_price[$key];
                                }
                                $stock->save();
                            }
                        }
                    }
                }
            Toastr::success('Create Successfully!');
            return redirect()->route(currentUser().'.sales.index');
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


    public function show($id)
    {
        $sales=TemporarySales::findOrFail(encryptor('decrypt',$id));
        return view('sales.show',compact('sales'));
    }


    public function PrimaryUpdate($id)
    {
        //$sales = TemporarySales::where('status',0)->findOrFail(encryptor('decrypt',$id));
        $sales = TemporarySales::findOrFail(encryptor('decrypt',$id));
        $shops=Shop::all();
        $dsr=User::where('role_id',4)->get();
        $userSr=User::where(company())->where('role_id',5)->get();
        return view('sales.primary-update',compact('sales','shops','dsr','userSr'));
    }

    public function primaryStore(Request $request, $id)
    {
        try{
            $data=TemporarySales::findOrFail(encryptor('decrypt',$id));
            $data->select_shop_dsr = $request->select_shop_dsr;
            $data->shop_id = $request->shop_id;
            $data->dsr_id = $request->dsr_id;
            $data->sr_id = $request->sr_id;
            $data->sales_date = date('Y-m-d', strtotime($request->sales_date));
            $data->total = $request->total;
            $data->status = 0;
            $data->company_id=company()['company_id'];
            $data->updated_by= currentUserId();
            if($data->save()){
                if($request->product_id){
                    $dl=TemporarySalesDetails::where('tem_sales_id',$data->id)->delete();
                    $dlstock=Stock::where('tem_sales_id',$data->id)->delete();
                    foreach($request->product_id as $key => $value){
                        if($value){
                            $details = new TemporarySalesDetails;
                            $details->tem_sales_id=$data->id;
                            $details->product_id=$request->product_id[$key];
                            $details->ctn=$request->ctn[$key];
                            $details->pcs=$request->pcs[$key];
                            $details->select_tp_tpfree=$request->select_tp_tpfree[$key];
                            $details->ctn_price=$request->ctn_price[$key];
                            $details->pcs_price=$request->per_pcs_price[$key];
                            $details->totalquantity_pcs=$request->totalquantity_pcs[$key];
                            $details->subtotal_price=$request->subtotal_price[$key];
                            $details->company_id=company()['company_id'];
                            $details->updated_by= currentUserId();
                            if($details->save()){
                                $stock=new Stock;
                                $stock->tem_sales_id=$data->id;
                                $stock->product_id=$request->product_id[$key];
                                $stock->totalquantity_pcs=$request->totalquantity_pcs[$key];
                                $stock->status_history=0;
                                $stock->status=0;
                                if($request->select_tp_tpfree[$key]==1){
                                    $stock->tp_price=$request->per_pcs_price[$key];
                                }else{
                                    $stock->tp_free=$request->per_pcs_price[$key];
                                }
                                $stock->save();
                            }
                        }
                    }
                }
            Toastr::success('Update Successfully!');
            return redirect()->route(currentUser().'.sales.index');
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

    public function edit($id)
    {
        $sales = TemporarySales::findOrFail(encryptor('decrypt',$id));
        $shops=Shop::all();
        $dsr=User::where('role_id',4)->get();
        return view('sales.edit',compact('sales','shops','dsr'));
    }

    public function update(Request $request, $id)
    {
        // try{
        //     $sales = TemporarySales::findOrFail(encryptor('decrypt',$id));
        //     $sales->shop_id = $request->shop_id;
        //     $sales->dsr_id = $request->dsr_id;
        //     $sales->sales_date = date('Y-m-d', strtotime($request->sales_date));

        //     $sales->expenses = $request->expenses;
        //     $sales->commission = $request->commission;
        //     $sales->final_total = $request->final_total;
        //     //$sales->total = $request->total;
        //     $sales->status = 1;
        //     $sales->company_id=company()['company_id'];
        //     $sales->updated_by= currentUserId();
        //     if($sales->save()){
        //         if($request->product_id){
        //             foreach($request->product_id as $key => $value){
        //                 if($value){
        //                     $details = new TemporarySalesDetails;
        //                     $details->tem_sales_id=$sales->id;
        //                     $details->product_id=$request->product_id[$key];
        //                     $details->ctn=$request->ctn[$key];
        //                     $details->pcs=$request->pcs[$key];
        //                     $details->select_tp_tpfree=$request->select_tp_tpfree[$key];
        //                     $details->ctn_price=$request->ctn_price[$key];
        //                     $details->subtotal_price=$request->subtotal_price[$key];
        //                     $details->company_id=company()['company_id'];
        //                     $details->updated_by= currentUserId();
        //                     $details->save();
        //                 }
        //             }
        //         }
        //     }
        //     if($request->old_due_shop_id){
        //         foreach($request->old_due_shop_id as $i=>$old_due_shop_id){
        //             if($old_due_shop_id){
        //                 $olddue=new ShopBalance;
        //                 // $olddue->sales_id=$sales->id;
        //                 $olddue->shop_id=$old_due_shop_id;
        //                 $olddue->balance_amount=$request->old_due_tk[$i];
        //                 $olddue->status=1;
        //                 $olddue->save();
        //             }
        //         }
        //     }
        //     if($request->new_due_shop_id){
        //         foreach($request->new_due_shop_id as $i=>$new_due_shop_id){
        //             if($new_due_shop_id){
        //                 $olddue=new ShopBalance;
        //                 // $olddue->sales_id=$sales->id;
        //                 $olddue->shop_id=$new_due_shop_id;
        //                 $olddue->balance_amount=$request->new_due_tk[$i];
        //                 $olddue->new_due_date=$request->new_due_date[$i];
        //                 $olddue->status=0;
        //                 $olddue->save();
        //             }
        //         }
        //     }
        //     if($request->new_receive_shop_id){
        //         foreach($request->new_receive_shop_id as $i=>$new_receive_shop_id){
        //             if($new_receive_shop_id){
        //                 $olddue=new SalesPayment;
        //                 $olddue->sales_id=$sales->id;
        //                 $olddue->shop_id=$new_receive_shop_id;
        //                 $olddue->amount=$request->new_receive_tk[$i];
        //                 $olddue->cash_type=1;
        //                 $olddue->save();
        //             }
        //         }
        //     }
        //     if($request->check_shop_id){
        //         foreach($request->check_shop_id as $i=>$check_shop_id){
        //             if($check_shop_id){
        //                 $olddue=new SalesPayment;
        //                 $olddue->sales_id=$sales->id;
        //                 $olddue->shop_id=$check_shop_id;
        //                 $olddue->amount=$request->check_shop_tk[$i];
        //                 $olddue->check_date=$request->check_date[$i];
        //                 $olddue->cash_type=0;
        //                 $olddue->save();
        //             }
        //         }
        //     }

        // }
        // catch (Exception $e){
        //     dd($e);
        //     return back()->withInput();

        // }
    }
    public function salesReceiveScreen($id)
    {
        $sales = TemporarySales::findOrFail(encryptor('decrypt',$id));
        $shops=Shop::all();
        $dsr=User::where('role_id',4)->get();
        $product=Product::where(company())->get();
        return view('sales.salesClosing',compact('sales','shops','dsr','product'));
    }
    public function salesReceive(Request $request)
    {  //dd($request->all());
        try{
            $tmsales=TemporarySales::where('id',$request->tem_sales_id)->first();
            $tmsales->status=1;
            if($tmsales->save()){
                $sales =new Sales;
                $sales->shop_id = $request->shop_id;
                $sales->dsr_id = $request->dsr_id;
                $sales->sr_id = $request->sr_id;
                $sales->tem_sales_id = $request->tem_sales_id;
                $sales->sales_date = date('Y-m-d', strtotime($request->sales_date));

                $sales->daily_total_taka = $request->daily_total_taka;
                $sales->return_total_taka = $request->return_total_taka;
                $sales->expenses = $request->expenses;
                $sales->commission = $request->commission;
                $sales->dsr_cash = $request->cash;
                $sales->dsr_salary = $request->dsr_salary;
                $sales->final_total = $request->final_total;
                $sales->today_final_cash = $request->today_final_cash;
                //$sales->total = $request->total;
                $sales->status = 1;
                $sales->company_id=company()['company_id'];
                $sales->updated_by= currentUserId();
                if($sales->save()){
                    if($request->product_id){
                        foreach($request->product_id as $key => $value){
                            if($value){
                                $details = new SalesDetails;
                                $details->sales_id=$sales->id;
                                $details->product_id=$request->product_id[$key];
                                $details->ctn=$request->ctn[$key];
                                $details->pcs=$request->pcs[$key];
                                $details->ctn_return=$request->ctn_return[$key];
                                $details->pcs_return=$request->pcs_return[$key];
                                $details->ctn_damage=$request->ctn_damage[$key];
                                $details->pcs_damage=$request->pcs_damage[$key];
                                // $details->ctn_price=$request->ctn_price[$key];
                                if($request->price_type[$key]=="1"){
                                    $details->tp_price=$request->tp_price[$key];
                                }else{
                                    $details->tp_free=$request->tp_price[$key];
                                }
                                $details->total_return_pcs=$request->total_return_pcs[$key];
                                $details->total_damage_pcs=$request->total_damage_pcs[$key];
                                $details->total_sales_pcs=$request->total_sales_pcs[$key];
                                $details->subtotal_price=$request->subtotal_price[$key];
                                // $details->total_taka=$request->total_taka[$key];
                                // $details->select_tp_tpfree=$request->select_tp_tpfree[$key];
                                $details->status=0;
                                $details->company_id=company()['company_id'];
                                $details->created_by= currentUserId();
                                if($details->save()){
                                    if($request->ctn_return[$key] >0 || $request->pcs_return[$key]>0){
                                        $stock=new Stock;
                                        $stock->sales_id=$sales->id;
                                        $stock->product_id=$request->product_id[$key];
                                        $stock->totalquantity_pcs=$request->total_return_pcs[$key];
                                        $stock->status_history=1;
                                        $stock->status=1;
                                        if($request->price_type[$key]=="1"){
                                            $stock->tp_price=$request->tp_price[$key];
                                        }else{
                                            $stock->tp_free=$request->tp_price[$key];
                                        }
                                        $stock->save();
                                    }
                                    if($request->ctn_damage[$key] >0 || $request->pcs_damage[$key]>0){
                                        $stock=new Stock;
                                        $stock->sales_id=$sales->id;
                                        $stock->product_id=$request->product_id[$key];
                                        $stock->totalquantity_pcs=$request->total_damage_pcs[$key];
                                        $stock->status_history=2;
                                        $stock->status=1;
                                        if($request->price_type[$key]=="1"){
                                            $stock->tp_price=$request->tp_price[$key];
                                        }else{
                                            $stock->tp_free=$request->tp_price[$key];
                                        }
                                        $stock->save();
                                    }
                                }
                            }
                        }
                    }
                }
                if($request->return_product_id){
                    foreach($request->return_product_id as $i=>$return_product_id){
                        if($return_product_id){
                            $rsales=new SalesDetails;
                            $rsales->sales_id=$sales->id;
                            $rsales->product_id=$return_product_id;
                            $rsales->ctn_return=$request->old_ctn_return[$i];
                            $rsales->pcs_return=$request->old_pcs_return[$i];
                            $rsales->ctn_damage=$request->old_ctn_damage[$i];
                            $rsales->pcs_damage=$request->old_pcs_damage[$i];
                            $rsales->tp_price=$request->old_pcs_price[$i];
                            $rsales->subtotal_price=$request->return_subtotal_price[$i];
                            $rsales->total_return_pcs=$request->old_total_return_pcs[$i];
                            $rsales->total_damage_pcs=$request->old_total_damage_pcs[$i];
                            // $rsales->balance_amount=$request->old_due_tk[$i];
                            $rsales->status=1;
                            if($rsales->save()){
                                if($request->old_ctn_return[$i] >0 || $request->old_pcs_return[$i]>0){
                                    $stock=new Stock;
                                    $stock->sales_id=$sales->id;
                                    $stock->product_id=$request->return_product_id[$i];
                                    $stock->totalquantity_pcs=$request->old_total_return_pcs[$i];
                                    $stock->tp_price=$request->old_pcs_price[$i];
                                    $stock->status_history=1;
                                    $stock->status=1;
                                    // if($request->select_tp_tpfree[$i]==1){
                                    //     $stock->tp_price=$request->per_pcs_price[$i];
                                    // }else{
                                    //     $stock->tp_free=$request->per_pcs_price[$i];
                                    // }
                                    $stock->save();
                                }
                                if($request->old_ctn_damage[$i] >0 || $request->old_pcs_damage[$i]>0){
                                    $stock=new Stock;
                                    $stock->sales_id=$sales->id;
                                    $stock->product_id=$request->return_product_id[$i];
                                    $stock->totalquantity_pcs=$request->old_total_damage_pcs[$i];
                                    $stock->tp_price=$request->old_pcs_price[$i];
                                    $stock->status_history=2;
                                    $stock->status=1;
                                    // if($request->select_tp_tpfree[$i]==1){
                                    //     $stock->tp_price=$request->per_pcs_price[$i];
                                    // }else{
                                    //     $stock->tp_free=$request->per_pcs_price[$i];
                                    // }
                                    $stock->save();
                                }
                            }
                        }
                    }
                }
                if($request->old_due_shop_id){
                    foreach($request->old_due_shop_id as $i=>$old_due_shop_id){
                        if($old_due_shop_id){
                            $olddue=new ShopBalance;
                            $olddue->sales_id=$sales->id;
                            $olddue->shop_id=$old_due_shop_id;
                            $olddue->balance_amount=$request->old_due_tk[$i];
                            $olddue->company_id=company()['company_id'];
                            $olddue->status=1;
                            $olddue->save();
                        }
                    }
                }
                if($request->new_due_shop_id){
                    foreach($request->new_due_shop_id as $i=>$new_due_shop_id){
                        if($new_due_shop_id){
                            $newdue=new ShopBalance;
                            $newdue->sales_id=$sales->id;
                            $newdue->shop_id=$new_due_shop_id;
                            $newdue->balance_amount=$request->new_due_tk[$i];
                            $newdue->new_due_date=$request->new_due_date[$i];
                            $newdue->company_id=company()['company_id'];
                            $newdue->status=0;
                            $newdue->save();
                        }
                    }
                }
                // if($request->new_receive_shop_id){
                //     foreach($request->new_receive_shop_id as $i=>$new_receive_shop_id){
                //         if($new_receive_shop_id){
                //             $payment=new SalesPayment;
                //             $payment->sales_id=$sales->id;
                //             $payment->shop_id=$new_receive_shop_id;
                //             $payment->amount=$request->new_receive_tk[$i];
                //             $payment->cash_type=1;
                //             $payment->save();
                //         }
                //     }
                // }
                if($request->check_shop_id){
                    foreach($request->check_shop_id as $i=>$check_shop_id){
                        if($check_shop_id){
                            $pay=new SalesPayment;
                            $pay->sales_id=$sales->id;
                            $pay->shop_id=$check_shop_id;
                            $pay->amount=$request->check_shop_tk[$i];
                            $pay->check_date=$request->check_date[$i];
                            $pay->cash_type=0;
                            $pay->status=0;
                            $pay->save();
                        }
                    }
                }

            }
            Toastr::success('Sales Closing Successfully Done!');
            return redirect(route(currentUser().'.sales.printpage',encryptor('encrypt',$sales->id)));
        }
        catch (Exception $e){
            dd($e);
            return back()->withInput();

        }
    }

    public function printSalesClosing($id)
    {
        // $sales = Sales::findOrFail($id);
        $sales = Sales::findOrFail(encryptor('decrypt',$id));
        //return $sales;
        // $shops=Shop::all();
        // $dsr=User::where('role_id',4)->get();
        // $product=Product::where(company())->get();
       // return view('sales.printSalesClosing',compact('sales','shops','dsr','product'));
        return view('sales.printSalesClosing',compact('sales'));
    }


    public function destroy($id)
    {
        $data= TemporarySales::findOrFail(encryptor('decrypt',$id));
        $tdl=TemporarySalesDetails::where('tem_sales_id',$data->id)->delete();
        $sdl=Stock::where('tem_sales_id',$data->id)->delete();
        $data->delete();
        Toastr::error('Opps!! You Delete Permanently!!');
        return redirect()->back();
    }

    public function ShopDataGet(Request $request)
    {
        $shop=Shop::all();
        return response()->json($shop,200);
    }
    public function DsrDataGet(Request $request)
    {
        $dsr=User::where('role_id',4)->get();
        return response()->json($dsr,200);
    }
    // public function SupplierProduct(Request $request)
    // {
    //     $product=Product::where('distributor_id',$request->supplier_id)->get();
    //     $showqty =\App\Models\Stock\Stock::whereIn('status', [1, 3])->where('product_id',$product->id)->sum('totalquantity_pcs') - \App\Models\Stock\Stock::whereIn('status', [0, 4, 5])->where('product_id',$product->id)->sum('totalquantity_pcs');
    //     return response()->json($product,200);
    // }
    public function SupplierProduct(Request $request)
    {
        $products = Product::where('distributor_id', $request->supplier_id)->get();
        $response = [];

        foreach ($products as $product) {
            $stockIn=Stock::whereIn('status_history', [1, 3])->where('product_id', $product->id)->sum('totalquantity_pcs');
            $stockout=Stock::whereIn('status_history', [0, 2, 4, 5])->where('product_id', $product->id)->sum('totalquantity_pcs');
            $totalFree=Stock::where('product_id', $product->id)->sum('quantity_free');
            $showqty =  (($stockIn+$totalFree)- $stockout);

            // Include product and showqty in the response
            $response[] = [
                'product' => $product,
                'showqty' => $showqty,
            ];
        }

        return response()->json($response, 200);
    }

    public function salesClosing(Request $request)
    {
        $sales = TemporarySales::all();
        $shops=Shop::all();
        $dsr=User::where('role_id',4)->get();
        $product=Product::where(company())->get();
        return view('sales.getsalesClosing',compact('sales','shops','dsr','product'));
    }
    public function getSalesClosingData(Request $request)
    { //dd($request->all());
        if($request->sales_date && $request->dsr_id || $request->shop_id){
            // $requestdDate = Carbon::createFromFormat('m/d/Y', $request->sales_date)->format('m/d/Y');
            $sales = TemporarySales::where('status',0)->where(company())->orderBy('id', 'asc')
            ->where('sales_date',date('Y-m-d', strtotime($request->sales_date)))
            ->where(function ($query) use ($request) {
            $query->where('dsr_id', $request->dsr_id)
            ->orWhere('shop_id', $request->shop_id);
            })
            ->first();
            //return $sales;
            $shops=Shop::all();
            $dsr=User::where('role_id',4)->get();
            $userSr=User::where(company())->where('role_id',5)->get();
            $product=Product::where(company())->get();
            if($sales){
                return view('sales.salesClosingSidebar',compact('sales','shops','dsr','product','userSr'));
            }else {
                return view('sales.nodata');
            }
        }else {
            return redirect()->back();
        }
    }
    // public function UnitDataGet(Request $request)
    // {
    //     $productId=$request->product_id;
    //     $unitStyleId=Product::where('id', $productId)->where('status',0)->pluck('unit_style_id');
    //     $unit=Unit::whereIn('unit_style_id', $unitStyleId)->pluck('qty');
    //     $showqty = \App\Models\Stock\Stock::whereIn('status', [1, 3])->where('product_id', $product->id)->sum('totalquantity_pcs') - \App\Models\Stock\Stock::whereIn('status', [0, 4, 5])->where('product_id', $product->id)->sum('totalquantity_pcs');
    //     return response()->json($unit,200);
    // }
    public function UnitDataGet(Request $request)
    {
        $productId = $request->product_id;
        // Retrieve a single product based on the provided $productId
        $product = Product::where('id', $productId)->where('status', 0)->first();

        // Check if a product is found
        if ($product) {
            $unitStyleId = $product->unit_style_id;
            $unit = Unit::where('unit_style_id', $unitStyleId)->pluck('qty');
                $stockIn=Stock::whereIn('status_history', [1, 3])->where('product_id', $product->id)->sum('totalquantity_pcs');
                $stockout=Stock::whereIn('status_history', [0, 2, 4, 5])->where('product_id', $product->id)->sum('totalquantity_pcs');
                $totalFree=Stock::where('product_id', $product->id)->sum('quantity_free');
                $showqty =  (($stockIn+$totalFree)- $stockout);
                return response()->json([
                    'unit' => $unit,
                    'showqty' => $showqty,
                ], 200);
        } else {
            // Handle the case where no product is found
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

}
