@extends('layout.app')

@section('pageTitle',trans('Stock Reports'))
@section('pageSubTitle',trans('Reports'))

@section('content')
  <!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="text-center"><h4>STOCK (Report)</h4></div>
                    <div class="card-body">
                        <form class="form" method="get" action="">
                            <div class="row">
                                <div class="col-md-2 mt-2">
                                    <label for="fdate" class="float-end"><h6>{{__('From Date')}}</h6></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" id="fdate" class="form-control" value="{{ old('fdate')}}" name="fdate">
                                </div>
                                <div class="col-md-2 mt-2">
                                    <label for="tdate" class="float-end"><h6>{{__('To Date')}}</h6></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" id="tdate" class="form-control" value="{{ old('tdate')}}" name="tdate">
                                </div>
                            </div>
                            <div class="row m-4">
                                <div class="col-6 d-flex justify-content-end">
                                    <button type="#" class="btn btn-sm btn-success me-1 mb-1 ps-5 pe-5">{{__('Show')}}</button>

                                </div>
                                <div class="col-6 d-flex justify-content-Start">
                                    <button type="#" class="btn pbtn btn-sm btn-warning me-1 mb-1 ps-5 pe-5">{{__('Close')}}</button>

                                </div>
                            </div>
                            <table class="table mb-5">
                                <thead>
                                    <tr class="bg-primary text-white text-center">
                                        <th class="p-2">{{__('#SL')}}</th>
                                        <th class="p-2" data-title="Product Name">{{__('Product')}}</th>
                                        <th class="p-2" data-title="Qty(PCS)">{{__('Qty(PCS)')}}</th>
                                        {{--  <th class="p-2" data-title="Total Amount">{{__('Total Amount')}}</th>  --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($stock as $s)
                                    <tr class="text-center">
                                        <th scope="row">{{ ++$loop->index }}</th>
                                        <td>{{$s->product_name}}</td>
                                        <td>{{ $s->ins - $s->outs }}</td>
                                        {{--  <td>{{$s->qty}}</td>  --}}
                                    @empty
                                    <tr>
                                        <th colspan="9" class="text-center">No data Found</th>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
