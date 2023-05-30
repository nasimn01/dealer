<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

use App\Models\Settings\Supplier;
use App\Models\Settings\Customer_balance;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Traits\ImageHandleTraits;
use App\Models\Settings\Supplier_balance;
use Exception;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $suppliers= Supplier::where(company())->orderBy('id','DESC');
        if($request->name)
            $suppliers=$suppliers->where('name','like','%'.$request->name.'%');
        if($request->supplier_code)
            $suppliers=$suppliers->where('supplier_code','like','%'.$request->supplier_code.'%');

        $suppliers=$suppliers->paginate(12);
        
        return view('settings.supplier.index',compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.supplier.create');
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
            $data=new Supplier;
            $data->supplier_code = $request->supplier_code;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->country = $request->country;
            $data->city = $request->city;
            $data->contact = $request->contact;
            $data->address = $request->address;
            $data->balance = $request->balance;
            
            $data->company_id=company()['company_id'];
            $data->created_by= currentUserId();

            if($data->save()){
                if($request->balance > 0 ){
                    $supb= new Supplier_balance;
                    $supb->supplier_id = $data->id;
                    $supb->balance_date = now();
                    $supb->balance_amount = $request->balance;
                    $supb->status = 1;
                    $supb->company_id=company()['company_id'];
                    $supb->save();
                }

            Toastr::success('Create Successfully!');
            return redirect()->route(currentUser().'.supplier.index');
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
     * @param  \App\Models\Settings\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settings\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail(encryptor('decrypt',$id));
        return view('settings.supplier.edit',compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Supplier::findOrFail(encryptor('decrypt',$id)); // Replace $supplierId with the actual ID of the supplier you want to update
        
            if (!$data) {
                Toastr::error('Supplier not found!');
                return redirect()->back();
            }
        
            $data->supplier_code = $request->supplier_code;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->country = $request->country;
            $data->city = $request->city;
            $data->contact = $request->contact;
            $data->address = $request->address;
            $data->balance = $request->balance;
        
            $data->company_id = company()['company_id'];
            $data->updated_by = currentUserId();
        
            if ($data->save()) {
                // Update supplier balance if the balance is greater than 0
                if ($request->balance == 0 || $request->balance == null) {
                    //$supb = Supplier_balance::where('supplier_id', $data->id)->first();
                    $supb= Supplier_balance::where('supplier_id',$data->id)->delete();
                }
                elseif ($request->balance > 0) {
                    $supb = Supplier_balance::where('supplier_id', $data->id)->first();
        
                    if (!$supb) {
                        $supb = new Supplier_balance;
                        $supb->supplier_id = $data->id;
                        $supb->company_id = company()['company_id'];
                    }
        
                    $supb->balance_date = now();
                    $supb->balance_amount = $request->balance;
                    $supb->status = 1;
        
                    $supb->save();
                }
        
                Toastr::success('Update Successfully!');
                return redirect()->route(currentUser().'.supplier.index');
            } else {
                Toastr::warning('Please try Again!');
                return redirect()->back();
            }
        } catch (Exception $e) {
            // dd($e);
            return back()->withInput();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
