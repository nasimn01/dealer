@extends('layout.app')
@section('pageTitle','Distributor All Transfer')
@section('pageSubTitle','List')

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">

                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Contact')}}</th>
                                <th scope="col">{{__('Balance Date')}}</th>
                                <th scope="col">{{__('Add Balance')}}</th>
                                {{--  <th class="white-space-nowrap">{{__('ACTION')}}</th>  --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suplier as $data)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$data->supplier?->name}}</td>
                                <td>{{$data->supplier?->contact}}</td>
                                <td>{{$data->balance_date}}</td>
                                <td>{{$data->balance_amount}}</td>
                                {{--  <td class="white-space-nowrap">
                                    <a class="ms-2" href="{{route(currentUser().'.supplier.show',encryptor('encrypt',$data->id))}}">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>  --}}
                            </tr>
                            @empty
                            <tr>
                                <th colspan="10" class="text-center">No Data Found</th>
                            </tr>
                            @endforelse
                            <tr>
                                <td colspan="3"></td>
                                <td class="text-end"><b>Total:</b> </td>
                                <td>{{ $suplier->sum('balance_amount') }}</td>
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


