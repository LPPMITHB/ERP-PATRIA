@extends('layouts.main')

@section('content-header')
@breadcrumb([
    'title' => 'View All Quality Control Task',
    'subtitle' => '',
    'items' => [
        'Dashboard' => route('index'),
        'View All Quality Control Task' => '',
    ]
])
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12 col-lg-4 col-md-12">
                    <div class="box-body">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
            
                        <div class="col-md-3 col-xs-4 no-padding">Code</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$project->number}}</b></div>
            
                        <div class="col-md-3 col-xs-4 no-padding">Ship</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$project->ship->type}}</b></div>
            
                        <div class="col-md-3 col-xs-4 no-padding">Customer</div>
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip"
                            title="{{$project->customer->name}}"><b>: {{$project->customer->name}}</b></div>
            
                        <div class="col-md-3 col-xs-4 no-padding">Start Date</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>:
                                @if($project->planned_start_date != null)
                                @php
                                $date = DateTime::createFromFormat('Y-m-d', $project->planned_start_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                                @endphp
                                @else
                                -
                                @endif
                            </b>
                        </div>
            
                        <div class="col-md-3 col-xs-4 no-padding">End Date</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>:
                                @if($project->planned_end_date != null)
                                @php
                                $date = DateTime::createFromFormat('Y-m-d', $project->planned_end_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                                @endphp
                                @else
                                -
                                @endif
                            </b>
                        </div>
                    </div>
                </div>
            </div>
            @verbatim
                <div id="summary_report">
                    <div class="box-body">
                        <table id="qctask-table" class="table table-bordered tableFixed">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="45%">Description</th>
                                    <th width="30%">WBS</th>
                                    <th width="10%">Status</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in model_qc_tasks">
                                    <td>{{ index+1 }}</td>
                                    <td>{{ data.description }}</td>
                                    <td>{{ data.wbs.number }} - {{ data.wbs.description }}</td>
                                    <td v-if="data.status == 1">NOT DONE</td>
                                    <td v-else-if="data.status == 0">DONE</td>
                                    <td class="text-center">
                                        <a @click.prevent="openDetailModal(data)" class="btn btn-primary btn-xs">DETAILS</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
        
                        <div class="modal fade" id="detail_modal">
                            <div class="modal-dialog modalFull">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Quality Control Task</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="quantity" class="control-label">Description</label>
                                                <p>{{detail_data.description}}</p>
                                            </div>
                        
                                            <div class="col-sm-12" >
                                                <label for="quantity" class="control-label">Quality Control Task Details</label>
                                                <table id="qc_task_detail_table" class="table table-bordered showTable" style="border-collapse:collapse; table-layout:fixed;">
                                                    <thead>
                                                        <tr>
                                                            <th class="p-l-5" style="width: 5%">No</th>
                                                            <th style="width: 25%">Name</th>
                                                            <th style="width: 30%">Description</th>
                                                            <th style="width: 10%">Status</th>
                                                            <th style="width: 30%">Notes</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(data,index) in detail_data.qc_task_detail">
                                                            <td>{{ index + 1 }}</td>
                                                            <td class="tdEllipsis">{{ data.name }}</td>
                                                            <td class="tdEllipsis">{{ data.description }}</td>
                                                            <td class="tdEllipsis" v-if="data.status == null">NOT DONE</td>
                                                            <td class="tdEllipsis" v-else>
                                                                <b v-if="data.status == 'OK'" class="text-success">
                                                                    {{data.status}}
                                                                </b>
                                                                <b v-if="data.status == 'NOT OK'" class="text-danger">
                                                                    {{data.status}}
                                                                </b>
                                                            </td>
                                                            <td class="tdEllipsis">{{data.notes}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>  
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.box-body -->
                </div>
            @endverbatim
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->

@endsection

@push('script')
<script>
    $('div.overlay').hide();

    $(document).ready(function() {
        $('#qctask-table').DataTable({
            'paging': true,
            'lengthChange': false,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'bFilter': true,
            'initComplete': function() {
                $('div.overlay').hide();
            }
        });

        $('#qc_task_detail_table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            },
            "columnDefs": [
                { "searchable": false, "targets": [3,4,0] },
                { "orderable": false, "targets": [3,4] }
            ]
        });
    });

    function loading() {
        $('div.overlay').show();
    }

    var data = {
        model_qc_tasks : @json($modelQcTasks),      
        detail_data : {
            name : "",
            description : "",
            status : "",
            notes : "",
            qc_task_detail : [],
        }  
    }

    var vm = new Vue({
        el : '#summary_report',
        data : data,
        mounted: function(){
        },
        computed : {
        },
        methods : {
            openDetailModal(data){
                this.detail_data.name = data.name;
                this.detail_data.description = data.description;
                this.detail_data.status = data.status;
                this.detail_data.notes = data.notes;
                this.detail_data.qc_task_detail = data.quality_control_task_details;

                $('#detail_modal').modal();
            },
        },
        watch : {
        },
        created : function(){ 
        },
    })
</script>
@endpush