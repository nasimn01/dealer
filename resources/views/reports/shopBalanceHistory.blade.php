@extends('layout.app')
@section('pageTitle',trans('Shop Balance History'))
@section('pageSubTitle',trans('Reports'))
@section('content')
@php $settings=App\Models\Settings\Company::first(); @endphp
</style>
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="text-end">
                    <button type="button" class="btn btn-info" onclick="printDiv('result_show')">Print</button>
                </div>
                <div class="card-content" id="result_show">
                    <style>

                        .tbl_border{
                        border: 1px solid darkblue;
                        border-collapse: collapse;
                        }
                        </style>
                    <div class="card-body">
                        <table style="width: 100%">
                            <tr style="text-align: center;">
                                <th colspan="2">
                                    <h3> {{ $settings->name }}</h3>
                                    <p>Address :{{ $settings->address }}</p>
                                    <p class="mb-1">Contact: {{ $settings->contact }}</p>
                                    <h6><span style="border-bottom: solid 1px;">{{$shop->shop_name}}</span></h6>
                                </th>
                            </tr>
                        </table>
                        <div class="tbl_scroll">
                            @php
                                $inAmount = 0;
                                $outAmount = 0;
                                $dueAmount = 0;
                            @endphp
                            <table class="tbl_border" style="width:100%">
                                <tbody>
                                    <tr class="tbl_border bg-secondary text-white">
                                        <th colspan="2" class="tbl_border" style="text-align: center; padding: 5px;">PARTICULARS</th>
                                        <th class="tbl_border" style="text-align: center; padding: 5px;">Balance In</th>
                                        <th class="tbl_border" style="text-align: center; padding: 5px;">Balance Out</th>
                                        <th class="tbl_border" style="text-align: center; padding: 5px;">Current Balance</th>
                                    </tr>
                                    <tr class="tbl_border bg-secondary text-white">
                                        <th class="tbl_border" style="text-align: center; padding: 5px;">Type</th>
                                        <th class="tbl_border" style="text-align: center; padding: 5px;">Date</th>
                                        <th class="tbl_border" style="text-align: center; padding: 5px;">In</th>
                                        <th class="tbl_border" style="text-align: center; padding: 5px;">Out</th>
                                        <th class="tbl_border" style="text-align: center; padding: 5px;">Total</th>
                                    </tr>
                                    @forelse($data as $d)
                                    <tr class="tbl_border">
                                        <td class="tbl_border" style="text-align: center; padding: 5px;">
                                           @if($d->status=='0') Out @elseif($d->status=='1') In @endif
                                        </td>
                                        <td class="tbl_border" style="text-align: center; padding: 5px;">
                                            @if ($d->status == '1')
                                                {{$d->new_due_date}}
                                            @else
                                                {{$d->created_at->format('Y-m-d')}}
                                            @endif
                                        </td>
                                        <td class="tbl_border" style="text-align: center; padding: 5px;">
                                            @if ($d->status == '1')
                                                {{$d->balance_amount}}
                                                @php
                                                    $inAmount += $d->balance_amount;
                                                @endphp
                                            @endif
                                        </td>
                                        <td class="tbl_border" style="text-align: center; padding: 5px;">
                                            @if ($d->status == '0')
                                                {{$d->balance_amount}}
                                                @php
                                                    $outAmount += $d->balance_amount;
                                                @endphp
                                            @endif
                                        </td>
                                        <td class="tbl_border" style="text-align: center; padding: 5px;"></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <th colspan="5">No data Found</th>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    @php
                                        $dueAmount = $inAmount-$outAmount;
                                    @endphp
                                    <tr>
                                        <th class="tbl_border" colspan="2" style="text-align: center; padding: 5px;">Total</th>
                                        <th class="tbl_border" style="text-align: center; padding: 5px;">{{$inAmount}}</th>
                                        <th class="tbl_border" style="text-align: center; padding: 5px;">{{$outAmount}}</th>
                                        <th class="tbl_border" style="text-align: center; padding: 5px;">{{$dueAmount}}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
