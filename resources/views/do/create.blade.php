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
                                                <select class="choices form-select supplier_id" name="supplier_id" onchange="getBalance()" required>
                                                    <option value="">Select Distributor</option>
                                                    @forelse (App\Models\Settings\Supplier::where(company())->get() as $sup)
                                                        @php $balance=$sup->balances?->where('status',1)->sum('balance_amount') - $sup->balances?->where('status',0)->sum('balance_amount') @endphp
                                                        <option data-balance="{{ $balance }}" value="{{ $sup->id }}">{{ $sup->name }}</option>
                                                    @empty
                                                        <option value="">No Data Found</option>
                                                    @endforelse
                                                </select>
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
                                                <select class=" choices form-select" id="product_id">
                                                    <option value="">Select Product</option>
                                                    @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                                                    <option data-dp='{{ $pro->dp_price }}' data-name='{{ $pro->product_name }}' data-ratio='{{ $pro->free_ratio }}' data-free='{{ $pro->free }}' value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
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
                                            <p>supplier balance: <span class="supbalance"> </span></p>
                                            <p>Do Amount: <span class="doamount"></span></p>
                                            <p>R: <span class="subRemaining"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
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
                                        <button type="submit" class="btn btn-primary btn-block m-2">Save</button>
                                        <a class="btn btn-info btn-block m-2">Save & Print</a>
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
            let dp=$('#product_id').find(":selected").data('dp');
            let productName=$('#product_id').find(":selected").data('name');
            let freeRatio=$('#product_id').find(":selected").data('ratio');
            let freeQty=$('#product_id').find(":selected").data('free');
            let ProductId=$('#product_id').find(":selected").val();
            let product_id= $('#product_id').val();
            let qty = $('#qty').val();
            $.ajax({
                url: "{{route(currentUser().'.unit_data_get')}}",
                type: "GET",
                dataType: "json",
                data: { product_id:ProductId },
                success: function(data) {
                    var freeCount = (data / freeRatio) * freeQty;
                    freeQtyCount = Math.floor(qty * freeCount);
                    //console.log(freeQtyCount);

                    if (productName  && qty) {
                        let total= (dp * qty);
                        let newRow = `
                            <tr class="text-center">
                                <td>${counter + 1}</td>
                                <td>${productName}
                                    <input type="hidden" name="product_id[]" value="${product_id}">
                                    <button type="button" class="btn btn-primary btn-sm ms-3" data-bs-toggle="modal" data-bs-target="#modal${product_id}">Click</button>
                                    <div class="modal fade" id="modal${product_id}" tabindex="-1" role="dialog" aria-labelledby="modal${product_id}Title" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="#modal${product_id}Title">${productName}</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-md-12">
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
                                                                            <form action="" method="post">

                                                                                <input type="hidden" id="product_id" name="product_id" value="${ProductId}">
                                                                                <tr>
                                                                                    <td>Free Ratio</td>
                                                                                    <td><input class="form-control" name="free_ratio" type="number" value="${freeRatio}"></td>
                                                                                    <td>Dp Price</td>
                                                                                    <td><input class="form-control" name="dp_price" type="number" value="${dp}"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td></td>
                                                                                    <td><button onclick="saveData(this)" type="button" class="btn btn-primary">Update</button></td>
                                                                                </tr>
                                                                            </form>
                                                                        </div>
                                                                    </tbody>
                                                                </table>
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
                                <td>${qty}
                                    <input type="hidden" class="qty" name="qty[]" value="${qty}">
                                </td>
                                <td>${freeQtyCount}
                                    <input type="hidden" class="qty" name="free_qty[]" value="${freeQtyCount}">
                                </td>
                                <td>${dp}
                                    <input type="hidden" name="dp[]" value="${dp}">
                                </td>
                                <td>${total}
                                    <input type="hidden" class="sub_total" name="sub_total[]" value="${total}">
                                </td>
                                <td class="white-space-nowrap">
                                    <button class="btn btn-link text-danger fs-3" type="button" onClick="RemoveThis(this)">
                                        <i class="bi bi-trash-fill" class=""></i>
                                    </button>
                                </td>
                            </tr>
                        `;

                        // Append new row to the table
                       $('#productTableBody').append(newRow);
                        // Increment counter
                        counter++;

                        $('#product_id').find(":selected").remove();
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
        $('.qty').each(function(){
            totalQty+=parseFloat($(this).val());
        });
        $('.doamount').text(total);
        $('.total_amount').val(total);
        $('.total_qty').val(totalQty);
        supBalance=parseFloat($('.supbalance').text());

        if(total>supBalance){
            alert('You can not create do more then '+supBalance);
        }
        $('.subRemaining').text(supBalance-total);
       // alert(sub_total)
    }
    function RemoveThis(e){
        $(e).closest('tr').remove();
        totalAmount();
    }
</script>
<script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
<script>
    function getBalance(){
        var balance=$('.supplier_id option:selected').data('balance');
        $('.supbalance').text(balance);
    }
</script>
<script>
    function saveData(e) {
        var form = $(e).closest('form');
        //var url = form.attr('action');
        var formData = form.serialize();

        $.ajax({
            type: 'get',
            url: "{{route(currentUser().'.doscreenProductUp')}}",
            data: formData,
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    }

</script>

@endpush
