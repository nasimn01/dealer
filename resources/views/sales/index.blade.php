@extends('layout.app')
@section('pageTitle',trans('Sales List'))
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
                            <a class="float-end" href="{{route(currentUser().'.sales.create')}}"style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
                            <thead>
                                <tr>
                                    <th scope="col">{{__('#SL')}}</th>
                                    <th scope="col">{{__('Shop/DSR Name')}}</th>
                                    <th scope="col">{{__('sales_date')}}</th>
                                    <th scope="col">{{__('total')}}</th>
                                    <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $p)
                                <tr>
                                    <th scope="row">{{ ++$loop->index }}</th>
                                    <td>
                                        @if (!empty($p->shop->shop_name))
                                        <span class="text-warning">Shop :</span> {{ $p->shop?->shop_name }}
                                        @else
                                        <span class="text-warning">DSR :</span> {{ $p->dsr?->name }}
                                        @endif
                                    </td>
                                    <td>{{$p->sales_date}}</td>
                                    <td>{{$p->total}}</td>
                                    <td class="white-space-nowrap">
                                        <a class="ms-2" href="{{route(currentUser().'.sales.receiveScreen',encryptor('encrypt',$p->id))}}">
                                            <i class="bi bi-receipt-cutoff"></i>
                                        </a>
                                        @if($p->status==0)
                                            <a class="ms-2" href="javascript:void()" onclick="showConfirmation({{$p->id}})">
                                                <i class="bi bi-trash" style='color:red'></i>
                                            </a>
                                            <a class="ms-2" href="{{route(currentUser().'.sales.primary_update',encryptor('encrypt',$p->id))}}">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        @endif
                                        <form id="form{{$p->id}}" action="{{route(currentUser().'.sales.destroy', encryptor('encrypt', $p->id))}}" method="post">
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
