@extends('layout.app')

@section('pageTitle',trans('Sales List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section id="result_show">
@php $settings=App\Models\Settings\Company::first(); @endphp
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
                                            <th scope="col">{{__('Product Name')}}</th>
                                            <th scope="col">{{__('CTN')}}</th>
                                            <th scope="col">{{__('PCS')}}</th>
                                            <th scope="col">{{__('Tp/Tpfree')}}</th>
                                            <th scope="col">{{__('CTN Price')}}</th>
                                            <th scope="col">{{__('PCS Price')}}</th>
                                            <th scope="col">{{__('Sub-Total')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sales_repeat">
                                        @if ($sales->temporary_sales_details)
                                            @foreach ($sales->temporary_sales_details as $salesdetails)
                                                <tr class="text-center">
                                                    <td>{{ $salesdetails->product?->product_name }}</td>
                                                    <td>{{ $salesdetails->ctn }}</td>
                                                    <td>{{ $salesdetails->pcs }}</td>
                                                    <td>
                                                        @if($salesdetails->select_tp_tpfree ==1)TP @else($salesdetails->select_tp_tpfree ==2)TP Free @endif
                                                    </td>
                                                    <td>{{ $salesdetails->ctn_price }}</td>
                                                    <td>{{ $salesdetails->pcs_price }}</td>
                                                    <td>
                                                        {{ $salesdetails->subtotal_price }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" class="text-end"><h6>Total</h6></td>
                                            <td class="text-center">{{ $sales->total }} TK</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<button type="button" class="btn btn-info" onclick="printDiv('result_show')">Print</button>
@endsection
@push('scripts')
<script>
    function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
@endpush
