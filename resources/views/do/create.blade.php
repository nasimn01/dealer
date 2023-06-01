@extends('layout.app')

@section('pageTitle',trans('Create Do'))
@section('pageSubTitle',trans('Create'))

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" action="{{route(currentUser().'.docon.store')}}">
                            @csrf
                            <div class="row">
                                <h5>Details</h5>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group mb-3">
                                        <label class="py-2" for="cat">{{__('Supplier')}}<span class="text-danger">*</span></label>
                                        <select class=" choices form-select" name="supplier_id">
                                            <option value="">Select Suppliers</option>
                                            @forelse (App\Models\Settings\Supplier::where(company())->get();  as $sup)
                                            <option value="{{ $sup->id }}">{{ $sup->name }}</option>

                                            @empty
                                            <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="py-2" for="cat">{{__('Bill Terms')}}<span class="text-danger">*</span></label>
                                        <select class="form-control form-select" name="bill_id">
                                            <option value="">Bill Terms</option>
                                            @forelse(App\Models\Settings\Bill_term::where(company())->get(); as $bill)
                                            <option value="{{ $bill->id }}">{{ $bill->name }}</option>
                                            @empty
                                            <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="py-2" for="cat">{{__('Do Date')}}<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="do_date"placeholder="Day-Month-Year" required>
                                    </div>
                                </div>
                            </div>
                            <div class="container" id="product">
                                <main>
                                    <div class="row mt-3">
                                        <div class="col-lg-12">
                                            <div class="form-group mb-3">
                                                <label class="py-2" for="product">{{__('Product')}}<span class="text-danger">*</span></label>
                                                <select class=" choices form-select" name="product_id">
                                                    <option value="">Select Product</option>
                                                    @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                                                    <option value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group mb-3">
                                                <label class="py-2" for="qty">{{__('Quantity')}}<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="qty">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group mb-3">
                                                <label class="py-2" for="price">{{__('Total Price')}}<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="total_price">
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group mb-3">
                                                <label class="py-2" for="free">{{__('Free')}}</label>
                                                <input type="text" class="form-control" name="free">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group mb-3">
                                                <label class="py-2" for="price">{{__('Price')}}<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="price" placeholder="price">
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group mb-3">
                                                <label class="py-2" for="basic">{{__('Basic')}}<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="basic">
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group mb-3">
                                                <label class="py-2" for="discount">{{__('Dis%')}}</label>
                                                <input type="text" class="form-control" name="discount_percent">
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group mb-3">
                                                <label class="py-2" for="tax">{{__('Tax%')}}</label>
                                                <input type="text" class="form-control" name="vat_percent">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 ps-0">
                                            <label class="py-2" for="amount"><b>{{__('Amount')}}</b></label><br>
                                            <div class="form-group mb-3 d-flex justify-content-between">
                                                <input type="text" class="form-control p-0" name="amount" readonly style="width:82%;display:inline-block">
                                                {{-- <a  href=""><i class="bi bi-trash-fill" style="font-size:1.5rem; color:rgb(230, 5, 5)"></i></a> --}}

                                                <span onClick='remove_row();' class="delete-row text-danger"><i class="bi bi-trash-fill" style="font-size:1.5rem; color:rgb(230, 5, 5)"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 d-flex justify-content-end">
                                            <span onClick='add_row();' class="add-row text-primary"><i class="bi bi-plus-square-fill" style="font-size:2rem;"></i></span>
                                        </div>
                                    </div>
                                </main>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="header-title">Total Bill</h4>
                                    <div class="total-payment">
                                        <table class="table table-sm table-borderless ">
                                            <tbody>
                                                <tr>
                                                    <td width="20%">Subtotal</td>
                                                    <td width="2%">:</td>
                                                    <td width="78%"><input type="text" class="form-control" name="sub_total"></td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">Vat/Tax</td>
                                                    <td width="2%">:</td>
                                                    <td width="78%"><input type="text" class="form-control" name="vat_amount"></td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">Discount</td>
                                                    <td width="2%">:</td>
                                                    <td width="78%"><input type="text" class="form-control" name="discount_amount"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-6 " style="margin-top: 2.3rem">
                                    <div class="total">
                                        <table class="table table-sm table-borderless ">
                                            <tbody>
                                                {{-- <tr>
                                                    <td><h4>Total</h4></td>
                                                    <td><input type="text" class="form-control" name="" value="0"></td>
                                                </tr> --}}
                                                <tr>
                                                    <td width="20%">Other Charge</td>
                                                    <td width="2%">:</td>
                                                    <td width="78%"><input type="text" class="form-control" name="other_charge"></td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">Paid</td>
                                                    <td width="2%">:</td>
                                                    <td width="78%"><input type="text" class="form-control" name="paid"></td>
                                                </tr>
                                                <tr>
                                                    <td width="20%">Change/Due</td>
                                                    <td width="2%">:</td>
                                                    <td width="78%"><input type="text" class="form-control" name="due"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <table class="table table-sm table-borderless ">
                                        <tbody>
                                            <tr>
                                                <td class="text-end"><h4>Total</h4></td>
                                                <td><input type="text" class="form-control" name="total" value="0"></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <div class="col-lg-6 offset-3 d-flex justify-content-between">
                                        <a class="btn btn-primary btn-block m-2" href="">Save</a>
                                        <a class="btn btn-info btn-block m-2" href="">Save & Print</a>
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
<script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-element-select.js') }}"></script>
<script>
    function add_row(){

var row=`<main>
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <label class="py-2" for="product">{{__('Product')}}<span class="text-danger">*</span></label>
                <select class=" choices form-select" name="product">
                    <option value="">Select Product</option>
                    <option value="1">common supplier</option>
                    <option value="1">regular</option>
                </select>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group mb-3">
                <label class="py-2" for="qty">{{__('Quantity')}}<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="qty">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group mb-3">
                <label class="py-2" for="price">{{__('Total Price')}}<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="total_price">
            </div>
        </div>
        <div class="col-lg-1">
            <div class="form-group mb-3">
                <label class="py-2" for="free">{{__('Free')}}</label>
                <input type="text" class="form-control" name="free">
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group mb-3">
                <label class="py-2" for="price">{{__('Price')}}<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="price" placeholder="price">
            </div>
        </div>
        <div class="col-lg-1">
            <div class="form-group mb-3">
                <label class="py-2" for="basic">{{__('Basic')}}<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="basic">
            </div>
        </div>
        <div class="col-lg-1">
            <div class="form-group mb-3">
                <label class="py-2" for="discount">{{__('Dis%')}}</label>
                <input type="text" class="form-control" name="discount">
            </div>
        </div>
        <div class="col-lg-1">
            <div class="form-group mb-3">
                <label class="py-2" for="tax">{{__('Tax%')}}</label>
                <input type="text" class="form-control" name="tax">
            </div>
        </div>
        <div class="col-lg-2 ps-0">
            <label class="py-2" for="amount"><b>{{__('Amount')}}</b></label><br>
            <div class="form-group mb-3 d-flex justify-content-between">
                <input type="text" class="form-control p-0" name="amount" readonly style="width:82%;display:inline-block">
                {{-- <a  href=""><i class="bi bi-trash-fill" style="font-size:1.5rem; color:rgb(230, 5, 5)"></i></a> --}}

                <span onClick='remove_row();' class="delete-row text-danger"><i class="bi bi-trash-fill" style="font-size:1.5rem; color:rgb(230, 5, 5)"></i></span>
            </div>
        </div>
    </div>
</main>`;
    $('#product').append(row);
}

function remove_row(){
    $('#product main').last().remove();
}
</script>

@endpush
