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
use Exception;

class SalesController extends Controller
{

    public function index()
    {
        $sales=TemporarySales::where(company())->paginate(10);
        return view('sales.index',compact('sales'));
    }


    public function create()
    {
        return view('sales.create');
    }


    public function store(Request $request)
    {
        try{
            $data=new TemporarySales;
            $data->select_shop_dsr = $request->select_shop_dsr;
            $data->shop_id = $request->shop_id;
            $data->dsr_id = $request->dsr_id;
            $data->sales_date = $request->sales_date;
            $data->total = $request->total;
            $data->status = 0;
            $data->company_id=company()['company_id'];
            $data->created_by= currentUserId();
            if($data->save()){
                if($request->product_id){
                    foreach($request->product_id as $key => $value){
                        if($value){
                            $details = new TemporarySalesDetails;
                            $details->sales_id=$data->id;
                            $details->product_id=$request->product_id[$key];
                            $details->ctn=$request->ctn[$key];
                            $details->pcs=$request->pcs[$key];
                            $details->select_tp_tpfree=$request->select_tp_tpfree[$key];
                            $details->pcs_price=$request->per_pcs_price[$key];
                            $details->ctn_price=$request->ctn_price[$key];
                            $details->subtotal_price=$request->subtotal_price[$key];
                            $details->company_id=company()['company_id'];
                            $details->created_by= currentUserId();
                            if($details->save()){
                                $stock=new Stock;
                                $stock->product_id=$request->product_id[$key];
                                $stock->totalquantity_pcs=$request->totalquantity_pcs[$key];
                                $stock->status_history=1;
                                $stock->status=1;
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


    public function show(Sales $sales)
    {
        //
    }


    public function PrimaryUpdate($id)
    {
        //$sales = TemporarySales::where('status',0)->findOrFail(encryptor('decrypt',$id));
        $sales = TemporarySales::findOrFail(encryptor('decrypt',$id));
        $shops=Shop::all();
        $dsr=User::where('role_id',4)->get();
        return view('sales.primary-update',compact('sales','shops','dsr'));
    }

    public function primaryStore(Request $request, $id)
    {
        try{
            $data=TemporarySales::findOrFail(encryptor('decrypt',$id));
            $data->select_shop_dsr = $request->select_shop_dsr;
            $data->shop_id = $request->shop_id;
            $data->dsr_id = $request->dsr_id;
            $data->sales_date = $request->sales_date;
            $data->total = $request->total;
            $data->status = 0;
            $data->company_id=company()['company_id'];
            $data->updated_by= currentUserId();
            if($data->save()){
                if($request->product_id){
                    $dl=TemporarySalesDetails::where('sales_id',$data->id)->delete();
                    foreach($request->product_id as $key => $value){
                        if($value){
                            $details = new TemporarySalesDetails;
                            $details->sales_id=$data->id;
                            $details->product_id=$request->product_id[$key];
                            $details->ctn=$request->ctn[$key];
                            $details->pcs=$request->pcs[$key];
                            $details->select_tp_tpfree=$request->select_tp_tpfree[$key];
                            $details->ctn_price=$request->ctn_price[$key];
                            $details->pcs_price=$request->per_pcs_price[$key];
                            $details->subtotal_price=$request->subtotal_price[$key];
                            $details->company_id=company()['company_id'];
                            $details->updated_by= currentUserId();
                            $details->save();
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
        try{
            $sales = TemporarySales::findOrFail(encryptor('decrypt',$id));
            $sales->shop_id = $request->shop_id;
            $sales->dsr_id = $request->dsr_id;
            $sales->sales_date = $request->sales_date;

            $sales->expenses = $request->expenses;
            $sales->commission = $request->commission;
            $sales->final_total = $request->final_total;
            //$sales->total = $request->total;
            $sales->status = 1;
            $sales->company_id=company()['company_id'];
            $sales->updated_by= currentUserId();
            if($sales->save()){
                if($request->product_id){
                    foreach($request->product_id as $key => $value){
                        if($value){
                            $details = new TemporarySalesDetails;
                            $details->sales_id=$sales->id;
                            $details->product_id=$request->product_id[$key];
                            $details->ctn=$request->ctn[$key];
                            $details->pcs=$request->pcs[$key];
                            $details->select_tp_tpfree=$request->select_tp_tpfree[$key];
                            $details->ctn_price=$request->ctn_price[$key];
                            $details->subtotal_price=$request->subtotal_price[$key];
                            $details->company_id=company()['company_id'];
                            $details->updated_by= currentUserId();
                            $details->save();
                        }
                    }
                }
            }
            if($request->old_due_shop_id){
                foreach($request->old_due_shop_id as $i=>$old_due_shop_id){
                    if($old_due_shop_id){
                        $olddue=new ShopBalance;
                        $olddue->sales_id=$sales->id;
                        $olddue->old_due_shop_id=$old_due_shop_id;
                        $olddue->old_due_tk=$request->old_due_tk[$i];
                        $olddue->save();
                    }
                }
            }
            if($request->new_due_shop_id){
                foreach($request->new_due_shop_id as $i=>$new_due_shop_id){
                    if($new_due_shop_id){
                        $olddue=new ShopBalance;
                        $olddue->sales_id=$sales->id;
                        $olddue->new_due_shop_id=$new_due_shop_id;
                        $olddue->new_due_tk=$request->new_due_tk[$i];
                        $olddue->save();
                    }
                }
            }
            if($request->new_receive_shop_id){
                foreach($request->new_receive_shop_id as $i=>$new_receive_shop_id){
                    if($new_receive_shop_id){
                        $olddue=new SalesPayment;
                        $olddue->sales_id=$sales->id;
                        $olddue->new_receive_shop_id=$new_receive_shop_id;
                        $olddue->new_receive_tk=$request->new_receive_tk[$i];
                        $olddue->save();
                    }
                }
            }
            if($request->check_shop_id){
                foreach($request->check_shop_id as $i=>$check_shop_id){
                    if($check_shop_id){
                        $olddue=new ShopBalance;
                        $olddue->sales_id=$sales->id;
                        $olddue->check_shop_id=$check_shop_id;
                        $olddue->check_shop_tk=$request->check_shop_tk[$i];
                        $olddue->check_date=$request->check_date[$i];
                        $olddue->save();
                    }
                }
            }

        }
        catch (Exception $e){
            dd($e);
            return back()->withInput();

        }
    }
    public function salesReceiveScreen($id)
    {
        $sales = TemporarySales::findOrFail(encryptor('decrypt',$id));
        $shops=Shop::all();
        $dsr=User::where('role_id',4)->get();
        return view('sales.salesClosing',compact('sales','shops','dsr'));
    }
    public function salesReceive(Request $request, $id)
    {
        try{
            $sales =new Sales;
            $sales->shop_id = $request->shop_id;
            $sales->dsr_id = $request->dsr_id;
            $sales->sales_date = $request->sales_date;

            $sales->expenses = $request->expenses;
            $sales->commission = $request->commission;
            $sales->final_total = $request->final_total;
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
                            $details->ctn_price=$request->ctn_price[$key];
                            $details->subtotal_price=$request->subtotal_price[$key];
                            $details->total_taka=$request->total_taka[$key];
                            // $details->select_tp_tpfree=$request->select_tp_tpfree[$key];
                            $details->company_id=company()['company_id'];
                            $details->updated_by= currentUserId();
                            $details->save();
                        }
                    }
                }
            }
            if($request->old_due_shop_id){
                foreach($request->old_due_shop_id as $i=>$old_due_shop_id){
                    if($old_due_shop_id){
                        $olddue=new ShopBalance;
                        $olddue->sales_id=$sales->id;
                        $olddue->old_due_shop_id=$old_due_shop_id;
                        $olddue->old_due_tk=$request->old_due_tk[$i];
                        $olddue->save();
                    }
                }
            }
            if($request->new_due_shop_id){
                foreach($request->new_due_shop_id as $i=>$new_due_shop_id){
                    if($new_due_shop_id){
                        $olddue=new ShopBalance;
                        $olddue->sales_id=$sales->id;
                        $olddue->new_due_shop_id=$new_due_shop_id;
                        $olddue->new_due_tk=$request->new_due_tk[$i];
                        $olddue->save();
                    }
                }
            }
            if($request->new_receive_shop_id){
                foreach($request->new_receive_shop_id as $i=>$new_receive_shop_id){
                    if($new_receive_shop_id){
                        $olddue=new ShopBalance;
                        $olddue->sales_id=$sales->id;
                        $olddue->new_receive_shop_id=$new_receive_shop_id;
                        $olddue->new_receive_tk=$request->new_receive_tk[$i];
                        $olddue->save();
                    }
                }
            }
            if($request->check_shop_id){
                foreach($request->check_shop_id as $i=>$check_shop_id){
                    if($check_shop_id){
                        $olddue=new ShopBalance;
                        $olddue->sales_id=$sales->id;
                        $olddue->check_shop_id=$check_shop_id;
                        $olddue->check_shop_tk=$request->check_shop_tk[$i];
                        $olddue->check_date=$request->check_date[$i];
                        $olddue->save();
                    }
                }
            }

        }
        catch (Exception $e){
            dd($e);
            return back()->withInput();

        }
    }


    public function destroy($id)
    {
        $data= TemporarySales::findOrFail(encryptor('decrypt',$id));
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
}
