@extends('layout.app')
@section('pageTitle',trans('Receive Do'))
@section('pageSubTitle',trans('List'))
@push("styles")
<link rel="stylesheet" href="{{ asset('assets/css/main/full-screen.css') }}">
@endpush
@section('content')

<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <form method="post" action="{{route(currentUser().'.do.accept_do_edit',encryptor('encrypt',$data->id))}}">
                    @csrf
                    <!-- table bordered -->
                    <div class="row p-2 mt-4">
                        <div class="col-lg-3">
                             <span><b>Do ID:</b> {{$data->id}}</span>
                        </div>
                        <div class="col-lg-3">
                             <span><b>Supplier ID:</b> {{$data->supplier?->name}}</span>
                        </div>
                        {{--  <div class="col-lg-3">
                             <span><b>Quantity:</b> 500</span>
                        </div>  --}}
                        <div class="col-lg-3">
                            <span><b>Do Date:</b> {{\Carbon\Carbon::parse($data->do_date)->format('d-m-Y')}}</span>
                        </div>
                        <hr>

                        <div class="col-lg-3 mt-2">
                            <label for=""><b>Stock Date</b></label>
                            <input type="text" id="datepicker" class="form-control"  name="stock_date" placeholder="dd-mm-yyyy">
                        </div>
                        {{--  <div class="col-lg-3 mt-2">
                            <label for=""><b>Batch No</b></label>
                            <select class=" choices form-select" name="batch_no">
                                <option value="">Select style</option>
                                @forelse (\App\Models\Product\Batch::all(); as $us)
                                <option value="{{ $us->id }}">{{ $us->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>  --}}
                        <div class="col-lg-3 mt-2">
                            <label for=""><b>Status</b></label>
                            <select class="form-select" name="status" id="">
                                <option value="0">Pending</option>
                                <option value="1">Partial Received</option>
                                <option value="2">Final</option>
                            </select>
                        </div>
                        <div class="col-lg-3 mt-2">
                            <label for=""><b>Chalan NO</b></label>
                            <input type="text" id="" class="form-control"  name="chalan_no" placeholder="Chalan NO">
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="3">{{__('#SL')}}</th>
                                    <th rowspan="3">{{__('Product')}}</th>
                                    <th rowspan="3">{{__('Batch')}}</th>
                                    <th rowspan="3">{{__('Unit Style')}}</th>
                                    <th rowspan="3">{{__('CTN')}}</th>
                                    <th rowspan="3">{{__('PCS')}}</th>
                                    <th rowspan="3">{{__('Free')}}</th>
                                    <th colspan="7">{{__('Quantity')}}</th>
                                    {{--  <th rowspan="2">{{__('Total')}}</th>  --}}
                                    <th rowspan="3">{{__('DP')}}</th>
                                    <th rowspan="3">{{__('TP')}}</th>
                                    <th rowspan="3">{{__('TP(free)')}}</th>
                                    <th rowspan="3">{{__('MRP')}}</th>
                                    <th rowspan="3">{{__('Adjust')}}</th>
                                    <th rowspan="3">{{__('Remark')}}</th>
                                </tr>
                                <tr  class="text-center">
                                    <th rowspan="2">{{__('Do')}}</th>
                                    <th colspan="3">{{__('Free' ) }}</th>
                                    <th rowspan="2">{{__('Received')}}</th>
                                    <th rowspan="2">{{__('s/o')}}</th>
                                    <th rowspan="2">{{__('s/o Free')}}</th>
                                </tr>
                                <tr class="text-center">
                                    <th>{{__('Ratio')}}</th>
                                    <th>{{__('PCS')}}</th>
                                    <th>{{__('Tk')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data->details as $d)
                                    <tr>
                                        <th>{{ ++$loop->index }}</th>
                                        <td>{{$d->product?->product_name}}</td>
                                        <td>
                                            <select class="form-select" name="batch_no">
                                                <option value="">Select style</option>
                                                @forelse (\App\Models\Product\Batch::all(); as $us)
                                                <option value="{{ $us->id }}">{{ $us->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </td>
                                        <td>
                                            <input readonly class="form-control" id="" type="text" value="{{ $d->unitstyle?->name }}">
                                            <input type="hidden" class="unit_style_id" name="unit_style_id" value="{{$d->unite_style_id}}">
                                        </td>
                                        <td><input class="form-control ctn" type="text" name="ctn" value="" onkeyup="ctn_pcs(this)" placeholder="ctn"></td>
                                        <td><input class="form-control pcs" type="text" name="pcs" value="" onkeyup="ctn_pcs(this)" placeholder="pcs"></td>
                                        <td><input class="form-control" type="text" name="" value="" placeholder="free pcs"></td>
                                        <td><input disabled class="form-control do_qty" type="number" name="do_qty" value="{{ $d->qty }}"></td>
                                        <td><input disabled class="form-control free_ratio" type="number" name="free_ratio" value="{{ $d->free_ratio }}"></td>
                                        <td><input disabled class="form-control free_pcs" type="number" name="free_pcs" value="{{ $d->free }}"></td>
                                        <td><input disabled class="form-control" type="number" name="free_tk" value="{{ $d->free_tk }}"></td>
                                        <td><input readonly class="form-control receive" type="number" name="delete_qty" value=""></td>
                                        <td><input readonly class="form-control receive_qty" type="text" name="" value="">
                                            <input class="form-control rece_qty" type="hidden" name="" value="{{ $d->qty }}">
                                        </td>
                                        <td><input readonly class="form-control" type="number" name="" value=""></td>
                                        {{--  <td><input class="form-control" type="text" name="" value=""></td>  --}}
                                        {{--  <td><input class="form-control" type="text" name="" value="" placeholder="total"></td>  --}}
                                        <td><input class="form-control" type="number" name="dp" value="{{$d->product?->dp_price}}"></td>
                                        <td><input class="form-control tp_price" type="number" name="tp" value="{{$d->product?->tp_price}}"></td>
                                        <td><input class="form-control" type="number" name="mrp" value=""></td>
                                        <td><input class="form-control" type="number" name="mrp" value="{{$d->product?->mrp_price}}"></td>
                                        {{-- <td>
                                            <select class="form-select" name="" id="">
                                                <option value="0">select</option>
                                                <option value="1">werehouse1</option>
                                                <option value="2">werehouse2</option>
                                            </select>
                                        </td> --}}
                                        <td><input class="form-control" type="text" name="" value=""></td>
                                        <td><input class="form-control" type="text" name="" value=""></td>
                                </tr>
                                @empty

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end my-2">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
@push("scripts")

    <script>
        function ctn_pcs(e){

            let cn=$(e).closest('tr').find('.ctn').val()?parseFloat($(e).closest('tr').find('.ctn').val()):0;

            let pcs=$(e).closest('tr').find('.pcs').val()?parseFloat($(e).closest('tr').find('.pcs').val()):0;
            $(e).closest('tr').find('.receive').val(pcs);
            let unit_style_id=$(e).closest('tr').find('.unit_style_id').val();

            let do_qty=$(e).closest('tr').find('.do_qty').val()?parseFloat($(e).closest('tr').find('.do_qty').val()):0;
            let free_ratio=$(e).closest('tr').find('.free_ratio').val()?parseFloat($(e).closest('tr').find('.free_ratio').val()):0;
            let free_pcs=$(e).closest('tr').find('.free_pcs').val()?parseFloat($(e).closest('tr').find('.free_pcs').val()):0;
            let tp_price=$(e).closest('tr').find('.tp_price').val()?parseFloat($(e).closest('tr').find('.tp_price').val()):0;
            let rece_qty=$(e).closest('tr').find('.rece_qty').val()?parseFloat($(e).closest('tr').find('.rece_qty').val()):0;
            //let so=do_qty-cn;
            //$(e).closest('tr').find('.receive_qty').val(so);

            if (cn<=do_qty) {
                $.ajax({
                    url: "{{route(currentUser().'.unit_data_get')}}",
                    type: "GET",
                    dataType: "json",
                    data: { unit_style_id:unit_style_id },
                    success: function(data) {
                    //console.log(data);
                        total=((cn*data)+pcs)
                        $(e).closest('tr').find('.receive').val(total);
                        total_doqty=(do_qty*data);
                        dodata=(Math.floor(total_doqty/free_ratio)*free_pcs)+total_doqty;
                        tpfree =(tp_price*total_doqty)/dodata;

                        so=(do_qty*data);
                        sonow=so-total;
                        $(e).closest('tr').find('.receive_qty').val(sonow);
                        alert(tpfree);

                    },
                });
            }

        }
    </script>

    <script src="{{ asset('/assets/js/full_screen.js') }}"></script>
@endpush
