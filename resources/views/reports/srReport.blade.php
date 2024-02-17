@extends('layout.app')
@section('pageTitle',trans('SR Report List'))
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
                                    <div class="col-4">
                                        <select name="sr_id" class="choices form-select">
                                            <option value="">Select</option>
                                            @forelse ($userSr as $p)
                                                <option value="{{$p->id}}" {{ request('sr_id')==$p->id?"selected":""}}>{{$p->name}}</option>
                                            @empty
                                                <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-2 col-sm-4 ps-0 text-start">
                                        <button class="btn btn-sm btn-info" type="submit">Search</button>
                                        <a class="btn btn-sm btn-warning " href="{{route(currentUser().'.srreport')}}" title="Clear">Clear</a>
                                    </div>
                                    <div class="col-2 p-0 m-0">
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
                                    {{--  <th class="white-space-nowrap">{{__('ACTION')}}</th>  --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $p)
                                <tr>
                                    <th scope="row">{{ ++$loop->index }}</th>
                                    <td> {{ $p->dsr?->name }} </td>
                                    <td>{{$p->sales_date}}</td>
                                    <td>{{$p->final_total}}
                                        <input type="hidden" value="{{$p->final_total}}" class="final_total">
                                    </td>
                                    {{--  <td>
                                        <a class="ms-2" href="{{route(currentUser().'.sales.printpage',encryptor('encrypt',$p->id))}}">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>  --}}
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="5" class="text-center">No Data Found</th>
                                </tr>
                                @endforelse
                                <tr>
                                    <th colspan="3" class="text-center">Total</th>
                                    <th>
                                        <span class="sumFinalTotal"></span>
                                        {{--  <input type="text" value="" class="sumFinalTotal_f">  --}}
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="my-3">
                        {!! $sales->links()!!}
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
