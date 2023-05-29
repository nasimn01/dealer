@extends('layout.app')
@section('pageTitle','Supplier List')
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
                                    <input type="text" name="name" value="{{isset($_GET['name'])?$_GET['name']:''}}" placeholder="Name" class="form-control">
                                </div>
                                <div class="col-4">
                                    <input type="text" name="supplier_code" value="{{isset($_GET['supplier_code'])?$_GET['supplier_code']:''}}" placeholder="Supplier Code" class="form-control">
                                </div>
                                
                                <div class="col-2 ps-0">
                                    <button class="btn btn-sm btn-info float-end" type="submit">Search</button>
                                </div>
                                <div class="col-2 p-0 m-0">
                                    <a class="btn btn-sm btn-warning ms-2" href="{{route(currentUser().'.supplier.index')}}" title="Clear">Clear</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-2">
                        <a class="float-end" href="{{route(currentUser().'.supplier.create')}}"style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>
                    </div>
                </div>
                
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Supplier Code')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Contact')}}</th>
                                <th scope="col">{{__('Email')}}</th>
                                <th scope="col">{{__('Country')}}</th>
                                <th scope="col">{{__('City')}}</th>
                                <th scope="col">{{__('Old Balance')}}</th>
                                <th scope="col">{{__('Address')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suppliers as $data)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$data->supplier_code}}</td>
                                <td>{{$data->name}}</td>
                                <td>{{$data->contact}}</td>
                                <td>{{$data->email}}</td>
                                <td>{{$data->country}}</td>
                                <td>{{$data->city}}</td>
                                <td>{{$data->balance}}</td>
                                <td>{{$data->address}}</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route(currentUser().'.supplier.edit',encryptor('encrypt',$data->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    {{-- <a href="javascript:void()" onclick="$('#form{{$data->id}}').submit()">
                                        <i class="bi bi-trash"></i>
                                    </a> -->
                                    <form id="form{{$data->id}}" action="{{route(currentUser().'.supplier.destroy',encryptor('encrypt',$data->id))}}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>--}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="10" class="text-center">No Data Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="pt-2">
                        {{$suppliers->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

