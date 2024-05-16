@extends('layout.app')
@section('pageTitle','Create Shop')
@section('pageSubTitle','Create')
@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" action="{{route(currentUser().'.shop.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="sup_id">Distributor<span class="text-danger">*</span></label>
                                        <select class="form-select border border-primary" name="sup_id" onchange="srShow(this.value);" required>
                                            <option value="">Select</option>
                                            @forelse (App\Models\Settings\Supplier::where(company())->get(); as $sup)
                                                <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="sr_id">SR <span class="text-danger">*</span></label>
                                        <select class="form-select border border-primary" name="sr_id" id="srUser_id">
                                            <option value="">Select</option>
                                            @forelse (\App\Models\User::where(company())->where('role_id',5)->get(); as $sr)
                                                <option class="selecet_hide selecet_hide{{$sr->distributor_id}}" value="{{ $sr->id }}">{{ $sr->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="shop_name">Shop Name<span class="text-danger">*</span></label>
                                        <input type="text" value="{{old('shop_name')}}" class="form-control border border-primary" name="shop_name" placeholder="Shop Name" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="owner_name">Owner Name<span class="text-danger">*</span></label>
                                        <input type="text" value="{{old('owner_name')}}" class="form-control border border-primary" name="owner_name" placeholder="Owner Name" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6 d-none">
                                    <div class="form-group">
                                        <label for="dsr_id">DSR <span class="text-danger">*</span></label>
                                        <select class="form-select border border-primary" name="dsr_id">
                                            <option value="">Select</option>
                                            @forelse (\App\Models\User::where(company())->where('role_id',4)->get(); as $dsr)
                                                <option value="{{ $dsr->id }}">{{ $dsr->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="contact">Contact No</label>
                                        <input type="text" value="{{old('contact')}}" class="form-control border border-primary" placeholder="Contact" name="contact">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="balance">Opening Balance</label>
                                        <input type="number" value="{{old('balance')}}" class="form-control border border-primary" name="balance">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control border border-primary" name="address" rows="2">{{old('address')}}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="area_name">Area Name</label>
                                        <textarea class="form-control border border-primary" name="area_name" rows="2">{{old('area_name')}}</textarea>
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
@push('scripts')
<script>
    /* call on load page */
    $(document).ready(function(){
       $('.selecet_hide').hide();
   })
   let old_supplier_id=0;
   function srShow(value){
        let supplier = value;
         $('.selecet_hide').hide();
         $('.selecet_hide'+supplier).show();
         if(old_supplier_id!=supplier){
            $('#srUser_id').prop('selectedIndex', 0);
             old_supplier_id=supplier;
         }
    }
</script>
@endpush
