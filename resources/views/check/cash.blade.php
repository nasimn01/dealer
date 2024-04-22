@extends('layout.app')
@section('pageTitle',trans('Cash'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    @php
                        $totalAmount = 0;   
                    @endphp
                    <table class="table table-bordered mb-0"><thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Shop Name')}}</th>
                                <th scope="col">{{__('Check Date')}}</th>
                                <th scope="col">{{__('Amount')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $d)
                            <tr>
                            <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$d->shop?->shop_name}}</td>
                                <td>{{$d->check_date}}</td>
                                <td>{{$d->amount}}</td>
                            </tr>
                            @php
                                $totalAmount += $d->amount;
                            @endphp
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Data Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-center">Total</th>
                                <th>{{$totalAmount}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection