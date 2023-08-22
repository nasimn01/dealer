@extends('layout.app')

@section('pageTitle',trans('Print Sales Closing'))
@section('pageSubTitle',trans('Show'))

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{route(currentUser().'.sales.receive')}}">
                            @csrf
                            <input type="hidden" value="{{ $sales->id }}" name="sales_id">
                            <div class="row p-2 mt-4">
                                @if (!empty($sales->shop_id))
                                <div class="col-lg-3 col-md-3 col-sm-6 mt-2 shopNameContainer">
                                    <label for=""><b>Shop Name</b></label>
                                    <select class="form-select" name="shop_id">
                                        <option value="">Select</option>
                                        @forelse($shops as $sh)
                                        <option value="{{$sh->id}}" {{ $sales->shop_id==$sh->id?"selected":""}}> {{ $sh->shop_name}}</option>
                                        @empty
                                            <option value="">No data found</option>
                                        @endforelse
                                    </select>
                                </div>
                                @endif

                                @if (!empty($sales->dsr_id))
                                    <div class="col-lg-3 col-md-3 col-sm-6 mt-2 dsrNameContainer">
                                        <label for=""><b>DSR Name</b></label>
                                        <select class="form-select" name="dsr_id">
                                            <option value="">Select</option>
                                            @forelse($dsr as $d)
                                            <option value="{{$d->id}}" {{ $sales->dsr_id==$d->id?"selected":""}}> {{ $d->name}}</option>
                                            @empty
                                                <option value="">No data found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                @endif
                                <div class="col-lg-3 col-md-3 col-sm-6 mt-2">
                                    <label for=""><b>Sales Date</b></label>
                                    <input type="text" id="datepicker" class="form-control" value="{{ $sales->sales_date }}"  name="sales_date" placeholder="mm-dd-yyyy">
                                </div>
                            </div>
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr class="text-center">
                                                <th rowspan="2">{{__('Product Name')}}</th>
                                                <th rowspan="2">{{__('CTN')}}</th>
                                                <th rowspan="2">{{__('PCS')}}</th>
                                                <th colspan="2">{{ __('Return') }}</th>
                                                <th colspan="2" class="text-danger">{{ __('Damage') }}</th>
                                                {{--  <th rowspan="2">{{__('TP/Tp Free')}}</th>  --}}
                                                <th rowspan="2">{{__('PCS(Price)')}}</th>
                                                {{--  <th rowspan="2">{{__('CTN(Price)')}}</th>  --}}
                                                <th rowspan="2">{{__('Sub-Total(Price)')}}</th>
                                                <th rowspan="2"></th>
                                            </tr>
                                            <tr>
                                                <th>CTN</th>
                                                <th>PCS</th>
                                                <th class="text-danger">CTN</th>
                                                <th class="text-danger">PCS</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sales_repeat">
                                            @if ($sales->temporary_sales_details)
                                                @foreach ($sales->temporary_sales_details as $salesdetails)
                                                    <tr>
                                                        <td>
                                                            <input readonly class="form-control" type="text" value="{{ $salesdetails->product?->product_name }}">
                                                            <input readonly class="form-control product_id" type="hidden" name="product_id[]" value="{{ $salesdetails->product_id }}">
                                                            {{--  <select class="choices form-select product_id" id="product_id" onchange="doData(this);" name="product_id[]">
                                                                <option value="">Select Product</option>
                                                                @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                                                                <option data-dp='{{ $pro->dp_price }}' value="{{ $pro->id }}" {{ old('product_id', $pro->id)==$salesdetails->product_id ? "selected":""}}>{{ $pro->product_name }}</option>
                                                                @empty
                                                                @endforelse
                                                            </select>  --}}
                                                        </td>
                                                        <td><input readonly class="form-control ctn" type="text" name="ctn[]" value="{{ old('ctn',$salesdetails->ctn) }}" placeholder="ctn"></td>
                                                        <td><input readonly class="form-control pcs" type="text" name="pcs[]"value="{{ old('pcs',$salesdetails->pcs) }}" placeholder="pcs"></td>
                                                        <td><input class="form-control ctn_return" type="text" onkeyup="getCtnQty(this)" name="ctn_return[]" value="" placeholder="ctn return"></td>
                                                        <td><input class="form-control pcs_return" type="text" onkeyup="getCtnQty(this)" name="pcs_return[]"value="" placeholder="pcs return"></td>
                                                        <td><input class="form-control ctn_damage" type="text" onkeyup="getCtnQty(this)" name="ctn_damage[]" value="" placeholder="ctn damage"></td>
                                                        <td><input class="form-control pcs_damage" type="text" onkeyup="getCtnQty(this)" name="pcs_damage[]"value="" placeholder="pcs damage"></td>
                                                        {{--  <td style="width: 110px;">
                                                            <select class="form-select" name="select_tp_tpfree">
                                                                <option value="">Select</option>
                                                                <option value="1" {{ old('select_tp_tpfree', $salesdetails->select_tp_tpfree)=="1" ? "selected":""}}>TP</option>
                                                                <option value="2" {{ old('select_tp_tpfree', $salesdetails->select_tp_tpfree)=="2" ? "selected":""}}>TP Free</option>
                                                            </select>
                                                        </td>  --}}
                                                        <td>
                                                            <input readonly class="form-control per_pcs_price" type="text" name="pcs_price[]" value="{{ old('pcs_price',$salesdetails->pcs_price) }}" placeholder="PCS Price">
                                                            <input class="form-control select_tp_tpfree" type="hidden" name="select_tp_tpfree[]" value="{{ $salesdetails->select_tp_tpfree }}">
                                                            @if($salesdetails->select_tp_tpfree==1)
                                                                <input class="form-control" type="hidden" name="price_type[]" value="1">
                                                            @else
                                                                <input class="form-control" type="hidden" name="price_type[]" value="2">
                                                            @endif
                                                            <input class="form-control" type="hidden" name="tp_price[]" value="{{ old('tp_price',$salesdetails->pcs_price) }}">

                                                            <input class="form-control total_return_pcs" type="hidden" name="total_return_pcs[]" value="">
                                                            <input class="form-control total_sales_pcs" type="hidden" name="total_sales_pcs[]" value="">
                                                        </td>
                                                        {{--  <td><input class="form-control" type="text" name="ctn_price[]" value="{{ old('ctn_price',$salesdetails->ctn_price) }}" placeholder="Ctn Price"></td>  --}}
                                                        <td><input readonly class="form-control subtotal_price" type="text" name="subtotal_price[]" value="{{ old('subtotal_price',$salesdetails->subtotal_price) }}" placeholder="Sub total"></td>
                                                        <td></td>
                                                    </tr>

                                                @endforeach
                                            @endif
                                            <tr>
                                                <td class="text-end" colspan="8"><h5 for="totaltk">{{__('Total Taka')}}</h5></td>
                                                <td class="text-end" colspan="9">
                                                    <input type="text" class="form-control ptotal_taka" value="{{ $sales->total }}" name="total_taka">
                                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot id="tfootSection">
                                            <tr>
                                                <td colspan="3">
                                                    <select class="choices form-select product_id" id="product_id" onchange="getCtnQty(this);" name="return_product_id[]">
                                                        <option value="">Select Product</option>
                                                        @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                                                        <option data-dp='{{ $pro->dp_price }}' value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td><input class="form-control old_ctn" type="text" onkeyup="getCtnQty(this)" name="old_ctn_return[]" value="" placeholder="ctn return"></td>
                                                <td><input class="form-control old_pcs" type="text" onkeyup="getCtnQty(this)" name="old_pcs_return[]" value="" placeholder="pcs return"></td>
                                                <td><input class="form-control old_ctn_damage" type="text" onkeyup="getCtnQty(this)" name="old_ctn_damage[]" value="" placeholder="ctn damage"></td>
                                                <td><input class="form-control old_pcs_damage" type="text" onkeyup="getCtnQty(this)" name="old_pcs_damage[]" value="" placeholder="pcs damage"></td>
                                                {{--  <td>
                                                    <select class="form-select" name="select_tp_tpfree">
                                                        <option value="">Select</option>
                                                        <option value="1">TP</option>
                                                        <option value="2">TP Free</option>
                                                    </select>
                                                </td>  --}}
                                                <td>
                                                    <input class="form-control old_pcs_price" type="text" onkeyup="getCtnQty(this)" name="old_pcs_price[]" value="" placeholder="PCS Price">
                                                    <input class="form-control old_total_return_pcs" type="hidden" name="old_total_return_pcs[]" value="">
                                                </td>
                                                {{--  <td><input class="form-control" type="text" name="ctn_price[]" value="" placeholder="Ctn Price"></td>  --}}
                                                <td><input class="form-control return_subtotal_price" type="text" onkeyup="return_total_calculate();" name="return_subtotal_price[]" value="" placeholder="Sub total"></td>
                                                <td>
                                                    <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
                                                    {{--  <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>  --}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end" colspan="8"><h5 for="return_total">{{__('Return Total Taka')}}</h5></td>
                                                <td class="text-end" colspan="9">
                                                    <input readonly type="text" class="form-control return_total_taka" value="0" name="return_total_taka">
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <div class="row olddue">
                                        <div class="col-lg-2 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <h5 for="check">{{__('Old Due')}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-3 col-sm-6 shopNameContainer">
                                            <select class="form-select old_due_shop_id" name="old_due_shop_id[]">
                                                <option value="">Select</option>
                                                @foreach (\App\Models\Settings\Shop::all(); as $shop)
                                                <option value="{{ $shop->id }}">{{ $shop->shop_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control old_due_tk" onkeyup="totalOldDue()" value="{{ old('old_due_tk')}}" name="old_due_tk[]" placeholder="Tk">
                                                <input type="hidden" class="form-control o_due_tk" value="0">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-6">
                                            <div class="form-group text-primary" style="font-size:1.5rem">
                                                 <span onClick='oldDue();'><i class="bi bi-plus-square-fill"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row newdue">
                                        <div class="col-lg-2 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <h5 for="check">{{__('new Due')}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-3 col-sm-6 shopNameContainer">
                                            <select class="form-select new_due_shop_id" name="new_due_shop_id[]">
                                                <option value="">Select</option>
                                                @foreach (\App\Models\Settings\Shop::all(); as $shop)
                                                <option value="{{ $shop->id }}">{{ $shop->shop_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control new_due_tk" onkeyup="totalNewDue()" value="{{ old('new_due_tk')}}" name="new_due_tk[]" placeholder="Tk">
                                                <input type="hidden" class="form-control n_due_tk" value="0">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-6">
                                            <div class="form-group text-primary" style="font-size:1.5rem">
                                                 <span onClick='newDue();'><i class="bi bi-plus-square-fill"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row new_receive">
                                        <div class="col-lg-2 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <h5 for="check">{{__('New Receive')}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-3 col-sm-6 shopNameContainer">
                                            <select class="form-select new_receive_shop_id" name="new_receive_shop_id[]">
                                                <option value="">Select</option>
                                                @foreach (\App\Models\Settings\Shop::all(); as $shop)
                                                <option value="{{ $shop->id }}">{{ $shop->shop_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control new_receive_tk" onkeyup="totalNewReceive()" value="{{ old('new_receive_tk')}}" name="new_receive_tk[]" placeholder="Tk">
                                                <input type="hidden" class="form-control n_receive_tk" value="0">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-6">
                                            <div class="form-group text-primary" style="font-size:1.5rem">
                                                 <span onClick='newReceive();'><i class="bi bi-plus-square-fill"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row check_no">
                                        <div class="col-lg-2 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <h5 for="check">{{__('Check')}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-3 col-sm-6 shopNameContainer">
                                            <select class="form-select check_shop_id" name="check_shop_id[]">
                                                <option value="">Select</option>
                                                @foreach (\App\Models\Settings\Shop::all(); as $shop)
                                                <option value="{{ $shop->id }}">{{ $shop->shop_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control check_shop_tk" onkeyup="totalNewCheck()" value="{{ old('check_shop_tk')}}" name="check_shop_tk[]" placeholder="Tk">
                                                <input type="hidden" class="form-control c_shop_tk" value="0">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <input type="date" class="form-control" value="{{ old('check_date')}}" name="check_date[]" placeholder="Date">
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-md-3 col-sm-6">
                                            <div class="form-group text-primary" style="font-size:1.5rem">
                                                 <span onClick='newCheck();'><i class="bi bi-plus-square-fill"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 col-sm-4">
                                            <div class="form-group">
                                                <h5 for="expenses">{{__('Expenses')}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-9 col-sm-8">
                                            <div class="form-group">
                                                <input type="text" class="form-control expenses_tk" onkeyup="FinalTotal()" value="{{ old('expenses')}}" name="expenses">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 col-sm-4">
                                            <div class="form-group">
                                                <h5 for="commission">{{__('Commission')}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-9 col-sm-8">
                                            <div class="form-group">
                                                <input type="text" class="form-control commission_tk" onkeyup="FinalTotal()" value="{{ old('commission')}}" name="commission">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 col-sm-4">
                                            <div class="form-group">
                                                <h5 for="total">{{__('Final Total')}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-9 col-sm-8">
                                            <div class="form-group">
                                                <input type="text" class="form-control final_total_tk" value="{{ old('final_total')}}" name="final_total">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end my-2">
                                {{--  <button type="submit" class="btn btn-primary">Save</button>  --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
