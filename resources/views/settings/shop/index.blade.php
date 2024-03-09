@extends('layout.app')
@section('pageTitle','Shop List')
@section('pageSubTitle','List')

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="row pb-1">
                    <div class="col-10">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-4">
                                    <input type="text" name="shop_name" value="{{isset($_GET['shop_name'])?$_GET['shop_name']:''}}" placeholder="Shop Name" class="form-control">
                                </div>
                                <div class="col-4">
                                    <input type="text" name="owner_name" value="{{isset($_GET['owner_name'])?$_GET['owner_name']:''}}" placeholder="Owner Name" class="form-control">
                                </div>

                                <div class="col-2 ps-0">
                                    <button class="btn btn-sm btn-info float-end" type="submit">Search</button>
                                </div>
                                <div class="col-2 p-0 m-0">
                                    <a class="btn btn-sm btn-warning ms-2" href="{{route(currentUser().'.shop.index')}}" title="Clear">Clear</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-2">
                        <a class="float-end" href="{{route(currentUser().'.shop.create')}}"style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
                    </div>
                </div>

                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">

                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Shop Name')}}</th>
                                <th scope="col">{{__('Owner Name')}}</th>
                                <th scope="col">{{__('Contact')}}</th>
                                <th scope="col">{{__('DSR')}}</th>
                                <th scope="col">{{__('Area Name')}}</th>
                                <th scope="col">{{__('Receivable')}}</th>
                                <th scope="col">{{__('Address')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($shop as $data)
                            @php $shopbalance=$data->shopBalances?->where('status',0)->sum('balance_amount') - $data->shopBalances?->where('status',1)->sum('balance_amount') @endphp
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$data->shop_name}}</td>
                                <td>{{$data->owner_name}}</td>
                                <td>{{$data->contact}}</td>
                                <td>{{$data->dsr?->name}}</td>
                                <td>{{$data->area_name}}</td>
                                <td>{{ $shopbalance }}</td>
                                <td>{{$data->address}}</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route(currentUser().'.shop.edit',encryptor('encrypt',$data->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a class="text-danger" href="javascript:void(0)" onclick="confirmDelete({{ $data->id }})">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <form id="form{{ $data->id }}" action="{{ route(currentUser().'.shop.destroy', encryptor('encrypt', $data->id)) }}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="10" class="text-center">No Data Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push("scripts")
<script>
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this Shop?")) {
            $('#form' + id).submit();
        }
    }
</script>
@endpush
