@extends('layout.app')

@section('pageTitle',trans('Sales Create'))
@section('pageSubTitle',trans('Create'))

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{route(currentUser().'.sales.store')}}">
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
                                                <th scope="col">{{__('Product Name')}}</th>
                                                <th scope="col">{{__('CTN')}}</th>
                                                <th scope="col">{{__('PCS')}}</th>
                                                <th scope="col">{{__('TP')}}</th>
                                                <th scope="col">{{__('TP(Price)')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
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
                                                <td>
                                                    <select class="form-select" name="">
                                                        <option value="">Select</option>
                                                        <option value="1">TP</option>
                                                        <option value="2">TP Free</option>
                                                    </select>
                                                </td>
                                                <td><input class="form-control" type="text" name="tp_price[]" value="" placeholder="Tp Price"></td>
                                                <td>
                                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
<script>
    function addRow(){

var row=`<tr>
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
    <td>
        <select class="form-select" name="">
            <option value="">Select</option>
            <option value="1">TP</option>
            <option value="2">TP Free</option>
        </select>
    </td>
    <td><input class="form-control" type="text" name="tp_price[]" value="" placeholder="Tp Price"></td>
    <td>
        <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
        <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
    </td>
</tr>`;
    $('#sales_repeat').append(row);
}

function removeRow(e){
    $(e).closest('tr').remove();
}
</script>

@endpush
