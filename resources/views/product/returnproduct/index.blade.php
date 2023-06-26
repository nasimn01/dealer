@extends('layout.app')
@section('pageTitle',trans('Return Product List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                    <!-- table bordered -->
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <a class="float-end" href="{{route(currentUser().'.returnproduct.create')}}"style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
                            <thead>
                                <tr>
                                    <th scope="col">{{__('#SL')}}</th>
                                    <th scope="col">{{__('Driver Name')}}</th>
                                    <th scope="col">{{__('Helper')}}</th>
                                    <th scope="col">{{__('Invoice Number')}}</th>
                                    <th scope="col">{{__('Total')}}</th>
                                    <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $p)
                                <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                    <td>{{$p->driver_name}}</td>
                                    <td>{{$p->helper}}</td>
                                    <td>{{$p->invoice_number}}</td>
                                    <td>{{$p->total}}</td>
                                    <td class="white-space-nowrap">
                                        <a href="{{route(currentUser().'.returnproduct.edit',encryptor('encrypt',$p->id))}}">
                                       <i class="bi bi-pencil-square"></i>
                                        </a>
                                        {{--  <a href="{{route(currentUser().'.returnproduct.edit',encryptor('encrypt',$p->id))}}">
                                            <i class="bi bi-cart-fill"></i>
                                        </a>  --}}
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
