@extends('layout.app')

@section('pageTitle',trans('Create Product'))
@section('pageSubTitle',trans('Create'))

@section('content')
  <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" enctype="multipart/form-data" action="{{route(currentUser().'.product.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="group_id">{{__('Group')}}<span class="text-danger">*</span></label>
                                            <select required name="group_id" class="form-control form-select" >
                                                <option value="">Select</option>
                                                @forelse($group as $d)
                                                    <option value="{{$d->id}}" {{ old('group_id')==$d->id?"selected":""}}> {{ $d->name}}</option>
                                                @empty
                                                    <option value="">No data found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="category_id">{{__('Category')}}<span class="text-danger">*</span></label>
                                            <select required name="category_id" class="form-control form-select" >
                                                <option value="">Select</option>
                                                @forelse($category as $d)
                                                    <option value="{{$d->id}}" {{ old('category_id')==$d->id?"selected":""}}> {{ $d->name}}</option>
                                                @empty
                                                    <option value="">No data found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="unit_style_id">{{__('Unit Style')}}</label>
                                            <select onchange="tpFree(this)" name="unit_style_id" class="form-control form-select unit_style_id">
                                                <option value="">Select</option>
                                                @forelse($unit_style as $d)
                                                    <option value="{{$d->id}}" {{ old('unit_style_id')==$d->id?"selected":""}}> {{ $d->name}}</option>
                                                @empty
                                                    <option value="">No data found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="product_name">{{__('Product Name')}}</label>
                                            <input type="text" class="form-control" value="{{ old('product_name')}}" name="product_name">

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="free_ratio">{{__('Free Ratio')}}</label>
                                            <input type="number" onkeyup="tpFree(this)" class="form-control free_ratio" value="{{ old('free_ratio')}}" name="free_ratio">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="free">{{__('Free(PCS)')}}</label>
                                            <input type="number" onkeyup="tpFree(this)" class="form-control free_pcs" value="{{ old('free')}}" name="free pcs">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="dp_price">{{__('DP Price')}}</label>
                                            <input type="number" class="form-control" value="{{ old('dp_price')}}" name="dp_price">

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="tp_price">{{__('TP Price')}}</label>
                                            <input type="number" onkeyup="tpFree(this)" class="form-control tp_price" value="{{ old('tp_price')}}" name="tp_price">

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="tp_free">{{__('TP Free')}}</label>
                                            <input type="text" readonly class="form-control tp_free" value="{{ old('tp_free')}}" name="tp_free">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="mrp_price">{{__('MRP Price')}}</label>
                                            <input type="number" class="form-control" value="{{ old('mrp_price')}}" name="mrp_price">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="free_taka">{{__('Free Taka')}}</label>
                                            <input type="number" class="form-control" value="{{ old('free_taka')}}" name="free_taka">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="adjust">{{__('Adjust')}}</label>
                                            <input type="text" class="form-control" value="{{ old('adjust')}}" name="adjust">
                                        </div>
                                    </div>
                                    {{--  <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="base_unit">{{__('Unit')}}</label>
                                            <select name="base_unit" class="form-control form-select" >
                                                <option value="">Select</option>
                                                @forelse($base_unit as $d)
                                                    <option class="unit unit{{$d->unit_style_id}}" value="{{$d->id}}" {{ old('base_unit')==$d->id?"selected":""}}> {{ $d->name}}</option>
                                                @empty
                                                    <option value="">No data found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>  --}}
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="color">{{__('Color')}}</label>
                                            <input type="text" class="form-control" value="{{ old('color')}}" name="color">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="size">{{__('Size')}}</label>
                                            <input type="text" class="form-control" value="{{ old('size')}}" name="size">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="weight">{{__('Weight')}}</label>
                                            <input type="text" class="form-control" value="{{ old('weight')}}" name="weight">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="" for="cat">{{__('Distributor')}}</label>
                                            <select class="choices form-select supplier_id" name="distributor_id">
                                                <option value="">Select Distributor</option>
                                                @forelse (App\Models\Settings\Supplier::where(company())->get() as $sup)
                                                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                                @empty
                                                    <option value="">No Data Found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="image">{{__('Image')}}</label>
                                            <input type="file" class="form-control" value="{{ old('image')}}" name="image">

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
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
        $('.unit').hide();
    });

    function show_unit(e){
        $('.unit').hide();
        $('.unit'+e).show()
    }
</script>
<script>
    function tpFree(e){
        let unitStyleId=$('.unit_style_id').find(":selected").val();
        let freeRatio=parseFloat($('.free_ratio').val());
        let freePcs=$('.free_pcs').val();
        let tpPrice=$('.tp_price').val()?parseFloat($('.tp_price').val()):0;;
        //console.log(tpPrice)
        $.ajax({
            url: "{{route(currentUser().'.unit_pcs_get')}}",
            type: "GET",
            dataType: "json",
            data: { unit_style_id:unitStyleId },
            success: function(data) {
            //console.log(data);
            if(tpPrice){
                let total=((data/freeRatio)*freePcs);
                let tpfreeCal=(parseInt(total)+parseInt(data));
                let tpfree=(parseInt(tpPrice*data)/parseInt(tpfreeCal)).toFixed(2);
                $('.tp_free').val(tpfree);
            }

            },
        });
    }
</script>
@endpush
