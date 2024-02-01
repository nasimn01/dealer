@extends('layout.app')
@section('pageTitle',trans('Dashboard'))

@section('content')

<div class="page-content py-3">
    <section class="row">
       <div class="col-md-3 col-sm-6 col-lg-3">
            <div class="info-box">
                <span class="info-box-icon bg-aqua">
                <i class="bi bi-boxes icon"></i>
                </span>
                <div class="info-box-content">
                    <span class="text-bold text-uppercase">Total Stock</span>
                    <span class="info-box-number">৳  0.00</span>
                </div>
            </div>
       </div>
       <div class="col-md-3 col-sm-6 col-lg-3">
            <div class="info-box">
                <span class="info-box-icon bg-yellow">
                <i class="bi bi-currency-dollar icon"></i>
                </span>
                <div class="info-box-content">
                    <span class="text-bold text-uppercase">Total Collection</span>
                    <span class="info-box-number">৳  0.00</span>
                </div>
            </div>
       </div>
       <div class="col-md-3 col-sm-6 col-lg-3">
            <div class="info-box">
                <span class="info-box-icon bg-green">
                <i class="bi bi-cart icon"></i>
                </span>
                <div class="info-box-content">
                    <span class="text-bold text-uppercase">Total Sales Amount</span>
                    <span class="info-box-number">৳  0.00</span>
                </div>
            </div>
       </div>
       <div class="col-md-3 col-sm-6 col-lg-3">
            <div class="info-box">
                <span class="info-box-icon bg-red">
                <i class="bi bi-dash-square icon"></i>
                </span>
                <div class="info-box-content">
                    <span class="text-bold text-uppercase">Total Expense Amount</span>
                    <span class="info-box-number">৳  0.00</span>
                </div>
            </div>
       </div>
       {{--  <div class="col-md-3 col-sm-6 col-lg-3">
            <div class="info-box">
                <span class="info-box-icon bg-red">
                <i class="bi bi-dash-square icon"></i>
                </span>
                <div class="info-box-content">
                    <span class="text-bold text-uppercase">Total Expense Amount</span>
                    <span class="info-box-number">৳  0.00</span>
                </div>
            </div>
       </div>  --}}
    </section>
    <section class="row">
       <div class="col-md-3 col-sm-6 col-lg-3">
            <div class="info-box">
                <span class="info-box-icon bg-aqua">
                <i class="bi bi-boxes icon"></i>
                </span>
                <div class="info-box-content">
                    <span class="text-bold text-uppercase">Todays Stock Out</span>
                    <span class="info-box-number">৳  0.00</span>
                </div>
            </div>
       </div>
       <div class="col-md-3 col-sm-6 col-lg-3">
            <div class="info-box">
                <span class="info-box-icon bg-yellow">
                <i class="bi bi-currency-dollar icon"></i>
                </span>
                <div class="info-box-content">
                    <span class="text-bold text-uppercase">Collection Due</span>
                    <span class="info-box-number">৳  0.00</span>
                </div>
            </div>
       </div>
       <div class="col-md-3 col-sm-6 col-lg-3">
            <div class="info-box">
                <span class="info-box-icon bg-green">
                <i class="bi bi-cart icon"></i>
                </span>
                <div class="info-box-content">
                    <span class="text-bold text-uppercase">Todays Total Sales</span>
                    <span class="info-box-number">৳  0.00</span>
                </div>
            </div>
       </div>
       <div class="col-md-3 col-sm-6 col-lg-3">
            <div class="info-box">
                <span class="info-box-icon bg-red">
                <i class="bi bi-dash-square icon"></i>
                </span>
                <div class="info-box-content">
                    <span class="text-bold text-uppercase">Todays Total Expense</span>
                    <span class="info-box-number">৳  0.00</span>
                </div>
            </div>
       </div>
    </section>
    <section class="row">
       <div class="col-md-3 col-sm-6 col-lg-3">
            <div class="small-box bg-dream-pink">
               <div class="inner text-uppercase">
                    <h3>138</h3>
                    <p>Suppliers</p>
               </div>
               <div class="icon">
                <i class="bi bi-people-fill"></i>
               </div>
               <a href="#" class="small-box-footer text-uppercase">View
                <i class="bi bi-arrow-right-circle"></i>
               </a>
            </div>
       </div>
       <div class="col-md-3 col-sm-6 col-lg-3">
            <div class="small-box bg-dream-purple">
               <div class="inner text-uppercase">
                    <h3>18</h3>
                    <p>Group</p>
               </div>
               <div class="icon">
                <i class="bi bi-people-fill"></i>
               </div>
               <a href="#" class="small-box-footer text-uppercase">View
                <i class="bi bi-arrow-right-circle"></i>
               </a>
            </div>
       </div>
       <div class="col-md-3 col-sm-6 col-lg-3">
            <div class="small-box bg-dream-maroon">
               <div class="inner text-uppercase">
                    <h3>18</h3>
                    <p>Invoice</p>
               </div>
               <div class="icon">
                <i class="bi bi-receipt"></i>
               </div>
               <a href="#" class="small-box-footer text-uppercase">View
                <i class="bi bi-arrow-right-circle"></i>
               </a>
            </div>
       </div>
       <div class="col-md-3 col-sm-6 col-lg-3">
            <div class="small-box bg-dream-green">
               <div class="inner text-uppercase">
                    <h3>198</h3>
                    <p>Memu</p>
               </div>
               <div class="icon">
                <i class="bi bi-receipt"></i>
               </div>
               <a href="#" class="small-box-footer text-uppercase">View
                <i class="bi bi-arrow-right-circle"></i>
               </a>
            </div>
       </div>
       <div class="row">
            <div class="col-6">
                <div class="table-responsive">
                    @php
                    $todayCollection = \App\Models\Settings\ShopBalance::where('status', 0)->whereDate('new_due_date', now()->toDateString())->get();
                    @endphp
                    <h4 class="text-center bg-aqua text-white p-1">Today Due Collections</h3>
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Shop Name')}}</th>
                                <th scope="col">{{__('Owner Name')}}</th>
                                <th scope="col">{{__('Collection Taka')}}</th>
                                <th scope="col">{{__('Sales Date')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todayCollection as $data)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$data->shop?->shop_name}}</td>
                                <td>{{$data->shop?->owner_name}}</td>
                                <td>{{$data->balance_amount}}</td>
                                <td>{{$data->created_at->format('d F Y')}}</td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="5" class="text-center">No Data Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-6">
                <div class="table-responsive">
                    @php
                    $todayCheck = \App\Models\Sales\SalesPayment::where('cash_type', 0)->whereDate('check_date', now()->toDateString())->get();
                    @endphp
                    <h4 class="text-center bg-aqua text-white p-1">Today Check Collections</h3>
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Shop Name')}}</th>
                                <th scope="col">{{__('Owner Name')}}</th>
                                <th scope="col">{{__('Collection Taka')}}</th>
                                <th scope="col">{{__('Check Receive Date')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todayCheck as $c)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$c->shop?->shop_name}}</td>
                                <td>{{$c->shop?->owner_name}}</td>
                                <td>{{$c->amount}}</td>
                                <td>{{$c->created_at->format('d F Y')}}</td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="5" class="text-center">No Data Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
       </div>
    </section>
</div>
@endsection

@push('scripts')

<!-- Need: Apexcharts -->
<script src="{{ asset('/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('/assets/js/pages/dashboard.js') }}"></script>
@endpush
