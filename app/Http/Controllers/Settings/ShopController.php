<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

use App\Models\Settings\Shop;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Traits\ImageHandleTraits;
use App\Models\Settings\Supplier;
use App\Models\User;
use Exception;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $distributor = Supplier::where(company())->get();
        $userSr=User::where(company())->where('role_id',5)->get();
        $shop= Shop::where(company())->orderBy('id','DESC');
        if($request->shop_name)
            $shop=$shop->where('shop_name','like','%'.$request->shop_name.'%');
        if($request->owner_name)
            $shop=$shop->where('owner_name','like','%'.$request->owner_name.'%');
        if ($request->distributor_id)
            $shop->where('shops.sup_id',$request->distributor_id);
        if ($request->sr_id)
            $shop->where('shops.sr_id',$request->sr_id);

        $shop=$shop->paginate(20);

        return view('settings.shop.index',compact('shop','distributor','userSr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.shop.create');
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
            $shop=new Shop;
            $shop->shop_name = $request->shop_name;
            $shop->owner_name = $request->owner_name;
            $shop->area_name = $request->area_name;
            $shop->dsr_id = $request->dsr_id;
            $shop->sr_id = $request->sr_id;
            $shop->sup_id = $request->sup_id;
            $shop->contact = $request->contact;
            $shop->address = $request->address;
            $shop->balance = $request->balance;
            $shop->status = 0;
            $shop->company_id=company()['company_id'];
            $shop->created_by= currentUserId();
           $shop->save();
            Toastr::success('Create Successfully!');
            return redirect()->route(currentUser().'.shop.index');
        }
        catch (Exception $e){
             dd($e);
            return back()->withInput();

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settings\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settings\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop = Shop::findOrFail(encryptor('decrypt',$id));
        return view('settings.shop.edit',compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $shop=Shop::findOrFail(encryptor('decrypt',$id));
            $shop->shop_name = $request->shop_name;
            $shop->owner_name = $request->owner_name;
            $shop->area_name = $request->area_name;
            $shop->dsr_id = $request->dsr_id;
            $shop->sr_id = $request->sr_id;
            $shop->sup_id = $request->sup_id;
            $shop->contact = $request->contact;
            $shop->address = $request->address;
            $shop->balance = $request->balance;
            $shop->status = 0;
            $shop->company_id=company()['company_id'];
            $shop->created_by= currentUserId();
           $shop->save();
            Toastr::success('Update Successfully!');
            return redirect()->route(currentUser().'.shop.index');
        }
        catch (Exception $e){
             dd($e);
            return back()->withInput();

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shop=Shop::findOrFail(encryptor('decrypt',$id));
        $shop->delete();
        return redirect()->route(currentUser().'.shop.index');
    }
}
