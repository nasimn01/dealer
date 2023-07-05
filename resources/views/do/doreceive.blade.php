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
                        <form method="post" action="#">
                        {{--  <form method="post" action="{{route(currentUser().'.do.accept_do_edit',encryptor('encrypt'))}}">  --}}
                            @csrf
                            <!-- table bordered -->
                            <div class="row p-2 mt-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">{{__('Product Name')}}</th>
                                                <th scope="col">{{__('Do Referance')}}</th>
                                                <th scope="col">{{__('CTN')}}</th>
                                                <th scope="col">{{__('PCS')}}</th>
                                                <th scope="col">{{__('Free')}}</th>
                                                <th scope="col">{{__('receive')}}</th>
                                                <th scope="col">{{__('Dp')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="product">
                                            <tr>
                                                <td>
                                                    <select class="choices form-select product_id" id="product_id" onchange="doData(this);">
                                                        <option value="">Select Product</option>
                                                        @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                                                        <option value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class=" choices form-select referance_number">
                                                    </select>
                                                </td>
                                                <td><input class="form-control ctn" type="text" name="ctn[]" onkeyup="getCtnQty(this)" value="" placeholder="ctn"></td>
                                                <td><input class="form-control pcs" type="text" name="pcs[]" onkeyup="getCtnQty(this)" value="" placeholder="pcs"></td>
                                                <td><input class="form-control free_pcs" type="text" name="free[]" onkeyup="getCtnQty(this)" value="" placeholder="free"></td>
                                                <td><input class="form-control receive" type="text" name="receive[]" value="" placeholder="receive"></td>
                                                <td><input class="form-control dp" type="text" name="dp[]" value="" placeholder="dp"></td>
                                                <td>
                                                    <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
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
        <select class="choices form-select product_id" id="product_id" onchange="doData(this);">
            <option value="">Select Product</option>
            @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
            <option value="{{ $pro->id }}">{{ $pro->product_name }}</option>
            @empty
            @endforelse
        </select>
    </td>
    <td>
        <select class=" choices form-select referance_number">
        </select>
    </td>
    <td><input class="form-control ctn" type="text" name="ctn[]" value="" placeholder="ctn"></td>
    <td><input class="form-control pcs" type="text" name="pcs[]" value="" placeholder="pcs"></td>
    <td><input class="form-control free" type="text" name="free[]" value="" placeholder="free"></td>
    <td><input class="form-control receive" type="text" name="receive[]" value="" placeholder="receive"></td>
    <td><input class="form-control dp" type="text" name="dp[]" value="" placeholder="dp"></td>
    <td>
        <span onClick='removeRow(this);' class="delete-row text-danger"><i class="bi bi-trash-fill"></i></span>
        <span onClick='addRow();' class="add-row text-primary"><i class="bi bi-plus-square-fill"></i></span>
    </td>
</tr>`;
    $('#product').append(row);
}

function removeRow(e){
    $(e).closest('tr').remove();
}
</script>
<script>
    function doData(e) {
        let product_id = $(e).closest('tr').find('.product_id').val();
        let cn=$(e).closest('tr').find('.ctn').val()?parseFloat($(e).closest('tr').find('.ctn').val()):0;

        $.ajax({
            url: "{{ route(currentUser().'.do_data_get') }}",
            type: "GET",
            dataType: "json",
            data: { product_id: product_id },
            success: function(dodetail) {
                //console.log(dodetail);
                let selectElement = $(e).closest('tr').find('.referance_number');
                selectElement.empty(); // Clear previous options

                $.each(dodetail, function(index, value) {
                    selectElement.append('<option value="' + value + '">' + value + '</option>');
                });
            },
        });
    }

    function getCtnQty(e){

        let product_id = $(e).closest('tr').find('.product_id').val();
        //let productId=$(e).closest('tr').find('.product_id').val()?$(e).closest('tr').find('.product_id').val():0;
        let cn=$(e).closest('tr').find('.ctn').val()?parseFloat($(e).closest('tr').find('.ctn').val()):0;
        let pcs=$(e).closest('tr').find('.pcs').val()?parseFloat($(e).closest('tr').find('.pcs').val()):0;
        let freePcs=$(e).closest('tr').find('.free_pcs').val()?parseFloat($(e).closest('tr').find('.free_pcs').val()):0;
        $(e).closest('tr').find('.receive').val(pcs);
            $.ajax({
                url: "{{route(currentUser().'.unit_data_get')}}",
                type: "GET",
                dataType: "json",
                data: { product_id:product_id },
                success: function(data) {
                console.log(data);
                total=((cn*data)+pcs+freePcs);
                $(e).closest('tr').find('.receive').val(total);

                },
            });
    }
</script>

@endpush
