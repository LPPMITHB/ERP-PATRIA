@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [   
        'title' => 'Prod. Order Actual Cost Report » '.$modelProject->name.' » Select Prod. Order',
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('production_order.selectProjectReport'),
            'Select Prod. Order' => ''
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="col-md-12 col-lg-4 col-xs-12 p-l-0">
                    <div class="box-body no-padding">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
                            <div class="col-md-4 col-xs-4 no-padding">Code</div>
                                <div class="col-md-8 col-xs-8 no-padding"><b>: {{$modelProject->number}}</b></div>
                            <div class="col-md-4 col-xs-4 no-padding">Ship</div>
                                <div class="col-md-8 col-xs-8 no-padding"><b>: {{$modelProject->ship->type}}</b></div>
                            <div class="col-md-4 col-xs-4 no-padding">Customer</div>
                                <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelProject->customer->name}}"><b>: {{$modelProject->customer->name}}</b></div>
                            <div class="col-md-4 col-xs-4 no-padding">Start Date</div>
                                <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $modelProject->planned_start_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                                @endphp
                                </b>
                            </div>
                            <div class="col-md-4 col-xs-4 no-padding">End Date</div>
                                <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $modelProject->planned_end_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                                @endphp
                                </b>
                            </div>
                    </div>
                </div>
            </div>
            <div class="box-body p-t-0">
                <h4 class="box-title no-padding">Production Orders</h4>
                <table id="wbs-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 20%">Number</th>
                            <th style="width: 30%">WBS</th>
                            <th style="width: 20%">Created By</th>
                            <th style="width: 15%">Status</th>
                            <th style="width: 10%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelPrO as $pro)
                            <tr>
                                <td class="p-l-10">{{ $loop->iteration }}</td>
                                <td class="tdEllipsis p-l-10" data-container="body" data-toggle="tooltip" title= "{{ $pro->number }}">{{ $pro->number }}</td>
                                <td class="tdEllipsis p-l-10" data-container="body" data-toggle="tooltip" title= "{{ $pro->wbs->code }} - {{ $pro->wbs->name }}">{{ $pro->wbs->code }} - {{ $pro->wbs->name }}</td>
                                <td class="tdEllipsis p-l-10" data-container="body" data-toggle="tooltip" title= "{{ $pro->user->name }}">{{ $pro->user->name }}</td>
                                @if($pro->status == 1)
                                    <td class="p-l-10">{{ 'UNRELEASED' }}</td>
                                @endif
                                <td class="textCenter">
                                    <a class="btn btn-primary btn-xs" href="{{ route('production_order.report', ['id'=>$pro->id]) }}">
                                        SELECT
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('#wbs-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').remove();
            }
        });
    });
</script>
@endpush
