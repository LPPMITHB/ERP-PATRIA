@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [   
        'title' => $menuTitle,
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$project->code => route('project.show', ['id' => $project->id]),
            'Select Work' => ''
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header">
                <div class="col-sm-6">
                    <table>
                        <thead>
                            <th colspan="2">Project Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->code}}</b></td>
                            </tr>
                            <tr>
                                <td>Ship</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->ship->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->customer->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Planned Start Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $project->planned_start_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Planned End Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $project->planned_end_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @verbatim
            <div id="wbs">
                <div class="box-body">
                    <h4 class="box-title">Work Breakdown Structures</h4>
                    <table id="wbs-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 17%">Name</th>
                                <th style="width: 17%">Description</th>
                                <th style="width: 15%">Deliverables</th>
                                <th style="width: 15%">Deadline</th>
                                <th style="width: 9%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in works" class="popoverData"  data-content="" v-on:mouseover="dataForTooltip(data)" data-trigger="hover" rel="popover" data-placement="auto top" data-original-title="Details">
                                <td class="p-l-10">{{ index + 1 }}</td>
                                <td class="tdEllipsis p-l-10">{{ data.name }}</td>
                                <td class="tdEllipsis p-l-10">{{ data.description }}</td>
                                <td class="p-l-10">{{ data.deliverables }}</td>
                                <td class="p-l-10">{{ data.planned_deadline }}</td>
                                <td class="textCenter">
                                    <a class="btn btn-primary btn-xs" :href="createActivityRoute(data)">
                                        SELECT
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endverbatim
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <div id="myPopoverContent" style="display : none;">
                
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

    var data = {
        works : @json($works),
        menu : @json($menu)
    };

    var vm = new Vue({
        el: '#wbs',
        data: data,
        methods:{
            createActivityRoute(data){
                var url = "";
                if(this.menu == "addAct"){
                    url = "/project/createActivities/"+data.id;
                }else if(this.menu == "mngNet"){
                    url = "/project/manageNetwork/"+data.id;
                }else if(this.menu == "viewAct"){
                    url = "/project/indexActivities/"+data.id;
                }
                return url;
            },
            dataForTooltip(data){
                var status = "";
                if(data.status == 1){
                    status = "Open";
                }else if(data.status == 0){
                    status = "Done";
                }

                var actual_deadline = "-";
                if(data.actual_deadline != null){
                    actual_deadline = data.actual_deadline;
                }
                
                var workParent = "-";
                if(data.work != null){
                    workParent = data.work.name;
                }

                var text = '<table class="tableFixed width100"><thead><th style="width:35%">Attribute</th><th style="width:5%"></th><th>Value</th></thead><tbody><tr><td>Code</td><td>:</td><td>'+data.code+
                '</td></tr><tr><td>Name</td><td>:</td><td>'+data.name+
                '</td></tr><tr><td class="valignTop">Description</td><td class="valignTop">:</td><td class="valignTop" style="overflow-wrap: break-word;">'+data.description+
                '</td></tr><tr><td class="valignTop">Deliverables</td><td class="valignTop">:</td><td class="valignTop" style="overflow-wrap: break-word;">'+data.deliverables+
                '</td></tr><tr><td>Status</td><td>:</td><td>'+status+
                '</td></tr><tr><td>Planned Deadline</td><td>:</td><td>'+data.planned_deadline+
                '</td></tr><tr><td>Actual Deadline</td><td>:</td><td>'+actual_deadline+
                '</td></tr><tr><td>Progress</td><td>:</td><td>'+data.progress+
                '%</td></tr><tr><td class="valignTop">Work Parent</td><td class="valignTop">:</td><td class="valignTop" style="overflow-wrap: break-word;">'+workParent+
                '</td></tr></tbody></table>'

                function handlerMouseOver(ev) {
                    $('.popoverData').popover({
                        html: true,
                    });
                    var target = $(ev.target);
                    var target = target.parent();
                    
                    if(target.attr('class')=="popoverData odd"||target.attr('class')=="popoverData even"){
                        $(target).attr('data-content',text);
                        $(target).popover('show');
                    }else{
                        $(target.parent()).popover('hide');
                    }
                }
                $(".popoverData").mouseover(handlerMouseOver);

                function handlerMouseOut(ev) {
                    var target = $(ev.target);
                    var target = target.parent(); 
                    if(target.attr('class')=="popoverData odd" || target.attr('class')=="popoverData even"){
                        $(target).attr('data-content',"");
                    }
                }
                $(".popoverData").mouseout(handlerMouseOut);
            }
        },
    });
</script>
@endpush
