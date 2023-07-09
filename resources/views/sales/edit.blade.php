@extends('layout.app')

@section('pageTitle',trans('Sales Return'))
@section('pageSubTitle',trans('Return'))

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{route(currentUser().'.sales.update',1)}}">
                            @csrf
                            <div class="row p-2 mt-4">
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Sales</b></label>
                                    <select class="form-select" name="">
                                        <option value="">Select</option>
                                        <option value="1">Shop</option>
                                        <option value="2">DSR</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Sales Date</b></label>
                                    <input type="text" id="datepicker" class="form-control"  name="sales_date" placeholder="mm-dd-yyyy">
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
                                                <th colspan="2">{{ __('Damage') }}</th>
                                                <th rowspan="2">{{__('TP')}}</th>
                                                <th rowspan="2">{{__('TP(Price)')}}</th>
                                                {{--  <th rowspan="2">{{__('ACTION')}}</th>  --}}
                                            </tr>
                                            <tr>
                                                <th>CTN</th>
                                                <th>PCS</th>
                                                <th>CTN</th>
                                                <th>PCS</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sales_repeat">
                                            <tr>
                                                <td>
                                                    <select class="choices form-select product_id" id="product_id" onchange="doData(this);" name="product_id[]">
                                                        <option value="">Select Product</option>
                                                        @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                                                        <option data-dp='{{ $pro->dp_price }}' value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td><input class="form-control ctn" type="text" name="ctn[]" value="" placeholder="ctn"></td>
                                                <td><input class="form-control pcs" type="text" name="pcs[]"value="" placeholder="pcs"></td>
                                                <td><input class="form-control ctn" type="text" name="ctn[]" value="" placeholder="ctn return"></td>
                                                <td><input class="form-control pcs" type="text" name="pcs[]"value="" placeholder="pcs return"></td>
                                                <td><input class="form-control ctn" type="text" name="ctn[]" value="" placeholder="ctn damage"></td>
                                                <td><input class="form-control pcs" type="text" name="pcs[]"value="" placeholder="pcs damage"></td>
                                                <td>
                                                    <select class="form-select" name="">
                                                        <option value="">Select</option>
                                                        <option value="1">TP</option>
                                                        <option value="2">TP Free</option>
                                                    </select>
                                                </td>
                                                <td><input class="form-control" type="text" name="tp_price[]" value="" placeholder="Tp Price"></td>
                                                {{--  <td>
                                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                </td>  --}}
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                            <div class="form-group">
                                                <h5 for="totaltk">{{__('Total Taka')}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-8">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="{{ old('total_tk')}}" name="total_tk">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <h5 for="olddue">{{__('Old Due')}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <select class="form-select" name="">
                                                    <option value="">Shop</option>
                                                    <option value="1">kamal Store</option>
                                                    <option value="2">jamal Store</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="{{ old('total_tk')}}" name="total_tk" placeholder="Tk">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group text-primary" style="font-size:1.5rem">
                                                <i class="bi bi-plus-square-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <h5 for="newreceive">{{__('New Receive')}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <select class="form-select" name="">
                                                    <option value="">Shop</option>
                                                    <option value="1">kamal Store</option>
                                                    <option value="2">jamal Store</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="{{ old('total_tk')}}" name="total_tk" placeholder="Tk">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <h5 for="check">{{__('Check')}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <select class="form-select" name="">
                                                    <option value="">Shop</option>
                                                    <option value="1">kamal Store</option>
                                                    <option value="2">jamal Store</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="{{ old('total_tk')}}" name="total_tk" placeholder="Tk">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group text-primary" style="font-size:1.5rem">
                                                <i class="bi bi-plus-square-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                            <div class="form-group">
                                                <h5 for="expenses">{{__('Expenses')}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-8">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="{{ old('expenses')}}" name="expenses">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                            <div class="form-group">
                                                <h5 for="commission">{{__('Commission')}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-8">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="{{ old('commission')}}" name="commission">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                            <div class="form-group">
                                                <h5 for="total">{{__('Total')}}</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-8">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="{{ old('commission')}}" name="commission">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end my-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push("scripts")

@endpush
