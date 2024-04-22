@extends('layout.app')
@section('pageTitle',trans('Check list'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    @php
                        $totalAmount = 0;   
                    @endphp
                    <table class="table table-bordered mb-0"><thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Shop Name')}}</th>
                                <th scope="col">{{__('Check Date')}}</th>
                                <th scope="col">{{__('Amount')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($data as $d)
                            <tr>
                            <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$d->shop?->shop_name}}</td>
                                <td>{{$d->check_date}}</td>
                                <td>{{$d->amount}}</td>
                                <td class="white-space-nowrap">
                                    {{-- <a href="{{route(currentUser().'.currency.edit',encryptor('encrypt',$p->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> --}}
                                <button class="btn p-0 m-0" type="button" style="background-color: none; border:none;"
                                    data-bs-toggle="modal" data-bs-target="#balance"
                                    data-check-id="{{$d->id}}"
                                    data-shop-name="{{$d->shop?->shop_name}}"
                                    data-shop-amount="{{$d->amount}}"
                                    {{-- data-check-update="{{route(currentUser().'.check_list_update',$d->id)}}" --}}
                                    <span class="text-danger"><i class="bi bi-currency-dollar" style="font-size:1rem; color:rgb(246, 50, 35);"></i></span>
                                </button>
                                </td>
                            </tr>
                            @php
                                $totalAmount += $d->amount;
                            @endphp
                            @empty
                            <tr>
                                <th colspan="5" class="text-center">No Data Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-center">Total</th>
                                <th>{{$totalAmount}}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal fade" id="balance" tabindex="-1" role="dialog"
                    aria-labelledby="balanceTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <form method="post" id="checkUpdate"  action="{{route(currentUser().'.check_list_update')}}">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header py-1">
                                    <h5 class="modal-title" id="batchTitle">Chech Status</h5>
                                    <button type="button" class="close text-danger" data-bs-dismiss="modal"  aria-label="Close">
                                        <i class="bi bi-x-lg" style="font-size: 1.5rem;"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <input type="hidden" id="check_id" name="checkId" value="">
                                        <tbody>
                                            <tr class="bg-light">
                                                <th>Shop Name</th>
                                                <td id="name"></td>
                                            </tr>
                                            <tr class="bg-light">
                                                <th>Amount</th>
                                                <td id="totalAmount"></td>
                                            </tr>
                                            <tr class="bg-light">
                                                <th>Status</th>
                                                <td>
                                                    <select class="form-select" name="check_type" required>
                                                        <option value="0">Select</option>
                                                        <option value="1">Bank</option>
                                                        <option value="2">Cash</option>
                                                        <option value="3">Due</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
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
    $(document).ready(function () {
        $('#balance').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var checkId = button.data('check-id');
            var shopName = button.data('shop-name');
            var shopAmount = button.data('shop-amount');
            // Set the values in the modal
            var modal = $(this);
            modal.find('#check_id').val(checkId);
            modal.find('#name').text(shopName);
            modal.find('#totalAmount').text(shopAmount);

            // var checkUpdate = modal.find('#checkUpdate');
            // var newHref = button.data('check-update');
            // checkUpdate.attr('action', newHref);
        });
    });
</script>
@endpush