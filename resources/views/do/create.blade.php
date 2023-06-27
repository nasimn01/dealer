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
                        <form class="form" action="#" enctype="multipart/form-data">
                        {{--  <form class="form" method="post" action="{{route(currentUser().'.docontroll.store')}}" enctype="multipart/form-data">  --}}
                            @csrf
                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-9">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group mb-3">
                                                <label class="py-2" for="cat">{{__('Supplier')}}<span class="text-danger">*</span></label>
                                                <select class="choices form-select" name="supplier_id">
                                                    <option value="">Select Suppliers</option>
                                                    @forelse (App\Models\Settings\Supplier::where(company())->get() as $sup)
                                                        <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                                    @empty
                                                        <option value="">No Data Found</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="py-2" for="cat">{{__('Do Date')}}<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="datepicker" name="do_date" placeholder="Day-Month-Year">
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="py-2" for="cat">{{__('Pay Type')}}<span class="text-danger">*</span></label>
                                                <select class="form-control form-select" name="bill_id">
                                                    <option value="">Pay Type</option>
                                                    @forelse(App\Models\Settings\Bill_term::where(company())->get() as $bill)
                                                        <option value="{{ $bill->id }}">{{ $bill->name }}</option>
                                                    @empty
                                                        <option value="">No Data Found</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group mb-3">
                                                <label class="py-2" for="product">{{__('Product')}}<span class="text-danger">*</span></label>
                                                <select class=" choices form-select" id="product_id">
                                                    <option value="">Select Product</option>
                                                    @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                                                    <option data-dp='{{ $pro->dp_price }}' data-name='{{ $pro->product_name }}' value="{{ $pro->id }}">{{ $pro->product_name }}</option>
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
                                            <p>supplier balance: 50000</p>
                                            <p>Do taka: 20000</p>
                                            <p>R: 30000</p>
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
                                                <td class="text-end"><h4>Total</h4></td>
                                                <td><input type="number" class="form-control ttotal" name="total" onkeyup="cal_final_amount()" value="0"></td>
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

            let product_id= $('#product_id').val();
            let qty = $('#qty').val();

            if (productName  && qty) {
                let total= (dp * qty);
                let newRow = `
                    <tr class="text-center">
                        <td>${counter + 1}</td>
                        <td>${productName}
                            <input type="hidden" name="product_id[]" value="${product_id}">
                        </td>
                        <td>${qty}
                            <input type="hidden" name="qty[]" value="${qty}">
                        </td>
                        <td>${dp}
                            <input type="hidden" name="dp[]" value="${dp}">
                        </td>
                        <td>${total}
                            <input type="hidden" name="sub_total[]" value="${total}">
                        </td>
                        <td class="white-space-nowrap">
                            <a href="#">
                                <i class="bi bi-trash-fill" style="font-size:1.5rem; color:rgb(230, 5, 5)"></i>
                            </a>
                        </td>
                    </tr>
                `;

                // Append new row to the table
               $('#productTableBody').append(newRow);
                // Increment counter
                counter++;

                // Clear input fields
                $('#product_id').val('');
                $('#qty').val('');
            }else{
                const settim=document.getElementById('warning_message');
                settim.innerHTML='**Give Product and Qty Value**';
                setTimeout(  function () { settim.innerHTML=''}  , 3000);
                setTimeout(  function () { settim.style.display='block'}  , 4000);

            }
        });
    });

</script>
<script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>

@endpush
