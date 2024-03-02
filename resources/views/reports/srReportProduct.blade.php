@extends('layout.app')
@section('pageTitle',trans('SR Report Product Wise List'))
@section('pageSubTitle',trans('List'))

@section('content')

<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                    <div class="row pb-1">
                        <div class="col-10">
                            <form action="" method="get">
                                <div class="row">
                                    <div class="col-4 py-1">
                                        <label for="fdate">{{__('From Date')}}</label>
                                        <input type="date" id="fdate" class="form-control" value="{{ old('fdate')}}" name="fdate">
                                    </div>
                                    <div class="col-4 py-1">
                                        <label for="fdate">{{__('To Date')}}</label>
                                        <input type="date" id="tdate" class="form-control" value="{{ old('tdate')}}" name="tdate">
                                    </div>
                                    <div class="col-4 py-1">
                                        <label for="sr">{{__('SR')}}</label>
                                        <select name="sr_id" class="select2 form-select">
                                            <option value="">Select</option>
                                            @forelse ($userSr as $p)
                                                <option value="{{$p->id}}" {{ request('sr_id')==$p->id?"selected":""}}>{{$p->name}}</option>
                                            @empty
                                                <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-12 ps-0 text-center py-2">
                                        <button class="btn btn-sm btn-info" type="submit">Search</button>
                                        <a class="btn btn-sm btn-warning " href="{{route(currentUser().'.srreportProduct')}}" title="Clear">Clear</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-2">
                        </div>
                    </div>
                    <!-- table bordered -->
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 table-striped">
                            <thead>
                                {{--  <tr>
                                    <th scope="col">{{__('#SL')}}</th>
                                    <th scope="col">{{__('DSR Name')}}</th>
                                    <th scope="col">{{__('Sales Date')}}</th>
                                    <th scope="col">{{__('Product')}}</th>
                                    <th scope="col">{{__('Total')}}</th>
                                </tr>  --}}
                            </thead>
                            <tbody>
                                {{--  @forelse($sales as $p)
                                <tr>
                                    <td>{{ ++$loop->index }}</td>
                                    <td> {{ $p->dsr?->name }} </td>
                                    <td>{{$p->sales_date}}</td>
                                    <td>
                                        @if($p->sales_details)
                                            <table class="table table-bordered mb-0 table-striped">
                                                <tr>
                                                    <td>Product</td>
                                                    <td>Sales(PCS)</td>
                                                    <td>PCS Price</td>
                                                    <td>Subtotal</td>
                                                </tr>
                                                @foreach($p->sales_details as $detail)
                                                    <tr>
                                                        <td>{{ $detail->product?->product_name }}</td>
                                                        <td>{{ $detail->total_sales_pcs}}</td>
                                                        <td>@if($detail->tp_price) {{ $detail->tp_price }}@else {{ $detail->tp_free }} @endif</td>
                                                        <td>{{ $detail->subtotal_price }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        @endif
                                    </td>
                                    <td style="vertical-align: bottom;">{{$p->daily_total_taka}}
                                        <input type="hidden" value="{{$p->daily_total_taka}}" class="final_total">
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="5" class="text-center">No Data Found</th>
                                </tr>
                                @endforelse
                                <tr>
                                    <th colspan="4" class="text-end">Total</th>
                                    <th>
                                        <span class="sumFinalTotal"></span>
                                    </th>
                                </tr>  --}}
                            </tbody>
                        </table>
                    </div>
                    <div class="my-3">
                    </div>
                </div>
            </div>
    </div>
</section>
<!-- Bordered table end -->
<script>
    function showConfirmation(salesId) {
        if (confirm("Are you sure you want to delete this sales?")) {
            $('#form' + salesId).submit();
        }
    }
</script>

@endsection
@push("scripts")
<script>
    total_calculate();

    function total_calculate() {
        var finalTotal = 0;
        $('.final_total').each(function() {
            finalTotal+=isNaN(parseFloat($(this).val()))?0:parseFloat($(this).val());
        });
        $('.sumFinalTotal').text(parseFloat(finalTotal).toFixed(2));
        $('.sumFinalTotal_f').val(parseFloat(subtotal).toFixed(2));
    }
</script>
@endpush