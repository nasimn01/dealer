@extends('layout.app')
@section('pageTitle','Shop Collection List')
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
                                    {{--  <label for="shop">Shop Name(Owner)</label>  --}}
                                    <select class="select2 form-select shop_id" name="shop_id">
                                        <option value="">Select</option>
                                        @foreach (\App\Models\Settings\Shop::select('id','shop_name','owner_name')->get(); as $shop)
                                        <option value="{{ $shop->id }}" {{ request('shop_id')==$shop->id?"selected":""}}>{{ $shop->shop_name }}({{ $shop->owner_name }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-1 ps-0">
                                    <button class="btn btn-sm btn-info float-end" type="submit">Search</button>
                                </div>
                                <div class="col-2 p-0 m-0">
                                    <a class="btn btn-sm btn-warning ms-2" href="{{route(currentUser().'.shopbalance.index')}}" title="Clear">Clear</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-2">
                        <a class="float-end" href="{{route(currentUser().'.shopbalance.create')}}"style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
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
                                <th scope="col">{{__('Receivable')}}</th>
                                {{--  <th class="white-space-nowrap">{{__('ACTION')}}</th>  --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php $shopbalance=0; @endphp
                            @forelse($shops as $data)
                            @php $shopbalance=$data->where('status',0)->sum('balance_amount') - $data->where('status',1)->sum('balance_amount') @endphp
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$data->shop?->shop_name}}</td>
                                <td>{{$data->shop?->owner_name}}</td>
                                <td> @if($data->status==0)
                                        <span class="me-3">due-</span>{{ $data->balance_amount }}
                                    @elseif($data->status==1)
                                        <span class="me-3">pay-</span>{{ $data->balance_amount }}
                                    @endif
                                </td>
                                {{--  <td class="white-space-nowrap">
                                    <a href="{{route(currentUser().'.shop.edit',encryptor('encrypt',$data->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>  --}}
                            </tr>
                            @empty
                            <tr>
                                <th colspan="10" class="text-center">No Data Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                        @if(request('shop_id') > 0)
                            @if($shopbalance>0)
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end">Total</td>
                                        <td> <span class="me-5"></span>
                                            {{ $shopbalance }} Tk
                                            </td>
                                        {{--  <td></td>  --}}
                                    </tr>
                                </tfoot>
                            @endif
                        @endif
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
