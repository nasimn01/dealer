@extends('layout.app')
@section('pageTitle',trans('Do List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                    <!-- table bordered -->
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <a class="float-end" href="{{route(currentUser().'.docontroll.create')}}" style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
                            <thead>
                                <tr>
                                    <th scope="col">{{__('#SL')}}</th>
                                    <th scope="col">{{__('Supplier')}}</th>
                                    <th scope="col">{{__('Do Date')}}</th>
                                    <th scope="col">{{__('Reference Number')}}</th>
                                    <th scope="col">{{__('Total Qty')}}</th>
                                    <th scope="col">{{__('Total Amount')}}</th>
                                    <th scope="col">{{__('Status')}}</th>
                                    <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $p)
                                <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                    <td>{{$p->supplier?->name}}</td>
                                    <td>{{\Carbon\Carbon::parse($p->do_date)->format('d-m-Y')}}</td>
                                    <td>{{$p->reference_num}}</td>
                                    <td>{{$p->total_qty}}</td>
                                    <td>{{$p->total_amount}}</td>
                                    <td>{{$p->name}}</td>
                                    <td class="white-space-nowrap">
                                        <a href="{{route(currentUser().'.docontroll.edit',encryptor('encrypt',$p->id))}}">
                                       <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="{{route(currentUser().'.doreceive',encryptor('encrypt',$p->id))}}">
                                            <i class="bi bi-cart-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="7" class="text-center">No Data Found</th>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="my-3">
                        {{--  {!! $data->links()!!}  --}}
                    </div>
                </div>
            </div>
    </div>
</section>
@endsection
