@extends('layout.app')

@section('pageTitle',trans('Create Do'))
@section('pageSubTitle',trans('Create'))

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
                        {{--  <form class="form" action="#" enctype="multipart/form-data">  --}}
                        <form class="form" method="post" action="{{route(currentUser().'.docontroll.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="form-group mb-3">
                                                <label class="py-2" for="cat">{{__('Distributor')}}<span class="text-danger">*</span></label>
                                                @if($user)
                                                    <select class="form-select supplier_id" name="supplier_id" required >
                                                        @forelse (App\Models\Settings\Supplier::where(company())->where('id',$user->distributor_id)->get() as $sup)
                                                            @php $balance=$sup->balances?->where('status',1)->sum('balance_amount') - $sup->balances?->where('status',0)->sum('balance_amount') @endphp
                                                            <option data-balance="{{ $balance }}" value="{{ $sup->id }}">{{ $sup->name }}</option>
                                                        @empty
                                                            <option value="">No Data Found</option>
                                                        @endforelse
                                                    </select>
                                                @else
                                                    <select class="form-select supplier_id" name="supplier_id" onchange="getBalance()" required>
                                                        <option value="">Select Distributor</option>
                                                        @forelse (App\Models\Settings\Supplier::where(company())->get() as $sup)
                                                            @php $balance=$sup->balances?->where('status',1)->sum('balance_amount') - $sup->balances?->where('status',0)->sum('balance_amount') @endphp
                                                            <option data-balance="{{ $balance }}" value="{{ $sup->id }}">{{ $sup->name }}</option>
                                                        @empty
                                                            <option value="">No Data Found</option>
                                                        @endforelse
                                                    </select>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="py-2" for="cat">{{__('Do Date')}}<span class="text-danger">*</span></label>
                                                <input required type="text" class="form-control" id="datepicker" name="do_date" placeholder="Day-Month-Year">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="py-2" for="cat">{{__('Pay Type')}}<span class="text-danger">*</span></label>
                                                <select class="form-control form-select" name="bill_id" required>
                                                    <option value="">Pay Type</option>
                                                    @forelse(App\Models\Settings\Bill_term::where(company())->get() as $bill)
                                                        <option value="{{ $bill->id }}">{{ $bill->name }}</option>
                                                    @empty
                                                        <option value="">No Data Found</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="py-2" for="cat">{{__('Reference Number')}}<span class="text-danger">*</span></label>
                                                <input required type="text" class="form-control" name="reference_num" placeholder="reference Number">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group mb-3">
                                                <label class="py-2" for="product">{{__('Product')}}<span class="text-danger">*</span></label>
                                                @if($user)
                                                    <select class=" choices form-select" id="product_id" onchange="getBalance()">
                                                        <option value="">Select Product</option>
                                                        @forelse (\App\Models\Product\Product::where(company())->where('distributor_id',$user->distributor_id)->get(); as $pro)
                                                        <option data-dp='{{ $pro->dp_price }}' data-name='{{ $pro->product_name }}' data-ratio='{{ $pro->free_ratio }}' data-free='{{ $pro->free }}' value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                @else
                                                    <select class=" choices form-select" id="product_id">
                                                        <option value="">Select Product</option>
                                                        @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                                                        <option data-dp='{{ $pro->dp_price }}' data-name='{{ $pro->product_name }}' data-ratio='{{ $pro->free_ratio }}' data-free='{{ $pro->free }}' value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group mb-3">
                                                <label class="py-2" for="q">{{__('Quantity')}}<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="qty">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12 mt-4">
                                            <div class="form-group mt-3">
                                                <button  type="button" class="btn btn-primary btn-sm add-row">Add</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12 mt-4">
                                            <div class="form-group">
                                                <p id="warning_message" class="text-danger"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <div class="border">
                                        <div class="form-group p-3">
                                            <p>Distributor balance: <span class="supbalance"> </span></p>
                                            <p>Do Amount: <span class="doamount"></span><input class="doamount_data" type="hidden" name="balance"></p>
                                            <p>R: <span class="subRemaining"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope="col">{{__('#SL')}}</th>
                                            <th scope="col">{{__('Product Name')}}</th>
                                            <th scope="col">{{__('Qty')}}</th>
                                            <th scope="col">{{__('Free Qty')}}</th>
                                            <th scope="col">{{__('DP')}}</th>
                                            <th scope="col">{{__('Amount')}}</th>
                                            <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBody"></tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-sm table-borderless ">
                                        <tbody>
                                            <tr>
                                                <td class="text-end"><h4>Total Qty</h4></td>
                                                <td><input readonly type="number" class="form-control total_qty" name="total_qty" value=""></td>
                                                <td class="text-end"><h4>Total Amount</h4></td>
                                                <td><input readonly type="number" class="form-control total_amount" name="total_amount" value=""></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <div class="col-lg-6 offset-3 d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary btn-block m-2 do_save">Save</button>
                                        <span class="do_save_message text-danger fw-bold"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
       let counter = 0;
        $('button.add-row').on('click', function() {
            if (!$('.supplier_id').val()) {
                $('.supplier_id').focus();
                return false;
            }
            let dp=$('#product_id').find(":selected").data('dp');
            let productName=$('#product_id').find(":selected").data('name');
            let freeRatio=$('#product_id').find(":selected").data('ratio');
            let freeQty=$('#product_id').find(":selected").data('free');
            let ProductId=$('#product_id').find(":selected").val();
            let product_id= $('#product_id').data('value');
            let qty = $('#qty').val();
            $.ajax({
                url: "{{route(currentUser().'.unit_data_get')}}",
                type: "GET",
                dataType: "json",
                data: { product_id:ProductId },
                success: function(data) {
                    //console.log(data);
                    var freeCount = (data / freeRatio) * freeQty;
                    var freeQtyCount = Math.floor(qty * freeCount);

                    if (productName  && qty) {
                        let total= (dp * qty);
                        let newRow = `
                            <tr class="text-center product_detail_tr${counter}">
                                <td>${counter + 1}</td>
                                <td>${productName}
                                    <input type="hidden" name="product_id[]" value="${product_id}">
                                    <button type="button" class="btn btn-primary btn-sm ms-3" data-bs-toggle="modal" data-bs-target="#modal${counter}">Click</button>
                                    <div class="modal fade" id="modal${counter}" tabindex="-1" role="dialog" aria-labelledby="modal${counter}Title" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="#modal${counter}Title">${productName}</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <form action="" method="get" class="detail_form${counter}">
                                                                    <table class="table table-inverse table-responsive">
                                                                        <thead class="thead-inverse">
                                                                            <tr>
                                                                                <td colspan="4">
                                                                                    <div class="col-md-12 text-center heading-block">
                                                                                        <h5 style="padding-top: 5px;">Product Free Ratio and Dp price Update</h5>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <div id="productFormContainer">

                                                                                    <input type="hidden" name="product_id" value="${ProductId}">
                                                                                    <tr>
                                                                                        <td>Free Ratio</td>
                                                                                        <td><input class="form-control" name="free_ratio" type="number" value="${freeRatio}"></td>
                                                                                        <td>Dp Price</td>
                                                                                        <td><input class="form-control" name="dp_price" type="number" value="${dp}"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Free Qty</td>
                                                                                        <td><input class="form-control" name="free" type="number" value="${freeQty}"></td>
                                                                                        <td></td>
                                                                                        <td><button onclick="saveData(this, '${product_id}','${counter}')" type="button" class="btn btn-primary">Update</button></td>
                                                                                    </tr>
                                                                            </div>
                                                                        </tbody>
                                                                    </table>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="qty${counter}"><span>${qty}</span>
                                    <input type="hidden" class="qty_sum" name="qty[]" value="${qty}">
                                </td>
                                <td class="free_qty${counter}"><span>${freeQtyCount}</span>
                                    <input type="hidden" class="qty_sum" name="free_qty[]" value="${freeQtyCount}">
                                </td>
                                <td class="dp_price${counter}"><span>${dp}</span>
                                    <input type="hidden" name="dp[]" value="${dp}">
                                </td>
                                <td class="sub_total${counter}"><span>${total}</span>
                                    <input type="hidden" class="sub_total" name="sub_total[]" value="${total}">
                                </td>
                                <td class="white-space-nowrap">
                                    <button class="btn btn-link text-danger fs-3" type="button" onClick="RemoveThis(this,'${product_id}')">
                                        <i class="bi bi-trash-fill" class=""></i>
                                    </button>
                                </td>
                            </tr>
                        `;

                        // Append new row to the table
                       $('#productTableBody').append(newRow);
                        // Increment counter
                        counter++;

                        $('#product_id').find(":selected").hide();
                        // Clear input fields
                        $('#product_id').val('');
                        $('#qty').val('');
                        totalAmount();     //calculate total do amount
                    }else{
                        const setTime=document.getElementById('warning_message');
                        setTime.innerHTML='**Give Product and Qty Value**';
                        setTimeout(  function () { setTime.innerHTML=''}  , 3000);
                        setTimeout(  function () { setTime.style.display='block'}  , 4000);

                    }
                },
            });


        });
    });

    function totalAmount(){
        var total=0;
        var totalQty=0;
        $('.sub_total').each(function(){
            total+=parseFloat($(this).val());
        });
        $('.qty_sum').each(function(){
            totalQty+=parseFloat($(this).val());
        });
        $('.doamount').text(total);
        $('.doamount_data').val(total);
        $('.total_amount').val(total);
        $('.total_qty').val(totalQty);
        supBalance=parseFloat($('.supbalance').text());

        if(total>supBalance){
            alert('You can not create do more then '+supBalance);
            $('.do_save').prop('disabled',true)
            $('.do_save_message').text('You can not create do more then '+supBalance)
        }else{
            $('.do_save').prop('disabled',false)
            $('.do_save_message').text('')
        }
        $('.subRemaining').text(supBalance-total);
       // alert(sub_total)
    }
    function RemoveThis(e,p_id){
        if (confirm("Are you sure you want to remove this Product?")) {
        $(e).closest('tr').remove();
        $('#product_id option[value="'+p_id+'"]').show();
        totalAmount();
        }
    }
    function saveData(e,product_id,c) {
        var form = $(e).parents('.detail_form'+c);
        //var url = form.attr('action');
        var formData = form.serialize();

        $.ajax({
            type: 'get',
            url: "{{route(currentUser().'.doscreenProductUp')}}",
            data: formData,
            success: function(response) {
                $("#modal" + c).modal('hide');
                //console.log(response);
                getProductData(e,product_id,c);
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    }

    function getProductData(e,product_id,c) {
        $.ajax({
            url: "{{ route(currentUser().'.get_ajax_productdata') }}",
            type: "GET",
            dataType: "json",
            data: { product_id: product_id },
            success: function (data) {
                var freeCount = (data.unit_qty / data.free_ratio) * (data.free);
                var Qty=$(e).parents('.product_detail_tr'+c).find('.qty'+c+' span').text();
                let totalsubAmount= (data.dp_price * Qty);
                freeQty=Math.floor(Qty*freeCount);
                $(e).parents('.product_detail_tr'+c).find('.dp_price'+c+' span').text(data.dp_price);
                $(e).parents('.product_detail_tr'+c).find('.dp_price'+c+' input').val(data.dp_price);
                $(e).parents('.product_detail_tr'+c).find('.free_qty'+c+' span').text(freeQty);
                $(e).parents('.product_detail_tr'+c).find('.free_qty'+c+' input').val(freeQty);
                $(e).parents('.product_detail_tr'+c).find('.sub_total'+c+' span').text(totalsubAmount);
                $(e).parents('.product_detail_tr'+c).find('.sub_total'+c+' input').val(totalsubAmount);
                totalAmount();
                //var freeQtyCount = Math.floor(qty * freeCount);
                //console.log(freeCount);
                //var dpPrice = data.dp_price;
                //var freeRatio = data.free_ratio;
                //console.log(data.unit);
                //console.log(freeRatio);
            },
            error: function () {
                console.error("Error fetching data from the server.");
            },
        });
    }
</script>
<script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
<script>
    getBalance()
    function getBalance(){
        var balance=$('.supplier_id option:selected').data('balance');
        $('.supbalance').text(balance);
    }
</script>


@endpush
