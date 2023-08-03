<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;

use App\Models\Sales\Sales;
use App\Models\Sales\TemporarySales;
use App\Models\Sales\TemporarySalesDetails;
use App\Models\Settings\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Traits\ImageHandleTraits;
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
                            $details->ctn_price=$request->ctn_price[$key];
                            $details->subtotal_price=$request->subtotal_price[$key];
                            $details->company_id=company()['company_id'];
                            $details->created_by= currentUserId();
                            $details->save();
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


    public function update(Request $request, Sales $sales)
    {
        //
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
