@extends('layout.app')
@section('pageTitle',trans('Create Purchase'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                    <!-- table bordered -->
                    <div class="row p-2 mt-4">
                        <div class="col-lg-3">
                             <span><b>Do ID:</b> 122323</span>
                        </div>
                        <div class="col-lg-3">
                             <span><b>Supplier ID:</b> 122232</span>
                        </div>
                        <div class="col-lg-3">
                             <span><b>Quantity:</b> 500</span>
                        </div>
                        <div class="col-lg-3">
                            <span><b>Do Date:</b> 12-05-2023</span>
                        </div>
                        <hr>
                     
                        <div class="col-lg-3 mt-2">
                            <label for=""><b>Purchase Date</b></label>
                            <input type="date" class="form-control"  name="pur_date">
                        </div>
                        <div class="col-lg-3 mt-2">
                            <label for=""><b>Batch No</b></label>
                            <input type="text" class="form-control"  name="batch_no">
                        </div>
                        <div class="col-lg-3 mt-2">
                            <label for=""><b>Status</b></label>
                            <select class="form-select" name="" id="">
                                <option value="0">Pending</option>
                                <option value="1">Partial Received</option>
                                <option value="2">Finish</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2">{{__('#SL')}}</th>
                                    <th rowspan="2">{{__('Product')}}</th>
                                    <th rowspan="2">{{__('Werehouse')}}</th>
                                    <th rowspan="2">{{__('Group')}}</th>
                                    <th colspan="3">{{__('Quantity')}}</th>
                                    <th rowspan="2">{{__('Remark')}}</th>
                                </tr>
                                <tr class="text-center">
                                    <th>{{__('Req')}}</th>
                                    <th>{{__('Received')}}</th>
                                    <th>{{__('s/o')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                               <tr>
                                    <th>1</th>
                                    <td>Mango Drinks [111] Drinks</td>
                                    <td>
                                        <select class="form-select" name="" id="">
                                            <option value="0">select</option>
                                            <option value="1">werehouse1</option>
                                            <option value="2">werehouse2</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-select" name="" id="">
                                            <option value="0">select</option>
                                            <option value="1">group1</option>
                                            <option value="2">group2</option>
                                        </select>
                                    </td>
                                    <td>1200</td>
                                    <td><input class="form-control" type="number" name="" value=""></td>
                                    <td>1200</td>
                                    <td><input class="form-control" type="number" name="" value=""></td>
                               </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</section>
@endsection