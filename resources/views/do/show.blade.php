@extends('layout.app')
@section('pageTitle','Distributor All Transfer')
@section('pageSubTitle','List')

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 15%"><b>Supplier</b></td>
                        <td style="width: 2%">:</td>
                        <td style="width: 83%">{{ $doData->supplier->name }}</td>
                    </tr>
                    <tr>
                        <td style="width: 15%"><b>DO Date</b></td>
                        <td style="width: 2%">:</td>
                        <td style="width: 83%">
                            @if($doData->do_date)
                            {{ \Carbon\Carbon::parse($doData->do_date)->format('d/m/Y') }}
                            @else
                            No Date Found
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%"><b>Reference NO</b></td>
                        <td style="width: 2%">:</td>
                        <td style="width: 83%">{{ $doData?->reference_num }}</td>
                    </tr>
                </table>
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">

                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Product')}}</th>
                                {{--  <th scope="col">{{__('Contact')}}</th>  --}}
                                <th scope="col">{{__('Balance Date')}}</th>
                                <th scope="col">{{__('Add Balance')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($doData->details as $data)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$data->product?->product_name}}</td>
                                {{--  <td>{{$data->supplier?->contact}}</td>  --}}
                                @if($doData?->do_date)
                                <td>{{ \Carbon\Carbon::parse($doData?->do_date)->format('d/m/Y') }}</td>
                                @else
                                <td>No Date Found</td>
                                @endif
                                <td>{{$data->balance_amount}}</td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Data Found</th>
                            </tr>
                            @endforelse
                            <tr>
                                <td colspan="2"></td>
                                <td class="text-end"><b>Total:</b> </td>
                                <td>{{ $doData->total_amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


