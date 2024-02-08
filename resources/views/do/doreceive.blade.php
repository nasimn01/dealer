@extends('layout.app')

@section('pageTitle',trans('Receive Do'))
@section('pageSubTitle',trans('Receive'))

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" action="{{route(currentUser().'.do.accept_do_edit')}}">
                            @csrf
                            <div class="row p-2 mt-4">
                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Stock Date</b></label>
                                    <input type="text" required id="datepicker" class="form-control" value="<?php print(date("m/d/Y")); ?>"  name="stock_date" placeholder="mm-dd-yyyy">
                                </div>

                                <div class="col-lg-3 mt-2">
                                    <label for=""><b>Chalan NO<span class="text-danger">*</span></b></label>
                                    <input type="text" id="" required class="form-control"  name="chalan_no" placeholder="Chalan NO">
                                </div>
                            </div>
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0 table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">{{__('Product Name')}}</th>
                                                {{--  <th scope="col">{{__('Lot Number')}}</th>  --}}
                                                <th scope="col">{{__('Do Referance')}}</th>
                                                <th scope="col">{{__('CTN')}}</th>
                                                <th scope="col">{{__('PCS')}}</th>
                                                <th scope="col">{{__('Free')}}</th>
                                                <th scope="col">{{__('receive')}}</th>
                                                <th scope="col">{{__('Dp(CTN)')}} <span class="text-danger">*</span></th>
                                                <th scope="col">{{__('Dp(PCS)')}}</th>
                                                <th scope="col">{{__('SubTotal-Dp')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="product">
                                            <tr>
                                                <td>
                                                    <select class="form-select product_id" id="product_id" onchange="doData(this);" name="product_id[]">
                                                        <option value="">Select Product</option>
                                                        @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                                                        <option data-dp='{{ $pro->dp_price }}' data-tp='{{ $pro->tp_price }}' data-tp_free='{{ $pro->tp_free }}' data-mrp='{{ $pro->mrp_price }}' value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                    <input type="hidden" class="tp_price" name="tp_price[]">
                                                    <input type="hidden" class="tp_free" name="tp_free[]">
                                                    <input type="hidden" class="mrp_price" name="mrp_price[]">
                                                </td>
                                                <td>
                                                    <select class="form-select referance_number" value="" name="do_id[]">
                                                    </select>
                                                    <input type="hidden" class="dodetail_id" name="dodetail_id[]">
                                                </td>
                                                <td><input class="form-control ctn" type="text" name="ctn[]" onkeyup="getCtnQty(this)" value="" placeholder="ctn"></td>
                                                <td><input class="form-control pcs" type="text" name="pcs[]" onkeyup="getCtnQty(this)" value="" placeholder="pcs"></td>
                                                <td><input class="form-control free_pcs" type="text" name="free[]" onkeyup="getCtnQty(this)" value="" placeholder="free"></td>
                                                <td><input class="form-control receive" type="text" name="receive[]" value="" placeholder="receive"></td>
                                                <td><input required class="form-control dp" type="text" onkeyup="getCtnQty(this)" name="dp[]" value="" placeholder="dp"></td>
                                                <td><input readonly class="form-control dp_pcs" type="text" name="dp_pcs[]" value="" placeholder="dp PCS"></td>
                                                <td><input class="form-control subtotal_dp_pcs" type="text" name="subtotal_dp_pcs[]" value="" placeholder="total-dp-price"></td>
                                                <td>
                                                    {{--  <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>  --}}
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
        <select class="form-select product_id" id="product_id" onchange="doData(this);" name="product_id[]">
            <option value="">Select Product</option>
            @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
            <option data-dp='{{ $pro->dp_price }}' data-tp='{{ $pro->tp_price }}' data-tp_free='{{ $pro->tp_free }}' data-mrp='{{ $pro->mrp_price }}' value="{{ $pro->id }}">{{ $pro->product_name }}</option>
            @empty
            @endforelse
        </select>
        <input type="hidden" class="tp_price" name="tp_price[]">
        <input type="hidden" class="tp_free" name="tp_free[]">
        <input type="hidden" class="mrp_price" name="mrp_price[]">
    </td>
    <td>
        <select class="form-select referance_number" name="do_id[]">
        </select>
        <input type="hidden" class="dodetail_id" name="dodetail_id[]">
    </td>
    <td><input class="form-control ctn" type="text" name="ctn[]" onkeyup="getCtnQty(this)" value="" placeholder="ctn"></td>
    <td><input class="form-control pcs" type="text" name="pcs[]" onkeyup="getCtnQty(this)" value="" placeholder="pcs"></td>
    <td><input class="form-control free_pcs" type="text" name="free[]" onkeyup="getCtnQty(this)" value="" placeholder="free"></td>
    <td><input class="form-control receive" type="text" name="receive[]" value="" placeholder="receive"></td>
    <td><input required class="form-control dp" type="text" onkeyup="getCtnQty(this)" name="dp[]" value="" placeholder="dp"></td>
    <td><input readonly class="form-control dp_pcs" type="text" name="dp_pcs[]" value="" placeholder="dp PCS"></td>
    <td><input class="form-control subtotal_dp_pcs" type="text" name="subtotal_dp_pcs[]" value="" placeholder="total-dp-price"></td>
    <td>
        <span onClick='RemoveRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
        {{--  <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>  --}}
    </td>
</tr>`;
    $('#product').append(row);
}

function RemoveRow(e) {
    if (confirm("Are you sure you want to remove this row?")) {
        $(e).closest('tr').remove();
    }
}

</script>
<script>
    function doData(e) {
        let product_id = $(e).closest('tr').find('.product_id').val();
        let cn = $(e).closest('tr').find('.ctn').val() ? parseFloat($(e).closest('tr').find('.ctn').val()) : 0;
        let dp=$(e).find('option:selected').data('dp');
        $(e).closest('tr').find('.dp').val(dp);
        let tpPrice = $(e).closest('tr').find('.product_id option:selected').attr('data-tp');
        $(e).closest('tr').find('.tp_price').val(tpPrice);
        let tpFree = $(e).closest('tr').find('.product_id option:selected').attr('data-tp_free');
        $(e).closest('tr').find('.tp_free').val(tpFree);
        let mrpPrice = $(e).closest('tr').find('.product_id option:selected').attr('data-mrp');
        $(e).closest('tr').find('.mrp_price').val(mrpPrice);
        $.ajax({
            url: "{{ route(currentUser().'.do_data_get') }}",
            type: "GET",
            dataType: "json",
            data: { product_id: product_id },
            success: function (dodata) {
                //console.log(dodata);
                let selectElement = $(e).closest('tr').find('.referance_number');
                let dodetailIdInput = $(e).closest('tr').find('.dodetail_id');

                selectElement.empty(); // Clear previous options

                $.each(dodata, function (index, value) {
                    selectElement.append('<option value="' + value.do_id + '" data-dodetail_id="' + value.dodetail_id + '">' + value.reference_num + '</option>');
                });

                selectElement.on('change', function () {
                    let selectedOption = $(this).find('option:selected');
                    let dodetailId = selectedOption.data('dodetail_id');
                    dodetailIdInput.val(dodetailId);
                });

                selectElement.trigger('change'); // Initialize the input field
            },
        });
    }



    {{--  function doData(e) {
        let product_id = $(e).closest('tr').find('.product_id').val();
        let cn=$(e).closest('tr').find('.ctn').val()?parseFloat($(e).closest('tr').find('.ctn').val()):0;

        $.ajax({
            url: "{{ route(currentUser().'.do_data_get') }}",
            type: "GET",
            dataType: "json",
            data: { product_id: product_id },
            success: function(dodata) {
                console.log(dodata);
                let selectElement = $(e).closest('tr').find('.referance_number');
                selectElement.empty(); // Clear previous options

                $.each(dodata, function(index, value) {
                    selectElement.append('<option value="' + value + '">' + value + '</option>');
                });
                let dp=$(e).find('option:selected').data('dp');
                $(e).closest('tr').find('.dp').val(dp);
            },
        });
    }  --}}

    function getCtnQty(e){

        let product_id = $(e).closest('tr').find('.product_id').val();
        let cn=$(e).closest('tr').find('.ctn').val()?parseFloat($(e).closest('tr').find('.ctn').val()):0;
        let pcs=$(e).closest('tr').find('.pcs').val()?parseFloat($(e).closest('tr').find('.pcs').val()):0;
        let freePcs=$(e).closest('tr').find('.free_pcs').val()?parseFloat($(e).closest('tr').find('.free_pcs').val()):0;
        let dpPrice=$(e).closest('tr').find('.dp').val()?parseFloat($(e).closest('tr').find('.dp').val()):0;
        $(e).closest('tr').find('.receive').val(pcs);
        $.ajax({
            url: "{{route(currentUser().'.unit_data_get')}}",
            type: "GET",
            dataType: "json",
            data: { product_id:product_id },
            success: function(data) {
                console.log(data);
                let dpPcs=parseFloat(dpPrice/data).toFixed(2);
                let total=(cn*data)+pcs;
                totalReceive=(total+freePcs);
                let subTotal=parseFloat(total*dpPcs).toFixed(2);
                $(e).closest('tr').find('.dp_pcs').val(dpPcs);
                $(e).closest('tr').find('.subtotal_dp_pcs').val(subTotal);
                $(e).closest('tr').find('.receive').val(totalReceive);
               // changeDp(e,total);

            },
        });
    }
    {{--  function changeDp(e, total) {
        let cdp = $(e).closest('tr').find('.dp_pcs').val();
        csubtotal = cdp * total;
        $(e).closest('tr').find('.subtotal_dp_pcs').val(csubtotal);
    }  --}}

</script>

@endpush
