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
                                <div class="col-lg-3 col-md-3 col-sm-6 mt-2">
                                    <label for=""><b>Shop/Dsr</b></label>
                                    <select class="form-select shop_dsr" onclick="getShopDsr()" name="select_shop_dsr">
                                        <option value="">Select</option>
                                        <option value="shop">Shop</option>
                                        <option value="dsr">DSR</option>
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-6 mt-2 shopNameContainer" style="display: none;">
                                    <label for=""><b>Shop Name</b></label>
                                    <select class="form-select" name="shop_name">
                                        <option value="">Select</option>
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-6 mt-2 dsrNameContainer" style="display: none;">
                                    <label for=""><b>DSR Name</b></label>
                                    <select class="form-select" name="dsr_name">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 mt-2">
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
                                                <th rowspan="2">{{__('ACTION')}}</th>
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
                                                <td>
                                                    <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
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
                                            <select class="form-select shop_dsr" onclick="getShopDsr()" name="select_shop_dsr">
                                                <option value="">Select</option>
                                                <option value="shop">Shop</option>
                                                <option value="dsr">DSR</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-6 shopNameContainer" id="" style="display: none;">
                                            <select class="form-select" name="shop_name">
                                                <option value="">Select</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-6 dsrNameContainer" id="" style="display: none;">
                                            <select class="form-select" name="dsr_name">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="{{ old('total_tk')}}" name="total_tk" placeholder="Tk">
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-6">
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
                                        <div class="col-lg-3 col-md-3 col-sm-6 mt-2 shop_dsr">
                                            <select class="form-select " onclick="getShopDsr(this)" name="select_shop_dsr">
                                                <option value="">Select</option>
                                                <option value="shop">Shop</option>
                                                <option value="dsr">DSR</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-6 mt-2 shopNameContainer" style="display: none;">
                                            <select class="form-select" name="shop_name">
                                                <option value="">Select</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-6 mt-2 dsrNameContainer" style="display: none;">
                                            <select class="form-select" name="dsr_name">
                                                <option value="">Select</option>
                                            </select>
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
                                        <div class="col-lg-3 col-md-3 col-sm-6 shop_dsr">
                                            <select class="form-select "onclick="getShopDsr(this)" name="select_shop_dsr">
                                                <option value="">Select</option>
                                                <option value="shop">Shop</option>
                                                <option value="dsr">DSR</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-6 shopNameContainer" style="display: none;">
                                            <select class="form-select shop_name" name="shop_name">
                                                <option value="">Select</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-3 col-md-3 col-sm-6 dsrNameContainer" style="display: none;">
                                            <select class="form-select dsr_name" name="dsr_name">
                                                <option value="">Select</option>
                                            </select>
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
<script>
    {{--  function getShopDsr() {
        var selectedOption = document.querySelector('.shop_dsr option:checked').value;


        var shopNameContainer = document.getElementsByClassName("shopNameContainer");
        var dsrNameContainer = document.getElementsByClassName("dsrNameContainer");

        if (selectedOption === "shop") {
            shopNameContainer.style.display = "block";
            dsrNameContainer.style.display = "none";
            getShopData();
        } else if (selectedOption === "dsr") {
            shopNameContainer.style.display = "none";
            dsrNameContainer.style.display = "block";
            getDsrData();
        } else {
            shopNameContainer.style.display = "none";
            dsrNameContainer.style.display = "none";
        }
    }  --}}
    function getShopDsr(e) {
        var selectedOption = e.value;
        var parentContainer = e.closest('.shop_dsr');
        var shopNameContainer = parentContainer.nextElementSibling;
        var dsrNameContainer = shopNameContainer.nextElementSibling;

        if (selectedOption === "shop") {
            shopNameContainer.style.display = "block";
            dsrNameContainer.style.display = "none";
            getShopData();
        } else if (selectedOption === "dsr") {
            shopNameContainer.style.display = "none";
            dsrNameContainer.style.display = "block";
            getDsrData();
        } else {
            shopNameContainer.style.display = "none";
            dsrNameContainer.style.display = "none";
        }
    }
    function getShopData() {
        $.ajax({
            url: "{{ route(currentUser().'.get_shop') }}",
            type: "GET",
            dataType: "json",
            success: function(data) {
                populateShopOptions(data);
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    }

    function getDsrData() {
        $.ajax({
            url: "{{ route(currentUser().'.get_dsr') }}",
            type: "GET",
            dataType: "json",
            success: function(data) {
                populateDsrOptions(data);
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    }

    {{--  function populateShopOptions(data) {
        var selectElement = document.querySelector('select[name="shop_name"]');
        selectElement.innerHTML = "";

        data.forEach(function(shop) {
            var option = document.createElement("option");
            option.value = shop.id;
            option.textContent = shop.shop_name;
            console.log(option)
            selectElement.appendChild(option);
        });
    }  --}}
    function populateShopOptions(data) {
        var selectElements = document.querySelectorAll('.form-select.shop_name');

        selectElements.forEach(function(selectElement) {
            selectElement.innerHTML = "";

            data.forEach(function(shop) {
                var option = document.createElement("option");
                option.value = shop.id;
                option.textContent = shop.shop_name;
                selectElement.appendChild(option);
            });
        });
    }


    function populateDsrOptions(data) {
        var selectElements = document.querySelectorAll('.form-select.dsr_name');
        selectElements.forEach(function(selectElement) {
            selectElement.innerHTML = "";

        data.forEach(function(dsr) {
            var option = document.createElement("option");
            option.value = dsr.id;
            option.textContent = dsr.name;
            selectElement.appendChild(option);
        });
        });
    }

</script>
@endpush
