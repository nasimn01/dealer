@extends('layout.app')
@section('pageTitle',trans('Receive Do'))
@section('pageSubTitle',trans('List'))

@section('content')

<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <form method="" action="">
                    <!-- table bordered -->
                    <div class="row p-2 mt-4">
                        <div class="col-lg-3">
                             <span><b>Do ID:</b> 122323</span>
                        </div>
                        <div class="col-lg-3">
                             <span><b>Supplier ID:</b> 122232</span>
                        </div>
                        <div class="col-lg-3">
                             <span><b>Quantity:</b> 500</span>
                        </div>
                        <div class="col-lg-3">
                            <span><b>Do Date:</b> 12-05-2023</span>
                        </div>
                        <hr>

                        <div class="col-lg-3 mt-2">
                            <label for=""><b>Stock Date</b></label>
                            <input type="text" id="datepicker" class="form-control"  name="stock_date" placeholder="dd-mm-yyyy">
                        </div>
                        <div class="col-lg-3 mt-2">
                            <label for=""><b>Batch No</b></label>
                            <select class="form-select" name="batch">
                                <option value="">Select Batch</option>
                                <option value="1">Batch1</option>
                                <option value="2">Batch2</option>
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
                                @forelse ($data as $d)
                                    <tr>
                                        <th>{{ ++$loop->index }}</th>
                                        <td>{{$d->product?->product_name}}</td>
                                        <td>Unit</td>
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
                                        <td>{{ $d->qty }}</td>
                                        <td><input class="form-control" type="number" name="" value=""></td>
                                        <td>1200</td>
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
