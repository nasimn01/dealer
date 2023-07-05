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
                                                <th scope="col">{{__('Do Number')}}</th>
                                                <th scope="col">{{__('CTN')}}</th>
                                                <th scope="col">{{__('PCS')}}</th>
                                                <th scope="col">{{__('Free')}}</th>
                                                <th scope="col">{{__('receive')}}</th>
                                                <th scope="col">{{__('Dp')}}</th>
                                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select class="choices form-select product_id" id="product_id" onchange="doData(this);">
                                                        <option value="">Select Product</option>
                                                        @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                                                        <option data-dp='{{ $pro->dp_price }}' data-name='{{ $pro->product_name }}' value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class=" choices form-select">
                                                        <option value="">Select Product</option>
                                                        @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                                                        <option data-dp='{{ $pro->dp_price }}' data-name='{{ $pro->product_name }}' value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td><input class="form-control ctn" type="text" name="ctn[]" value="" placeholder="ctn"></td>
                                                <td><input class="form-control pcs" type="text" name="pcs[]" value="" placeholder="pcs"></td>
                                                <td><input class="form-control free" type="text" name="free[]" value="" placeholder="free"></td>
                                                <td><input class="form-control receive" type="text" name="receive[]" value="" placeholder="receive"></td>
                                                <td><input class="form-control dp" type="text" name="dp[]" value="" placeholder="dp"></td>
                                                <td><i class="bi bi-plus-square-fill"></i></td>
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
        function doData(e){
            let product_id=$(e).closest('tr').find('.product_id').val();
            //alert(product_id)
            $.ajax({
                url: "{{route(currentUser().'.do_data_get')}}",
                type: "GET",
                dataType: "json",
                data: { product_id:product_id },
                success: function(dodetail) {
                console.log(dodetail);
                },
            });
        }
    </script>
@endpush
