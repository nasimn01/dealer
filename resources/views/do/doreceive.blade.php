@extends('layout.app')
@section('pageTitle',trans('Receive Do'))
@section('pageSubTitle',trans('List'))

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
                        <div class="col-lg-3">
                             <span><b>Quantity:</b> 500</span>
                        </div>
                        <div class="col-lg-3">
                            <span><b>Do Date:</b> {{\Carbon\Carbon::parse($data->do_date)->format('d-m-Y')}}</span>
                        </div>
                        <hr>

                        <div class="col-lg-3 mt-2">
                            <label for=""><b>Stock Date</b></label>
                            <input type="text" id="datepicker" class="form-control"  name="stock_date" placeholder="dd-mm-yyyy">
                        </div>
                        <div class="col-lg-3 mt-2">
                            <label for=""><b>Batch No</b></label>
                            <select class=" choices form-select" name="batch">
                                <option value="">Select style</option>
                                @forelse (\App\Models\Product\Batch::all(); as $us)
                                <option value="{{ $us->id }}">{{ $us->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="col-lg-3 mt-2">
                            <label for=""><b>Status</b></label>
                            <select class="form-select" name="status" id="">
                                <option value="0">Pending</option>
                                <option value="1">Partial Received</option>
                                <option value="2">Final</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2">{{__('#SL')}}</th>
                                    <th rowspan="2">{{__('Product')}}</th>
                                    <th rowspan="2">{{__('Unit Style')}}</th>
                                    <th rowspan="2">{{__('CTN')}}</th>
                                    <th rowspan="2">{{__('PCS')}}</th>
                                    <th rowspan="2">{{__('Total')}}</th>
                                    <th rowspan="2">{{__('DP')}}</th>
                                    <th rowspan="2">{{__('TP')}}</th>
                                    <th rowspan="2">{{__('MRP')}}</th>
                                    {{-- <th rowspan="2">{{__('Werehouse')}}</th> --}}
                                    <th colspan="3">{{__('Quantity')}}</th>
                                    <th rowspan="2">{{__('Remark')}}</th>
                                </tr>
                                <tr class="text-center">
                                    <th>{{__('Do')}}</th>
                                    <th>{{__('Received')}}</th>
                                    <th>{{__('s/o')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data->details as $d)
                                    <tr>
                                        <th>{{ ++$loop->index }}</th>
                                        <td>{{$d->product?->product_name}}</td>
                                        <td>{{ $d->unitstyle?->name }}</td>
                                        <td><input class="form-control" type="text" name="" value=""></td>
                                        <td><input class="form-control" type="text" name="" value=""></td>
                                        <td><input class="form-control" type="text" name="" value=""></td>
                                        <td><input class="form-control" type="number" name="dp" value="{{$d->product?->dp_price}}"></td>
                                        <td><input class="form-control" type="number" name="tp" value="{{$d->product?->tp_price}}"></td>
                                        <td><input class="form-control" type="number" name="mrp" value="{{$d->product?->mrp_price}}"></td>
                                        {{-- <td>
                                            <select class="form-select" name="" id="">
                                                <option value="0">select</option>
                                                <option value="1">werehouse1</option>
                                                <option value="2">werehouse2</option>
                                            </select>
                                        </td> --}}
                                        <td><input readonly class="form-control" id="do_qty" type="number" name="do_qty" value="{{ $d->qty }}"></td>
                                        <td><input class="form-control" type="number" id="recive_qty" name="delete_qty" value="" onkeyup="num_qty()"></td>
                                        <td><input class="form-control" id="num_total" type="text" name="" value="{{ $d->qty }}"></td>
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
<script>
    function num_qty(){
        let dq=$('#do_qty').val()?parseFloat($('#do_qty').val()):0;
        let rq=$('#recive_qty').val()?parseFloat($('#recive_qty').val()):0;
        $('#num_total').val((dq-rq));
    }
</script>
@endsection
