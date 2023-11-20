@extends('layout.app')
@section('pageTitle',trans('Receive List'))
@section('pageSubTitle',trans('List'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                    <!-- table bordered -->
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 table-striped">
                            {{--  <a class="float-end" href="{{route(currentUser().'.docontroll.create')}}" style="font-size:1.7rem"><i class="bi bi-plus-square-fill"></i></a>  --}}
                            <thead>
                                <tr>
                                    <th scope="col">{{__('#SL')}}</th>
                                    <th scope="col">{{__('Chalan No')}}</th>
                                    <th scope="col">{{__('Stock Date')}}</th>
                                    <th class="white-space-nowrap">{{__('ACTION')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $p)
                                <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                    <td>{{$p->chalan_no}}</td>
                                    <td>{{$p->stock_date}}</td>
                                    <td class="white-space-nowrap">
                                        <a href="{{route(currentUser().'.showDoReceive'.$p?->chalan_no)}}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="7" class="text-center">No Data Found</th>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="my-3">
                        {{--  {!! $data->links()!!}  --}}
                    </div>
                </div>
            </div>
    </div>
</section>
@endsection
