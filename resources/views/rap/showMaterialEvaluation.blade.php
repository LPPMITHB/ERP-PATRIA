@extends('layouts.main')

@section('content-header')
@if($route == "/rap")
    @breadcrumb(
        [
            'title' => 'View Remaining Material',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('rap.selectProjectViewRM'),
                'Select WBS' => route('rap.selectWBS',$project->id),
                'Show Remaining Material' => ""
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/rap_repair")
    @breadcrumb(
        [
            'title' => 'View Remaining Material',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('rap_repair.selectProjectViewRM'),
                'Select WBS' => route('rap_repair.selectWBS',$project->id),
                'Show Remaining Material' => ""
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header no-padding p-t-10">
                <div class="col-xs-12 col-md-4">
                    <div class="col-sm-12 no-padding"><b>Project Information</b></div>

                    <div class="col-xs-4 no-padding">Project Code</div>
                    <div class="col-xs-8 no-padding"><b>: {{$project->number}}</b></div>

                    <div class="col-xs-4 no-padding">Ship Type</div>
                    <div class="col-xs-8 no-padding"><b>: {{$project->ship->type}}</b></div>

                    <div class="col-xs-4 no-padding">Customer</div>
                    <div class="col-xs-8 no-padding"><b>: {{$project->customer->name}}</b></div>

                    <div class="col-xs-4 no-padding">Progress</div>
                    <div class="col-xs-8 no-padding"><b>: {{$project->progress}}%</b></div>

                    <div class="col-xs-4 no-padding">Current Date</div>
                    <div class="col-xs-8 no-padding"><b>: {{date("d-m-Y")}}</b></div>
                </div>

                <div class="col-xs-12 col-md-4">
                    <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                
                    <div class="col-xs-4 no-padding">Code</div>
                    <div class="col-xs-8 no-padding"><b>: {{$wbs->code}}</b></div>
                    
                    <div class="col-xs-4 no-padding">Name</div>
                    <div class="col-xs-8 no-padding"><b>: {{$wbs->number}}</b></div>

                    <div class="col-xs-4 no-padding">Description</div>
                    <div class="col-xs-8 no-padding"><b>: {{$wbs->description}}</b></div>

                    <div class="col-xs-4 no-padding">Deliverable</div>
                    <div class="col-xs-8 no-padding"><b>: {{$wbs->deliverables}}</b></div>

                    <div class="col-xs-4 no-padding">Progress</div>
                    <div class="col-xs-8 no-padding"><b>: {{$wbs->progress}}%</b></div>
                </div>
            </div>
            <div class="box-body p-t-0">
                <table class="table table-bordered showTable tablePagingVue tableFixed">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Material Number</th>
                            <th width="25%">Material Description</th>
                            <th width="5%">Unit</th>
                            <th width="15%">Quantity</th>
                            <th width="15%">Used</th>
                            <th width="15%">Remaining</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach ($materialEvaluation as $data)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{$data['material_code']}}</td>
                                <td>{{$data['material_description']}}</td>
                                <td>{{$data['unit']}}</td>
                                <td>{{number_format($data['quantity'])}}</td>
                                <td>{{number_format($data['used'])}}</td>
                                <td>{{number_format($data['quantity'] - $data['used'])}}</td>
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
        $('.tablePagingVue thead tr').clone(true).appendTo( '.tablePagingVue thead' );
        $('.tablePagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'Material Name'){
                $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
            }else{
                $(this).html( '<input disabled class="form-control width100" type="text"/>' );
            }

            $( 'input', this ).on( 'keyup change', function () {
                if ( tablePagingVue.column(i).search() !== this.value ) {
                    tablePagingVue
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            });
        });

        var tablePagingVue = $('.tablePagingVue').DataTable( {
            orderCellsTop   : true,
            paging          : true,
            autoWidth       : false,
            lengthChange    : false,
            info            : false,
        });
        $('div.overlay').hide();
    });
    
</script>
@endpush