<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\ShopBalance;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Traits\ImageHandleTraits;
use App\Models\Settings\Shop;
use Exception;

class ShopBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shops= ShopBalance::where(company())->orderBy('id','DESC');
        if($request->shop_id)
            $shops=$shops->where('shop_id',$request->shop_id);

        $shops=$shops->get();

        return view('settings.shopbalance.index',compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shops=Shop::select('id','shop_name','owner_name')->get();
        return view('settings.shopbalance.create',compact('shops'));
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
            $shop=new ShopBalance;
            $shop->shop_id=$request->shop_id;
            $shop->balance_amount=$request->balance_amount;
            $shop->new_due_date=$request->new_collect_date;
            $shop->company_id=company()['company_id'];
            $shop->status=1;
            $shop->save();
            Toastr::success('Create Successfully!');
            return redirect()->route(currentUser().'.shopbalance.index');
        }catch(Exception $e){
             //dd($e);
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
