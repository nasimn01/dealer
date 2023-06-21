@extends('layout.app')

@section('pageTitle',trans('Create Return Product'))
@section('pageSubTitle',trans('Create'))

@section('content')
  <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" enctype="multipart/form-data" action="{{route(currentUser().'.product.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="driver_name">{{__('Driver Name')}}</label>
                                            <input type="text" class="form-control" value="{{ old('driver_name')}}" name="driver_name">

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="helper">{{__('Helper')}}</label>
                                            <input type="text" class="form-control" value="{{ old('helper')}}" name="helper">

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="garir_number">{{__('Garir Number')}}</label>
                                            <input type="text" class="form-control" value="{{ old('garir_number')}}" name="garir_number">

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="invoice_number">{{__('Invoice Number')}}</label>
                                            <input type="text" class="form-control" value="{{ old('invoice_number')}}" name="invoice_number">

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="note">Note</label>
                                            <textarea class="form-control" name="note" rows="2">{{old('note')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="container" id="product">
                                    <main>
                                        <div class="row mt-3">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <label class="py-2" for="product">{{__('Product')}}<span class="text-danger">*</span></label>
                                                    <select class=" choices form-select" name="product_id[]">
                                                        <option value="">Select Product</option>
                                                        @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                                                        <option value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 qty">
                                                <label class="py-2" for="qty">{{__('CTN')}}<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="qty[]" onkeyup="get_price(this)">
                                            </div>
                                            <div class="col-lg-1 qty">
                                                <label class="py-2" for="qty">{{__('PCS')}}<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="qty[]" onkeyup="get_price(this)">
                                            </div>
                                            <div class="col-lg-2 totalPrice">
                                                <label class="py-2" for="unite_style">{{__('Unit Style')}}<span class="text-danger">*</span></label>
                                                <select class=" choices form-select" name="unite_style_id[]">
                                                    <option value="">Select style</option>
                                                    @forelse (\App\Models\Settings\Unit_style::all(); as $us)
                                                    <option value="{{ $us->id }}">{{ $us->name }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                                {{--  <label class="py-2" for="price">{{__('Total Price')}}<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="total_price[]" onkeyup="get_price(this)">  --}}
                                            </div>
                                            {{--  <div class="col-lg-1">
                                                <label class="py-2" for="free">{{__('Free')}}</label>
                                                <input type="number" class="form-control" name="free[]">
                                            </div>  --}}
                                            <div class="col-lg-2 buyPrice">
                                                <label class="py-2" for="price">{{__('DP Price')}}<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="price[]" placeholder="price" onkeyup="get_price(this)">
                                            </div>
                                            <div class="col-lg-2 buyPrice">
                                                <label class="py-2" for="price">{{__('Tp Price')}}<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="price[]" placeholder="price" onkeyup="get_price(this)">
                                            </div>
                                            <div class="col-lg-2 buyPrice">
                                                <label class="py-2" for="price">{{__('MRP Price')}}<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="price[]" placeholder="price" onkeyup="get_price(this)">
                                            </div>
                                            <div class="col-lg-2 ps-0 tamount">
                                                <label class="py-2" for="amount"><b>{{__('Remarks')}}</b></label><br>
                                                    <input type="number" class="form-control" name="amount[]" readonly="readonly">
                                                </div>
                                                <div class="col-lg-12 d-flex justify-content-end">
                                                <span onClick='remove_row();' class="delete-row text-danger"><i class="bi bi-trash-fill" style="font-size:1.5rem; color:rgb(230, 5, 5)"></i></span>
                                                <span onClick='add_row();' class="add-row text-primary"><i class="bi bi-plus-square-fill" style="font-size:1.5rem;"></i></span>
                                            </div>
                                        </div>
                                    </main>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>

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

