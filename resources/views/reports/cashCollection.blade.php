@extends('layout.app')
@section('pageTitle',trans('Cash Collection List'))
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
                                        <input type="date" id="fdate" class="form-control" value="{{ request('fdate')}}" name="fdate">
                                    </div>
                                    <div class="col-4 py-1">
                                        <label for="fdate">{{__('To Date')}}</label>
                                        <input type="date" id="tdate" class="form-control" value="{{ request('tdate')}}" name="tdate">
                                    </div>
                                    {{--  <div class="col-4 py-1">
                                        <label for="sr">{{__('SR')}}</label>
                                        <select name="sr_id" class="select2 form-select">
                                            <option value="">Select</option>
                                            @forelse ($userSr as $p)
                                                <option value="{{$p->id}}" {{ request('sr_id')==$p->id?"selected":""}}>{{$p->name}}</option>
                                            @empty
                                                <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                    </div>  --}}
                                    <div class="col-12 col-sm-12 ps-0 text-center py-2">
                                        <button class="btn btn-sm btn-info" type="submit">Search</button>
                                        <a class="btn btn-sm btn-warning " href="{{route(currentUser().'.cashCollection')}}" title="Clear">Clear</a>
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
                                <tr>
                                    <th scope="col">{{__('#SL')}}</th>
                                    <th scope="col">{{__('DSR Name')}}</th>
                                    <th scope="col">{{__('Sales Date')}}</th>
                                    <th scope="col">{{__('Total')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $p)
                                <tr>
                                    <td>{{ ++$loop->index }}</td>
                                    <td>
                                        @if (!empty($p->shop_id))
                                        <span class="text-warning">Shop :</span> {{ $p->shop?->shop_name }}
                                        @elseif(!empty($p->dsr_id))
                                        <span class="text-warning">DSR :</span> {{ $p->dsr?->name }}
                                        @else
                                        @endif
                                    </td>
                                    <td>{{$p->sales_date}}</td>
                                    <td style="vertical-align: bottom;">{{$p->today_final_cash}}
                                        <input type="hidden" value="{{$p->today_final_cash}}" class="final_total">
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="4" class="text-center">No Data Found</th>
                                </tr>
                                @endforelse
                                <tr>
                                    <th colspan="3" class="text-end">Total</th>
                                    <th>
                                        <span class="sumFinalTotal"></span>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</section>
<!-- Bordered table end -->
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
    }
</script>
@endpush
