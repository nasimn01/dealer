@extends('layout.app')

@section('pageTitle','Add Supplier Balance')
@section('pageSubTitle','add balance')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="text-center"><h5>Add Balance</h5></div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" action="{{route(currentUser().'.supplier.update',encryptor('encrypt',$supplier->id))}}">
                            @csrf
                            @method('patch')
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr class="bg-light">
                                                <th>Supplier Name</th>
                                                <td>{{$supplier->name}}</td>
                                            </tr>
                                            <tr class="bg-light">
                                                <th>Supplier Code</th>
                                                <td>{{$supplier->supplier_code}}</td>
                                            </tr>
                                            <tr class="bg-light">
                                                <th>Current Balance</th>
                                                <td>{{$supplier->balances?->sum('balance_amount')}}</td>
                                            </tr>
                                            <tr>
                                                <th>Add Balance</th>
                                                <td><input type="number" value="{{old('balance')}}" class="form-control" name="balance" placeholder="add balance"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                               
                                <input type="hidden" value="{{old('supplier_code',$supplier->supplier_code)}}" class="form-control" name="supplier_code" required>
                                <input type="hidden" value="{{old('name',$supplier->name)}}" class="form-control" name="name" required>
                                <input type="hidden" value="{{old('contact',$supplier->contact)}}" class="form-control" name="contact">
                                <input type="hidden" value="{{old('email',$supplier->email)}}" class="form-control" name="email">
                                <input type="hidden" value="{{old('country',$supplier->country)}}" class="form-control" name="country">
                                <input type="hidden" value="{{old('city',$supplier->city)}}" class="form-control" name="city">
                                <textarea class="form-control" name="address" rows="2" style="display: none;">{{old('address',$supplier->country)}}</textarea>
                                   

                                <div class="col-lg-8 offset-lg-2 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Add Balance</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
