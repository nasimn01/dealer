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
                                    <label for=""><b>Shop/Dsr</b></label>
                                    <select class="form-select" onclick="getShopDsr()" name="select_shop_dsr">
                                        <option value="">Select</option>
                                        <option value="shop">Shop</option>
                                        <option value="dsr">DSR</option>
                                    </select>
                                </div>

                                <div class="col-lg-3 mt-2" id="shopNameContainer" style="display: none;">
                                    <label for=""><b>Shop Name</b></label>
                                    <select class="form-select" name="shop_name">
                                        <option value="">Select</option>
                                    </select>
                                </div>

                                <div class="col-lg-3 mt-2" id="dsrNameContainer" style="display: none;">
                                    <label for=""><b>DSR Name</b></label>
                                    <select class="form-select" name="dsr_name">
                                        <option value="">Select</option>
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
                                                <th scope="col">{{__('TP/Tp Free')}}</th>
                                                <th scope="col">{{__('TP/Tp Free(Price)')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sales_repeat">
                                            <tr>
                                                <td>
                                                    <select class="choices form-select product_id" id="product_id" name="product_id[]">
                                                        <option value="">Select Product</option>
                                                        @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                                                        <option  data-tp='{{ $pro->tp_price }}' data-tp_free='{{ $pro->tp_free }}' value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td><input class="form-control ctn" type="text" name="ctn[]" value="" placeholder="ctn"></td>
                                                <td><input class="form-control pcs" type="text" name="pcs[]"value="" placeholder="pcs"></td>
                                                <td>
                                                    <select class="form-select" name="select_tp_tpfree" onchange="productData(this);">
                                                        <option value="0">Select</option>
                                                        <option value="tp">TP</option>
                                                        <option value="tpfree">TP Free</option>
                                                    </select>
                                                </td>
                                                <td><input class="form-control" type="text" name="sales_price[]" value="" placeholder="Tp Price"></td>
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

var row=`
    <tr>
        <td>
            <select class="choices form-select product_id" id="product_id" name="product_id[]">
                <option value="">Select Product</option>
                @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                <option  data-tp='{{ $pro->tp_price }}' data-tp_free='{{ $pro->tp_free }}' value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                @empty
                @endforelse
            </select>
        </td>
        <td><input class="form-control ctn" type="text" name="ctn[]" value="" placeholder="ctn"></td>
        <td><input class="form-control pcs" type="text" name="pcs[]"value="" placeholder="pcs"></td>
        <td>
            <select class="form-select" name="select_tp_tpfree" onchange="productData(this);">
                <option value="0">Select</option>
                <option value="tp">TP</option>
                <option value="tpfree">TP Free</option>
            </select>
        </td>
        <td><input class="form-control" type="text" name="sales_price[]" value="" placeholder="Tp Price"></td>
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

function productData(e) {
    var selectedOption = e.value;
    var salesPriceInput = $(e).closest('tr').find('input[name="sales_price[]"]');
    var tp = $(e).closest('tr').find('#product_id option:selected').attr('data-tp');
    var tpFree = $(e).closest('tr').find('#product_id option:selected').attr('data-tp_free');
    if (selectedOption === "tp") {
        salesPriceInput.val(tp);
    } else if (selectedOption === "tpfree") {
        salesPriceInput.val(tpFree);
    } else {
        salesPriceInput.val("");
    }
}


</script>

<script>
    function getShopDsr() {
        var selectedOption = document.querySelector('select[name="select_shop_dsr"]').value;

        var shopNameContainer = document.getElementById("shopNameContainer");
        var dsrNameContainer = document.getElementById("dsrNameContainer");

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

    function populateShopOptions(data) {
        var selectElement = document.querySelector('select[name="shop_name"]');
        selectElement.innerHTML = "";

        data.forEach(function(item) {
            var option = document.createElement("option");
            option.value = item.id;
            option.textContent = item.shop_name;
            selectElement.appendChild(option);
        });
    }

    function populateDsrOptions(data) {
        var selectElement = document.querySelector('select[name="dsr_name"]');
        selectElement.innerHTML = "";

        data.forEach(function(item) {
            var option = document.createElement("option");
            option.value = item.id;
            option.textContent = item.name;
            selectElement.appendChild(option);
        });
    }

</script>

@endpush