@extends('layout.app')
@section('pageTitle',trans('product List'))
@section('pageSubTitle',trans('List'))

@section('content')

<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                    <!-- table bordered -->
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <a class="float-end" href="{{route(currentUser().'.product.create')}}"style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
                            <thead>
                                <tr>
                                    <th scope="col">{{__('#SL')}}</th>
                                    <th scope="col">{{__('Group')}}</th>
                                    <th scope="col">{{__('Category')}}</th>
                                    <th scope="col">{{__('Name')}}</th>
                                    <th scope="col">{{__('DP Price')}}</th>
                                    <th scope="col">{{__('TP Price')}}</th>
                                    <th scope="col">{{__('MRP Price')}}</th>
                                    <th scope="col">{{__('Unit')}}</th>
                                    <th scope="col">{{__('Image')}}</th>
                                    <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($product as $p)
                                <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                    <td>{{$p->group?->name}}</td>
                                    <td>{{$p->category?->name}}</td>
                                    <td>{{$p->product_name}}</td>
                                    <td>{{$p->dp_price}}</td>
                                    <td>{{$p->tp_price}}</td>
                                    <td>{{$p->mrp_price}}</td>
                                    <td>{{$p->unit?->name}}</td>
                                    <td><img width="50px" src="{{asset('uploads/product_img/'.company()['company_id'].'/'.$p->image)}}" alt=""></td>
                                    <td class="white-space-nowrap">
                                        <a href="{{route(currentUser().'.product.edit',encryptor('encrypt',$p->id))}}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="javascript:void()" onclick="$('#form{{$p->id}}').submit()">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        <form id="form{{$p->id}}" action="{{route(currentUser().'.product.destroy',encryptor('encrypt',$p->id))}}" method="post">
                                            @csrf
                                            @method('delete')

                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="11" class="text-center">No Data Found</th>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="my-3">
                        {!! $product->links()!!}
                    </div>
                </div>
            </div>
    </div>
</section>
<!-- Bordered table end -->


@endsection
