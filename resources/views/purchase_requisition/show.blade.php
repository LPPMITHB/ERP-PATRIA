@extends('layouts.main')

@section('content-header')
@if($modelPR->type == 1)
    @php($type = 'Material')
@else
    @php($type = 'Resource')
@endif
@if($route == "/purchase_requisition")
    @breadcrumb(
        [
            'title' => 'View Purchase Requisition - '.$type,
            'items' => [
                'Dashboard' => route('index'),
                'View All Purchase Requisition' => route('purchase_requisition.index'),
                'View Purchase Requisition' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/purchase_requisition_repair")
    @breadcrumb(
        [
            'title' => 'View Purchase Requisition - '.$type,
            'items' => [
                'Dashboard' => route('index'),
                'View All Purchase Requisition' => route('purchase_requisition_repair.index'),
                'View Purchase Requisition' => '',
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-blue">
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">PR Number</span>
                            <span class="info-box-number">{{ $modelPR->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-xs-4 col-md-4">
                            Status
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b>{{ $status }}</b>
                        </div>

                        <div class="col-xs-4 col-md-4">
                            Created By
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b> {{ $modelPR->user->name }} </b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Created At
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b> {{ $modelPR->created_at->format('d-m-Y H:i:s') }} </b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Description
                        </div>
                        <div class="col-xs-8 col-md-8 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelPR->description}}">
                            : <b> {{ ($modelPR->description != "") ? $modelPR->description : '-' }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10 m-l-10">
                    @if ($approval_type == "Single Approval")
                        @if($modelPR->status != 6 && $modelPR->status != 1 && $modelPR->status != 8)
                            @if($modelPR->status == 2 || $modelPR->status == 0 || $modelPR->status == 7)
                                <div class="col-xs-5 col-md-5">
                                    Approved By
                                </div>
                            @elseif($modelPR->status == 3 || $modelPR->status == 5)
                                <div class="col-xs-5 col-md-5">
                                    Checked By
                                </div>
                            @elseif($modelPR->status == 5)
                                <div class="col-xs-5 col-md-5">
                                    Rejected By
                                </div>
                            @endif
                            <div class="col-xs-7 col-md-7 tdEllipsis">
                                : <b> {{ $modelPR->approvedBy1->name }} </b>
                            </div>
                        @endif

                        <?php
                            $approval_date_1 = "";
                            if($modelPR->approval_date_1 != NULL){
                                $approval_date_1 = DateTime::createFromFormat('Y-m-d', $modelPR->approval_date_1);
                                $approval_date_1 = $approval_date_1->format('d-m-Y');
                            }
                        ?>

                        @if($modelPR->status == 2 || $modelPR->status == 0 || $modelPR->status == 7)
                            <div class="col-xs-5 col-md-5">
                                Approved Date
                            </div>
                            <div class="col-xs-7 col-md-7">
                                : <b>{{ $approval_date_1 }}</b>
                            </div>
                        @elseif($modelPR->status == 5)
                            <div class="col-xs-5 col-md-5">
                                Rejected Date
                            </div>
                            <div class="col-xs-7 col-md-7">
                                : <b>{{ $approval_date_1 }}</b>
                            </div>
                        @endif
                    @elseif($approval_type == "Two Step Approval" || $approval_type = "Joint Approval")
                        @if($modelPR->status != 6 && $modelPR->status != 1 && $modelPR->status != 8 && $modelPR->status != 9)
                            @if($modelPR->status == 2 || $modelPR->status == 0 || $modelPR->status == 7 )
                                <div class="col-xs-5 col-md-5">
                                    Approved By
                                </div>
                            @elseif($modelPR->status == 3 || $modelPR->status == 5)
                                <div class="col-xs-5 col-md-5">
                                    Checked By
                                </div>
                            @elseif($modelPR->status == 5)
                                <div class="col-xs-5 col-md-5">
                                    Rejected By
                                </div>
                            @endif
                            <div class="col-xs-7 col-md-7 tdEllipsis">
                                : <b> {{ $modelPR->approvedBy1 != null ? $modelPR->approvedBy1->name : "-"}} </b>
                            </div>
                        @endif

                        <?php
                            $approval_date_1 = "";
                            if($modelPR->approval_date_1 != NULL){
                                $approval_date_1 = DateTime::createFromFormat('Y-m-d', $modelPR->approval_date_1);
                                $approval_date_1 = $approval_date_1->format('d-m-Y');
                            }
                        ?>

                        @if($modelPR->status == 2 || $modelPR->status == 0 || $modelPR->status == 7 )
                            <div class="col-xs-5 col-md-5">
                                Approved Date
                            </div>
                            <div class="col-xs-7 col-md-7">
                                : <b>{{ $approval_date_1 }}</b>
                            </div>
                        @elseif($modelPR->status == 3 || $modelPR->status == 5)
                            <div class="col-xs-5 col-md-5">
                                Checked Date
                            </div>
                            <div class="col-xs-7 col-md-7">
                                : <b>{{ $approval_date_1 }}</b>
                            </div>
                        @elseif($modelPR->status == 5)
                            <div class="col-xs-5 col-md-5">
                                Rejected Date
                            </div>
                            <div class="col-xs-7 col-md-7">
                                : <b>{{ $approval_date_1 }}</b>
                            </div>
                        @endif

                        @if($modelPR->approvedBy2 != null)
                            @if($modelPR->status != 6 && $modelPR->status != 1 && $modelPR->status != 8)
                                @if($modelPR->status == 2 || $modelPR->status == 0 || $modelPR->status == 7 || $modelPR->status == 9)
                                    <div class="col-xs-5 col-md-5">
                                        Approved By
                                    </div>
                                @elseif($modelPR->status == 3 || $modelPR->status == 5)
                                    <div class="col-xs-5 col-md-5">
                                        Checked By
                                    </div>
                                @elseif($modelPR->status == 5)
                                    <div class="col-xs-5 col-md-5">
                                        Rejected By
                                    </div>
                                @endif
                                <div class="col-xs-7 col-md-7 tdEllipsis">
                                    : <b> {{ $modelPR->approvedBy2->name }} </b>
                                </div>
                            @endif

                            <?php
                                $approval_date_2 = "";
                                if($modelPR->approval_date_2 != NULL){
                                    $approval_date_2 = DateTime::createFromFormat('Y-m-d', $modelPR->approval_date_2);
                                    $approval_date_2 = $approval_date_2->format('d-m-Y');
                                }
                            ?>

                            @if($modelPR->status == 2 || $modelPR->status == 0 || $modelPR->status == 7 || $modelPR->status == 9)
                                <div class="col-xs-5 col-md-5">
                                    Approved Date
                                </div>
                                <div class="col-xs-7 col-md-7">
                                    : <b>{{ $approval_date_2 }}</b>
                                </div>
                            @elseif($modelPR->status == 5)
                                <div class="col-xs-5 col-md-5">
                                    Rejected Date
                                </div>
                                <div class="col-xs-7 col-md-7">
                                    : <b>{{ $approval_date_2 }}</b>
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
                
            </div>
            <div class="box-body p-t-0 p-b-0">
                @if($modelPR->type != 3)
                    <table class="table table-bordered tableFixed showTable" id="pr-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                @if($modelPR->type == 1)
                                    <th width="20%">Material Number</th>
                                    <th width="25%">Material Description</th>
                                @else
                                    <th width="20%">Resource Number</th>
                                    <th width="25%">Resource Description</th>
                                @endif
                                <th width="8%">Request Quantity</th>
                                <th width="7%">Unit</th>
                                <th width="14%">Project Number</th>
                                <th width="13%">Required Date</th>
                                <th width="10%">Allocation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modelPR->PurchaseRequisitionDetails as $PRD)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @if($modelPR->type == 1)
                                        <td class="tdEllipsis">{{ $PRD->material->code }}</td>
                                        <td class="tdEllipsis">{{ $PRD->material->description }}</td>
                                    @else
                                        <td class="tdEllipsis">{{ $PRD->resource->code }}</td>
                                        <td class="tdEllipsis">{{ $PRD->resource->name }}</td>
                                    @endif
                                    <td>{{ number_format($PRD->quantity,2) }}</td>
                                    @if($modelPR->type == 1)
                                        <td>{{ $PRD->material->uom->unit}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    <td class="tdEllipsis">{{ isset($PRD->project) ? $PRD->project->number : '-' }}</td>
                                    <td>{{ isset($PRD->required_date) ? date('d-m-Y', strtotime($PRD->required_date)) : '-' }}</td>
                                    <td>{{ isset($PRD->alocation) ? $PRD->alocation : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif($modelPR->type == 3)
                    <table class="table table-bordered tableFixed showTable" id="pr-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Project Number</th>
                                <th width="25%">WBS</th>
                                <th width="40%">Job Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modelPR->PurchaseRequisitionDetails as $PRD)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $PRD->project->number}}</td>
                                    <td>{{ $PRD->wbs->number}} - {{ $PRD->wbs->description}}</td>
                                    <td>{{ $PRD->job_order}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                    @if($route == "/purchase_requisition")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" target="_blank" href="{{ route('purchase_requisition.print', ['id'=>$modelPR->id]) }}">DOWNLOAD</a>
                        @can('cancel-approval-purchase-requisition')
                            @if($po)
                                <a class="col-xs-12 col-md-2 btn btn-danger pull-right m-r-5" onclick="cancelApproval('{{$route}}')">CANCEL APPROVAL</a>
                            @endif
                        @endcan
                    @elseif($route == "/purchase_requisition_repair")
                        <a class="col-xs-12 col-md-2 btn btn-primary pull-right" target="_blank" href="{{ route('purchase_requisition_repair.print', ['id'=>$modelPR->id]) }}">DOWNLOAD</a>
                        @can('cancel-approval-purchase-requisition-repair')
                            @if($po)
                                <a class="col-xs-12 col-md-2 btn btn-danger pull-right m-r-5" onclick="cancelApproval('{{$route}}')">CANCEL APPROVAL</a>
                            @endif
                        @endcan
                    @endif

                    @if($modelPR->status == 1 || $modelPR->status == 3 || $modelPR->status == 4)
                        <a class="col-xs-12 col-md-2 btn btn-danger pull-right m-r-5" onclick="cancel('{{$route}}')">CANCEL</a>
                    @endif
                </div>
            </div> <!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('#pr-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }

        });
    });

    function cancel(route){
        iziToast.question({
            close: false,
            overlay: true,
            timeout : 0,
            displayMode: 'once',
            id: 'question',
            zindex: 9999,
            title: 'Confirm',
            message: 'Are you sure you want to cancel this document?',
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
                    var url = "";
                    if(route == "/purchase_requisition"){
                        window.location.href = "{{ route('purchase_requisition.cancel', ['id'=>$modelPR->id]) }}";
                    }else{
                        window.location.href = "{{ route('purchase_requisition_repair.cancel', ['id'=>$modelPR->id]) }}";
                    }

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                }, true],
                ['<button>NO</button>', function (instance, toast) {

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                }],
            ],
        });
    }

    function cancelApproval(route){
        iziToast.question({
            close: false,
            overlay: true,
            timeout : 0,
            displayMode: 'once',
            id: 'question',
            zindex: 9999,
            title: 'Confirm',
            message: 'Are you sure you want to cancel this approval?',
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
                    var url = "";
                    if(route == "/purchase_requisition"){
                        window.location.href = "{{ route('purchase_requisition.cancelApproval', ['id'=>$modelPR->id]) }}";
                    }else{
                        window.location.href = "{{ route('purchase_requisition_repair.cancelApproval', ['id'=>$modelPR->id]) }}";
                    }

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                }, true],
                ['<button>NO</button>', function (instance, toast) {

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                }],
            ],
        });
    }
</script>
@endpush
