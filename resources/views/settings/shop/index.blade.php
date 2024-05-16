@extends('layout.app')
@section('pageTitle','Shop List')
@section('pageSubTitle','List')

@section('content')
<style>
    .select2-container {
    box-sizing: border-box;
    display: inline-block;
    margin: 0;
    position: relative;
    vertical-align: middle;
    width: 100% !important;
}
</style>
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="row pb-1">
                    <div class="col-10">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-lg-2 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="shop_name" value="{{isset($_GET['shop_name'])?$_GET['shop_name']:''}}" placeholder="Shop Name" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="col-lg-2 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="owner_name" value="{{isset($_GET['owner_name'])?$_GET['owner_name']:''}}" placeholder="Owner Name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="form-group">
                                        <select name="distributor_id" class="select2 form-select">
                                            <option value="">Select Distributor</option>
                                            @forelse ($distributor as $d)
                                                <option value="{{$d->id}}" {{ request('distributor_id')==$d->id?"selected":""}}>{{$d->name}}</option>
                                            @empty
                                                <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6">
                                    <div class="form-group">
                                        <select name="sr_id" class="select2 form-select">
                                            <option value="">Select SR</option>
                                            @forelse ($userSr as $d)
                                                <option value="{{$d->id}}" {{ request('sr_id')==$d->id?"selected":""}}>{{$d->name}}</option>
                                            @empty
                                                <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-sm-6 ps-0 ">
                                    <div class="form-group d-flex">
                                        <button class="btn btn-sm btn-info float-end p-2" type="submit">Search</button>
                                        <a class="btn btn-sm btn-warning ms-2 p-2" href="{{route(currentUser().'.shop.index')}}" title="Clear">Clear</a>
                                   </div>
                                </div>
                                {{-- <div class="col-2 p-0 m-0">
                                </div> --}}
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
                                <th scope="col">{{__('Distributor')}}</th>
                                <th scope="col">{{__('SR')}}</th>
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
                                <td>{{$data->distributor?->name}}</td>
                                <td>{{$data->sr?->name}}</td>
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
                <div class="my-3">
                    {!! $shop->withQueryString()->links()!!}
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