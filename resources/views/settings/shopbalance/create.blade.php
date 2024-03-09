@extends('layout.app')
@section('pageTitle','Collection Shop')
@section('pageSubTitle','Collection')
@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" action="{{route(currentUser().'.shopbalance.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="shop_name">Shop Name(Owner)<span class="text-danger">*</span></label>
                                        <select class="select2 form-select shop_id" name="shop_id">
                                            <option value="">Select</option>
                                            @foreach ($shops as $s)
                                            <option value="{{ $s->id }}">{{ $s->shop_name }}({{ $s->owner_name }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- @if($errors->has('shop_name'))
                                        <span class="text-danger"> {{ $errors->first('shop_name') }}</span>
                                    @endif --}}
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="balance_amount">Amount<span class="text-danger">*</span></label>
                                        <input type="number" value="{{old('balance_amount')}}" class="form-control border border-primary" name="balance_amount" placeholder="Amount" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="date">Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" value="{{ old('new_collect_date')}}" name="new_collect_date" placeholder="Date">
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>
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
