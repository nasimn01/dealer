@extends('layout.app')

@section('pageTitle',trans('Print Sales Closing'))
@section('pageSubTitle',trans('Show'))

@section('content')
@php $settings=App\Models\Settings\Company::first(); @endphp
<section id="result_show">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row text-center">
                            <h3> {{ $settings->name }}</h3>
                            <p class="mb-1">Contact: {{ $settings->contact }}</p>
                            <p>Address :{{ $settings->address }}</p>
                        </div>
                        <table style="width: 100%">
                            @if (!empty($sales->shop_id))
                            <tr>
                                <td style="width: 15%"><b>Shop Name</b></td>
                                <td style="width: 2%">:</td>
                                <td style="width: 83%">{{ $sales->shop?->shop_name}}</td>
                            </tr>
                            @endif
                            @if (!empty($sales->dsr_id))
                            <tr>
                                <td style="width: 15%"><b>DSR Name</b></td>
                                <td style="width: 2%">:</td>
                                <td style="width: 83%">{{ $sales->dsr?->name }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td style="width: 15%"><b>Sales Date</b></td>
                                <td style="width: 2%">:</td>
                                <td style="width: 83%">{{ $sales->sales_date }}</td>
                            </tr>
                        </table>
                        <!-- table bordered -->
                        <div class="row p-2 mt-4">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th rowspan="2">{{__('Product Name')}}</th>
                                            <th rowspan="2">{{__('CTN')}}</th>
                                            <th rowspan="2">{{__('PCS')}}</th>
                                            <th colspan="2">{{ __('Return') }}</th>
                                            <th colspan="2" class="text-danger">{{ __('Damage') }}</th>
                                            <th rowspan="2">{{__('Sales(PCS)')}}</th>
                                            <th rowspan="2">{{__('PCS(Price)')}}</th>
                                            <th rowspan="2">{{__('Sub-Total(Price)')}}</th>
                                        </tr>
                                        <tr>
                                            <th>CTN</th>
                                            <th>PCS</th>
                                            <th class="text-danger">CTN</th>
                                            <th class="text-danger">PCS</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sales_repeat">

                                        @if ($sales->sales_details)
                                            @foreach ($sales->sales_details as $salesdetails)
                                            @if ($salesdetails->status==0)
                                            <tr class="text-center">
                                                <td>{{ $salesdetails->product?->product_name }}</td>
                                                <td>{{ $salesdetails->ctn }}</td>
                                                <td>{{ $salesdetails->pcs }}</td>
                                                <td>{{ $salesdetails->ctn_return }}</td>
                                                <td>{{ $salesdetails->pcs_return }}</td>
                                                <td>{{ $salesdetails->ctn_damage }}</td>
                                                <td>{{ $salesdetails->pcs_damage }}</td>
                                                <td>{{ $salesdetails->total_sales_pcs }}</td>
                                                <td>
                                                    @if($salesdetails->tp_price) {{ $salesdetails->tp_price }}@else {{ $salesdetails->tp_free }} @endif
                                                </td>
                                                <td>{{ $salesdetails->subtotal_price }}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        @endif
                                        <tr class="text-center">
                                            <td class="text-end" colspan="9"><h5 for="totaltk">{{__('Total Taka')}}</h5></td>
                                            <td colspan="10">{{ $sales->daily_total_taka }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot id="tfootSection">
                                        <tr class="text-center">
                                            <th rowspan="2" colspan="3">{{__('Product Name')}}</th>
                                            {{--  <th rowspan="2">{{__('CTN')}}</th>  --}}
                                            {{--  <th rowspan="2">{{__('PCS')}}</th>  --}}
                                            <th colspan="2">{{ __('Return') }}</th>
                                            <th colspan="2" class="text-danger">{{ __('Damage') }}</th>
                                            <th rowspan="2" colspan="2">{{__('PCS(Price)')}}</th>
                                            <th rowspan="2">{{__('Sub-Total(Price)')}}</th>
                                        </tr>
                                        <tr>
                                            <th>CTN</th>
                                            <th>PCS</th>
                                            <th class="text-danger">CTN</th>
                                            <th class="text-danger">PCS</th>
                                        </tr>
                                        @if ($sales->sales_details)
                                        @foreach ($sales->sales_details as $salesdetails)
                                        @if ($salesdetails->status==1)
                                        <tr  class="text-center">
                                            <td colspan="3">{{ $salesdetails->product?->product_name }}</td>
                                            <td>{{ $salesdetails->ctn_return }}</td>
                                            <td>{{ $salesdetails->pcs_return }}</td>
                                            <td>{{ $salesdetails->ctn_damage }}</td>
                                            <td>{{ $salesdetails->pcs_damage }}</td>
                                            <td colspan="2">{{ $salesdetails->tp_price }}</td>
                                            {{--  <td>{{ $salesdetails->tp_price }}</td>  --}}
                                            <td>{{ $salesdetails->subtotal_price }}</td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @endif
                                        @if ($salesdetails->status==1)
                                        <tr>
                                            <td class="text-end" colspan="9"><h6 for="return_total">{{__('Return Total Taka')}}</h6></td>
                                            <td  class="text-center" colspan="10">{{ $sales->return_total_taka }} </td>
                                        </tr>
                                        @endif
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6">
                            <table class="table table-bordered mb-0 table-striped">
                                @if($sales->shop_balance)
                                <tr>
                                    <td class="text-center" colspan="2"><h5>Old Due</h5></td>
                                </tr>
                                @foreach ($sales->shop_balance as $balance)
                                @if($balance->status==0)
                                <tr>
                                    <td>{{ $balance->shop?->shop_name }}</td>
                                    <td>{{ $balance->balance_amount }}</td>
                                </tr>
                                @endif
                                @endforeach
                                @endif
                                <tr>
                                    <td><b>Sales Date</b></td>
                                    <td>{{ $sales->sales_date }}</td>
                                </tr>
                            </table>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-10">
                                @if($sales->shop_balance)
                                @foreach ($sales->shop_balance as $balance)
                                @if($balance->status==0)
                                <div class="row olddue">
                                    <div class="col-lg-2 col-md-3 col-sm-2">
                                        <div class="form-group">
                                            <h6 for="check">{{__('Old Due')}}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-3 col-sm-4">{{ $balance->shop?->shop_name }}</div>

                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">{{ $balance->balance_amount }}</div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                @endif
                                <hr>
                                @if($sales->shop_balance)
                                @foreach ($sales->shop_balance as $balance)
                                @if($balance->status==1)
                                <div class="row newdue">
                                    <div class="col-lg-2 col-md-3 col-sm-6">
                                        <div class="form-group">
                                            <h6 for="check">{{__('New Due')}}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-3 col-sm-6 shopNameContainer">{{ $balance->shop?->shop_name }}</div>
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="form-group">{{ $balance->balance_amount}}</div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                @endif
                                <hr>

                                @if($sales->sales_payment)
                                @foreach ($sales->sales_payment as $payments)
                                @if($payments->cash_type==1)
                                <div class="row new_receive">
                                    <div class="col-lg-2 col-md-3 col-sm-6">
                                        <div class="form-group">
                                            <h6 for="check">{{__('New Receive')}}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-3 col-sm-6 shopNameContainer">
                                        {{ $payments->shop?->shop_name }}
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="form-group"> {{ old('new_receive_tk',$payments->amount)}}</div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                @endif

                                @if($sales->sales_payment)
                                @foreach ($sales->sales_payment as $payments)
                                @if($payments->cash_type==0)
                                <div class="row check_no">
                                    <div class="col-lg-2 col-md-3 col-sm-6">
                                        <div class="form-group">
                                            <h5 for="check">{{__('Check')}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-3 col-sm-6 shopNameContainer">
                                        {{ $payments->shop?->shop_name }}
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="form-group">
                                            {{ $payments->amount}}
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-6">
                                        <div class="form-group">
                                            {{ $payments->check_date }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                @endif

                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <div class="form-group">
                                            <h6 for="expenses">{{__('Expenses')}}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-9 col-sm-8">
                                        <div class="form-group">
                                            {{ $sales->expenses}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <div class="form-group">
                                            <h5 for="commission">{{__('Commission')}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-9 col-sm-8">
                                        <div class="form-group">
                                            {{ $sales->commission}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <div class="form-group">
                                            <h5 for="total">{{__('Final Total')}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-9 col-sm-8">
                                        <div class="form-group">
                                            {{ $sales->final_total}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end my-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<button type="button" class="btn btn-info" onclick="printDiv('result_show')">Print</button>
@endsection
{{--  @push('scripts')
<script>
    function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
@endpush  --}}
