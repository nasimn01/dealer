<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

use App\Models\Settings\Unit_style;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Traits\ImageHandleTraits;
use Exception;

class UnitStyleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $unitstyles= Unit_style::orderBy('id','asc');
        if($request->name)
            $unitstyles=$unitstyles->where('name','like','%'.$request->name.'%');

        $unitstyles=$unitstyles->paginate(12);
        return view('settings.unitstyle.index',compact('unitstyles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.unitstyle.create');
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
            $data=new Unit_style;
            $data->name = $request->name;
            $data->status=1;
        
            $data->created_by= currentUserId();

            if($data->save()){
            Toastr::success('Create Successfully!');
            return redirect()->route(currentUser().'.unitstyle.index');
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
     * @param  \App\Models\Settings\Unit_style  $unit_style
     * @return \Illuminate\Http\Response
     */
    public function show(Unit_style $unit_style)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settings\Unit_style  $unit_style
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unitstyle= Unit_style::findOrFail(encryptor('decrypt',$id));
        return view('settings.unitstyle.edit',compact('unitstyle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings\Unit_style  $unit_style
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $data= Unit_style::findOrFail(encryptor('decrypt',$id));
            $data->name = $request->name;
            $data->status = $request->status;
        
            $data->updated_by= currentUserId();

            if($data->save()){
            Toastr::success('Update Successfully!');
            return redirect()->route(currentUser().'.unitstyle.index');
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings\Unit_style  $unit_style
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit_style $unit_style)
    {
        //
    }
}
