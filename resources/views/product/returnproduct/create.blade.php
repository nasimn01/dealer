@extends('layout.app')

@section('pageTitle',trans('Create Return Product'))
@section('pageSubTitle',trans('Create'))

@section('content')
  <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" enctype="multipart/form-data" action="{{route(currentUser().'.returnproduct.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="driver_name">{{__('Driver Name')}}</label>
                                            <input type="text" class="form-control" value="{{ old('driver_name')}}" name="driver_name">

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="helper">{{__('Helper')}}</label>
                                            <input type="text" class="form-control" value="{{ old('helper')}}" name="helper">

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="garir_number">{{__('Garir Number')}}</label>
                                            <input type="text" class="form-control" value="{{ old('garir_number')}}" name="garir_number">

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="invoice_number">{{__('Invoice Number')}}</label>
                                            <input type="text" class="form-control" value="{{ old('invoice_number')}}" name="invoice_number">

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="note">Note</label>
                                            <textarea class="form-control" name="note" rows="2">{{old('note')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="container" id="product">
                                    <main>
                                        <div class="row mt-3">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <label class="py-2" for="product">{{__('Product')}}<span class="text-danger">*</span></label>
                                                    <select class=" choices form-select" name="product_id[]">
                                                        <option value="">Select Product</option>
                                                        @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                                                        <option value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 qty">
                                                <label class="py-2" for="qty">{{__('Quantity')}}<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="qty[]" onkeyup="get_price(this)">
                                            </div>
                                            <div class="col-lg-2 totalPrice">
                                                <label class="py-2" for="unite_style">{{__('Unit Style')}}<span class="text-danger">*</span></label>
                                                <select class=" choices form-select" name="unite_style_id[]">
                                                    <option value="">Select style</option>
                                                    @forelse (\App\Models\Settings\Unit_style::all(); as $us)
                                                    <option value="{{ $us->id }}">{{ $us->name }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                                {{--  <label class="py-2" for="price">{{__('Total Price')}}<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="total_price[]" onkeyup="get_price(this)">  --}}
                                            </div>
                                            <div class="col-lg-1">
                                                <label class="py-2" for="free">{{__('Free')}}</label>
                                                <input type="number" class="form-control" name="free[]">
                                            </div>
                                            <div class="col-lg-1">
                                                <label class="py-2" for="free_tk">{{__('Free TK')}}</label>
                                                <input type="number" class="form-control" name="free_tk[]">
                                            </div>
                                            <div class="col-lg-1">
                                                <label class="py-2" for="free_ratio">{{__('Free Ratio')}}</label>
                                                <input type="number" class="form-control" name="free_ratio[]">
                                            </div>
                                            <div class="col-lg-1 buyPrice">
                                                <label class="py-2" for="price">{{__('Tp Price')}}<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="price[]" placeholder="price" onkeyup="get_price(this)">
                                            </div>
                                            <div class="col-lg-1 basic">
                                                <label class="py-2" for="basic">{{__('Basic')}}<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control pbasic" name="basic[]" value="" readonly="readonly">
                                            </div>
                                            <div class="col-lg-1 dis">
                                                <label class="py-2" for="discount">{{__('Dis%')}}</label>
                                                <input type="number" class="form-control" name="discount_percent[]" onkeyup="get_price(this)">
                                                <input name="discount_percent[]" type="hidden" value="" class="form-control pdisamt"/>
                                            </div>
                                            <div class="col-lg-1 tax">
                                                <label class="py-2" for="tax">{{__('Tax%')}}</label>
                                                <input type="number" class="form-control" name="vat_percent[]" onkeyup="get_price(this)">
                                                <input name="vat_percent[]" type="hidden" value="" class="form-control ptaxamt"/>
                                            </div>
                                            <div class="col-lg-2 ps-0 tamount">
                                                <label class="py-2" for="amount"><b>{{__('Amount')}}</b></label><br>
                                                    <input type="number" class="form-control" name="amount[]" readonly="readonly">
                                                </div>
                                                <div class="col-lg-12 d-flex justify-content-end">
                                                <span onClick='remove_row();' class="delete-row text-danger"><i class="bi bi-trash-fill" style="font-size:1.5rem; color:rgb(230, 5, 5)"></i></span>
                                                <span onClick='add_row();' class="add-row text-primary"><i class="bi bi-plus-square-fill" style="font-size:1.5rem;"></i></span>
                                            </div>
                                        </div>
                                    </main>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4 class="header-title">Total Bill</h4>
                                        <div class="total-payment">
                                            <table class="table table-sm table-borderless ">
                                                <tbody>
                                                    <tr>
                                                        <td width="20%">Subtotal</td>
                                                        <td width="2%">:</td>
                                                        <td width="78%"><input type="text" value="" class="form-control tsub" onkeyup="cal_final_amount()" name="sub_total"/></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%">Vat/Tax</td>
                                                        <td width="2%">:</td>
                                                        <td width="78%"><input type="text" class="form-control ttax" onkeyup="cal_final_amount()" name="vat_amount"></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="20%">Discount</td>
                                                        <td width="2%">:</td>
                                                        <td width="78%"><input type="text" class="form-control tdis" onkeyup="cal_final_amount()" name="discount_amount"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 " style="margin-top: 2.3rem">
                                        <div class="total">
                                            <table class="table table-sm table-borderless ">
                                                <tbody>
                                                    {{-- <tr>
                                                        <td><h4>Total</h4></td>
                                                        <td><input type="text" class="form-control" name="" value="0"></td>
                                                    </tr> --}}
                                                    <tr>
                                                        <td width="20%">Other Charge</td>
                                                        <td width="2%">:</td>
                                                        <td width="78%"><input type="number" class="form-control tcharge" onkeyup="cal_final_amount()" name="other_charge"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <table class="table table-sm table-borderless ">
                                            <tbody>
                                                <tr>
                                                    <td class="text-end"><h4>Total</h4></td>
                                                    <td><input type="text" class="form-control ttotal" name="total" onkeyup="cal_final_amount()" value="0"></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <div class="col-lg-2 offset-5 d-flex justify-content-between">
                                            <button type="submit" class="btn btn-primary btn-block m-2">Save</button>
                                        </div>
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
<script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-element-select.js') }}"></script>
<script>
    function add_row(){

var row=`<main>
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <label class="py-2" for="product">{{__('Product')}}<span class="text-danger">*</span></label>
                <select class=" choices form-select" name="product_id[]">
                    <option value="">Select Product</option>
                    @forelse (\App\Models\Product\Product::where(company())->get(); as $pro)
                    <option value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-lg-1 qty">
            <label class="py-2" for="qty">{{__('Quantity')}}<span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="qty[]" onkeyup="get_price(this)">
        </div>
        <div class="col-lg-2 totalPrice">
            <label class="py-2" for="unite_style">{{__('Unit Style')}}<span class="text-danger">*</span></label>
            <select class=" choices form-select" name="unite_style_id[]">
                <option value="">Select style</option>
                @forelse (\App\Models\Settings\Unit_style::all(); as $us)
                <option value="{{ $us->id }}">{{ $us->name }}</option>
                @empty
                @endforelse
            </select>
        </div>
        <div class="col-lg-1">
            <label class="py-2" for="free">{{__('Free')}}</label>
            <input type="number" class="form-control" name="free[]">
        </div>
        <div class="col-lg-1">
            <label class="py-2" for="free_tk">{{__('Free TK')}}</label>
            <input type="number" class="form-control" name="free_tk[]">
        </div>
        <div class="col-lg-1">
            <label class="py-2" for="free_ratio">{{__('Free Ratio')}}</label>
            <input type="number" class="form-control" name="free_ratio[]">
        </div>
        <div class="col-lg-1 buyPrice">
            <label class="py-2" for="price">{{__('Tp Price')}}<span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="price[]" placeholder="price" onkeyup="get_price(this)">
        </div>
        <div class="col-lg-1 basic">
            <label class="py-2" for="basic">{{__('Basic')}}<span class="text-danger">*</span></label>
            <input type="number" class="form-control pbasic" name="basic[]" value="" readonly="readonly">
        </div>
        <div class="col-lg-1 dis">
            <label class="py-2" for="discount">{{__('Dis%')}}</label>
            <input type="number" class="form-control" name="discount_percent[]" onkeyup="get_price(this)">
            <input name="discount_percent[]" type="hidden" value="" class="form-control pdisamt"/>
        </div>
        <div class="col-lg-1 tax">
            <label class="py-2" for="tax">{{__('Tax%')}}</label>
            <input type="number" class="form-control" name="vat_percent[]" onkeyup="get_price(this)">
            <input name="vat_percent[]" type="hidden" value="" class="form-control ptaxamt"/>
        </div>
        <div class="col-lg-2 ps-0 tamount">
            <label class="py-2" for="amount"><b>{{__('Amount')}}</b></label><br>
                <input type="number" class="form-control" name="amount[]" readonly="readonly">
            </div>
            <div class="col-lg-12 d-flex justify-content-end">
            <span onClick='remove_row();' class="delete-row text-danger"><i class="bi bi-trash-fill" style="font-size:1.5rem; color:rgb(230, 5, 5)"></i></span>
            <span onClick='add_row();' class="add-row text-primary"><i class="bi bi-plus-square-fill" style="font-size:1.5rem;"></i></span>
        </div>
    </div>
</main>`;
    $('#product').append(row);
}

function remove_row(){
    $('#product main').last().remove();
}
</script>

<script>
	function get_price(e){
		//get sub total

		if($(e).parent().hasClass('totalPrice')){
			totalPrice=parseFloat($(e).val());
			sqty=parseFloat($(e).parents().siblings('.qty').children("input").val());
			if($(e).parent().siblings().hasClass('buyPrice')){
				let perItemPrice = parseFloat(totalPrice / sqty).toFixed(2)
				$(e).parents().siblings('.buyPrice').children("input").val(perItemPrice)
				sprice = $(e).parents().siblings('.buyPrice').children("input").val()
			}
			sdiscountd=parseFloat($(e).parents().siblings('.dis').children("input").val());
			stax=parseFloat($(e).parents().siblings('.tax').children("input").val());
		}
		else if($(e).parent().hasClass('buyPrice')){
			sprice=parseFloat($(e).val());
			sqty=parseFloat($(e).parents().siblings('.qty').children("input").val());
			sdiscountd=parseFloat($(e).parents().siblings('.dis').children("input").val());
			stax=parseFloat($(e).parents().siblings('.tax').children("input").val());
		}
		else if($(e).parent().hasClass('qty')){
			sqty=parseFloat($(e).val());
			sprice=parseFloat($(e).parents().siblings('.buyPrice').children("input").val());
			sdiscountd=parseFloat($(e).parents().siblings('.dis').children("input").val());
			stax=parseFloat($(e).parents().siblings('.tax').children("input").val());
		}
		else if($(e).parent().hasClass('dis')){
			sdiscountd=parseFloat($(e).val());
			sprice=parseFloat($(e).parents().siblings('.buyPrice').children("input").val());
			sqty=parseFloat($(e).parents().siblings('.qty').children("input").val());
			stax=parseFloat($(e).parents().siblings('.tax').children("input").val());
		}
		else if($(e).parent().hasClass('tax')){
			stax=parseFloat($(e).val());
			sprice=parseFloat($(e).parents().siblings('.buyPrice').children("input").val());
			sqty=parseFloat($(e).parents().siblings('.qty').children("input").val());
			sdiscountd=parseFloat($(e).parents().siblings('.dis').children("input").val());
		}

		var stax=stax?stax:0;
		var sprice=sprice?sprice:0;
		var sqty=sqty?sqty:0;
		var sdiscountd=sdiscountd?sdiscountd:0;
		var basic=sprice*sqty;
		var disamt=(basic*(sdiscountd/100));
		var taxamt=(basic*(stax/100));

		if(disamt)
			if($(e).parent().hasClass('dis'))
				$(e).siblings('.pdisamt').val(disamt);
			else
				$(e).parents().siblings('.dis').children(".pdisamt").val(disamt);

		if(taxamt)
			if($(e).parent().hasClass('tax'))
				$(e).siblings('.ptaxamt').val(taxamt);
			else
				$(e).parents().siblings('.tax').children(".ptaxamt").val(taxamt);


			total=basic - disamt + taxamt;

		$(e).parents().siblings('.basic').children("input").val(basic)
		$(e).parents().siblings('.tamount').children("input").val(total)

		//update Total Bill
		cal_total();
		cal_final_change();
	}
</script>

<script>
    /* for check if due or change */
    function cal_final_change(predefinedamount=""){
        var subTotalInput = $('input[name=sub_total]').val();

        var total_cal=parseFloat($('.ttotal').val());
        var totalpaid=parseFloat(predefinedamount) > 0 ? parseFloat(predefinedamount) : parseFloat($('#tpaid').val());
        var amremain=0;
        if(total_cal>totalpaid){
            amremain=(total_cal-totalpaid);
            $('.tchange').val(amremain.toFixed(2) +' Due');
            $('.tdue').val(amremain.toFixed(2));
            $('#due_date').show();
            $('.tchange').css('color','red');
        }else if(total_cal<totalpaid){
            amremain=(totalpaid-total_cal);
            $('.tchange').val(amremain.toFixed(2) +' Change');
            $('.tdue').val(0);
            $('#due_date').hide();
            $('.tchange').css('color','green');
        }else{
            $('.tchange').val(0);
            $('.tdue').val(0);
            $('#due_date').hide();
            $('.tchange').css('color','black');
        }
    }

    function cal_total(){
        var pbasic = 0;
            //total basic price
            $(".pbasic").each(function() {
                //add only if the value is number
                if(!isNaN(this.value) && this.value.length!=0) {
                    pbasic += parseFloat(this.value);
                }
            });

        var pdisamt = 0;
            //total basic price
            $(".pdisamt").each(function() {
                //add only if the value is number
                if(!isNaN(this.value) && this.value.length!=0) {
                    pdisamt += parseFloat(this.value);
                }
            });

        var ptaxamt = 0;
        //total basic price
        $(".ptaxamt").each(function() {
            //add only if the value is number
            if(!isNaN(this.value) && this.value.length!=0) {
                ptaxamt += parseFloat(this.value);
            }
        });

        var tax=ptaxamt;
        var dis=pdisamt;
        var basic=pbasic;
        if(tax)tax=tax; else tax=0;
        if(dis)dis=dis; else dis=0;
        if(basic)basic=basic; else basic=0;
        //if(due)due=due; else due=0;
        var total= (basic+tax)-dis;
       // alert(basic);
        $('.tsub').val(basic.toFixed(2));
        $('.ttax').val(tax.toFixed(2));
        $('.tdis').val(dis.toFixed(2));
        $('.ttotal').val(total.toFixed(2));
        /*	call amount in word function */
        amount_in_word();
    }

    function cal_final_amount(){
        var tsub=parseFloat($('.tsub').val());
        var ttax=parseFloat($('.ttax').val());
        var tdis=parseFloat($('.tdis').val());
        var tdue=parseFloat($('.tdue').val());
        var tcharge=parseFloat($('.tcharge').val());
        if(tsub)tsub=tsub; else tsub=0;
        if(ttax)ttax=ttax; else ttax=0;
        if(tdis)tdis=tdis; else tdis=0;
        if(tdue)tdue=tdue; else tdue=0;
        if(tcharge)tcharge=tcharge; else tcharge=0;

        var total= ((tsub+ttax+tcharge)-tdis);
        $('.ttotal').val(total.toFixed(2));

    /*	recall change function */
        cal_final_change();
        amount_in_word();
    }
    </script>

@endpush
