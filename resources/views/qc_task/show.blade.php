@extends('layouts.main')

@section('content-header')
@breadcrumb([
    'title' => 'Show Quality Control Task',
    'items' => [
        'Dashboard' => route('index'),
        'Show All Quality Control Task' => route('qc_task.index',$wbs->project_id),
        $qcTask->name => route('qc_type.show',$qcTask->id),
    ]
])
@endbreadcrumb
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">

        <div class="box">
            <div class="box-body">
                <div class="box-tools pull-right">
                    <a href="{{ route('qc_task.edit',['id'=>$qcTask->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-4 col-md-12">    
                        <div class="col-sm-12 no-padding"><b>Quality Control Task Information</b></div>
                        
                        <div class="col-md-3 col-xs-4 no-padding">Description</div>
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$qcTask->description}}"><b>: {{$qcTask->description}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Status</div>
                        @if ($qcTask->status == 1)
                            <div class="col-md-7 col-xs-8 no-padding tdEllipsis"><b>: NOT DONE</b></div>
                        @elseif($qcTask->status == 0)
                            <div class="col-md-7 col-xs-8 no-padding tdEllipsis"><b>: DONE</b></div>
                        @endif

                        <div class="col-md-3 col-xs-4 no-padding">Start Date</div>
                        @php
                        $date = DateTime::createFromFormat('Y-m-d', $qcTask->start_date);
                        $date = $date->format('d-m-Y');
                        @endphp
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$date}}"><b>: {{$date}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">End Date</div>
                        @php
                        $date = DateTime::createFromFormat('Y-m-d', $qcTask->end_date);
                        $date = $date->format('d-m-Y');
                        @endphp
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$date}}"><b>: {{$date}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">External Join</div>
                        @if ($qcTask->external_join == 1)
                            <div class="col-md-7 col-xs-8 no-padding tdEllipsis"><b>: Yes</b></div>
                        @elseif($qcTask->external_join == 0)
                            <div class="col-md-7 col-xs-8 no-padding tdEllipsis"><b>: No</b></div>
                        @endif
                    </div>

                    <div class="col-xs-12 col-lg-4 col-md-12">    
                        <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                        
                        <div class="col-md-3 col-xs-4 no-padding">Number</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$wbs->number}}</b></div>
                        
                        <div class="col-md-3 col-xs-4 no-padding">Description</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$wbs->description}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Deliverable</div>
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$wbs->deliverables}}"><b>: {{$wbs->deliverables}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Start Date</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: @php
                                if($wbs->planned_start_date != null){
                                    $date = DateTime::createFromFormat('Y-m-d', $wbs->planned_start_date);
                                    $date = $date->format('d-m-Y');
                                    echo $date;
                                }else{
                                    echo "-";
                                }
                            @endphp
                            </b>
                        </div>

                        <div class="col-md-3 col-xs-4 no-padding">End Date</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: @php
                                if($wbs->planned_end_date != null){
                                    $date = DateTime::createFromFormat('Y-m-d', $wbs->planned_end_date);
                                    $date = $date->format('d-m-Y');
                                    echo $date;
                                }else{
                                    echo "-";
                                }
                            @endphp
                            </b>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="box-body">
                @verbatim
                <div id="index_qcTaskDetail" class="tab-pane active" id="general_info">
                    <table id="qctd-table" class="table table-bordered showTable">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 35%">Name</th>
                                <th style="width: 45%">Description</th>
                                <th style="width: 15%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in qcTaskDetail">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.name }}</td>
                                <td class="tdEllipsis">{{ data.description }}</td>
                                <td class="tdEllipsis" v-if="data.status == null">NOT DONE</td>
                                <td class="tdEllipsis" v-else>{{data.status}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endverbatim
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();
    });
    var data = {
        qcTaskDetail: @json($qcTask->qualityControlTaskDetails),
    };
    var vm = new Vue({
        el: '#index_qcTaskDetail',
        data: data,
        methods: {
            createRouteEdit(id) {
                var url = "/qc_task/" + id + "/edit";
                return url;
            }
        }
    });
    $(document).ready(function() {
        $('#qctd-table').DataTable({
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
    });
</script>
@endpush