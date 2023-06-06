@extends('layout.app')

@section('pageTitle','Add Customer Balance')
@section('pageSubTitle','add balance')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="text-center"><h5>Add Balance</h5></div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" action="{{route(currentUser().'.customer.update',encryptor('encrypt',$customer->id))}}">
                            @csrf
                            @method('patch')
                            <div class="row">
                                <div class="col-lg-8 offset-lg-2">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr class="bg-light">
                                                <th>Customer Name</th>
                                                <td>{{$customer->name}}</td>
                                            </tr>
                                            <tr class="bg-light">
                                                <th>Customer Code</th>
                                                <td>{{$customer->customer_code}}</td>
                                            </tr>
                                            <tr class="bg-light">
                                                <th>Current Balance</th>
                                                <td>{{$customer->balances?->sum('balance_amount')}}</td>
                                            </tr>
                                            <tr>
                                                <th>Add Balance</th>
                                                <td ><input type="number" value="{{old('balance')}}" class="form-control" name="balance" placeholder="add balance"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                               
                                <input type="hidden" value="{{old('customer_code',$customer->customer_code)}}" class="form-control" name="customer_code" required>
                                <input type="hidden" value="{{old('name',$customer->name)}}" class="form-control" name="name" required>
                                <input type="hidden" value="{{old('contact',$customer->contact)}}" class="form-control" name="contact">
                                <input type="hidden" value="{{old('email',$customer->email)}}" class="form-control" name="email">
                                <input type="hidden" value="{{old('country',$customer->country)}}" class="form-control" name="country">
                                <input type="hidden" value="{{old('city',$customer->city)}}" class="form-control" name="city">
                                <textarea class="form-control" name="address" rows="2" style="display: none;">{{old('address',$customer->country)}}</textarea>
                                   

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
