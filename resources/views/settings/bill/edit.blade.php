@extends('layout.app')

@section('pageTitle',trans('Update Bill Term'))
@section('pageSubTitle',trans('Update'))

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" action="{{route(currentUser().'.bill.update',encryptor('encrypt',$bill->id))}}">
                            @csrf
                            @method('PATCH')
                            
                            <div class="row">
                                <div class="col-8 offset-2">
                                    <div class="form-group">
                                        <label for="bill">{{__('Bill Term')}}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" value="{{ old('bill',$bill->name)}}" name="bill" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-8 offset-2 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-info me-1 mb-1">Update</button>
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
