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
                        <td style="width: 15%"><b>Name</b></td>
                        <td style="width: 2%">:</td>
                        <td style="width: 83%">{{ $supplierman->supplier?->name }}</td>
                    </tr>
                    <tr>
                        <td style="width: 15%"><b>Contact NO</b></td>
                        <td style="width: 2%">:</td>
                        <td style="width: 83%">{{ $supplierman->supplier?->contact }}</td>
                    </tr>
                </table>
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">

                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Reference')}}</th>
                                <th scope="col">{{__('Add or Out')}}</th>
                                <th scope="col">{{__('Balance Date')}}</th>
                                <th scope="col">{{__('Add Balance')}}</th>
                                {{--  <th class="white-space-nowrap">{{__('ACTION')}}</th>  --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suplier as $data)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$data->reference_number}}</td>
                                <td>@if($data->status == 1) {{__('Add') }} @else {{__('Cost') }} @endif</td>
                                @if($data->balance_date)
                                <td>{{ \Carbon\Carbon::parse($data->balance_date)->format('d/m/Y') }}</td>
                                @else
                                <td>No Date Found</td>
                                @endif
                                <td>@if($data->status == 0) -{{$data->balance_amount}} @else {{$data->balance_amount}} @endif</td>
                                {{--  <td class="white-space-nowrap">
                                    <a class="ms-2" href="{{route(currentUser().'.supplier.show',encryptor('encrypt',$data->id))}}">
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
                                <td colspan="3"></td>
                                <td class="text-end"><b>Total Balance:</b> </td>
                                <td>{{ $suplier->where('status', 1)->sum('balance_amount') - $suplier->where('status', 0)->sum('balance_amount') }}</td>
                                {{--  <td>{{ $suplier->sum('balance_amount') }}</td>  --}}
                            </tr>
                        </tbody>
                    </table>

                    <div class="pt-2">
                        {{--  {{$suplier->links()}}  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


