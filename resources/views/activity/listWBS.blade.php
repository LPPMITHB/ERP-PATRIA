@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [   
        'title' => $menuTitle,
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$project->number => route('project.show', ['id' => $project->id]),
            'Select WBS' => ''
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
                <div class="col-xs-12 col-lg-4 col-md-12">    
                    <div class="box-body">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Code</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->number}}</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Ship</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->ship->name}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Customer</div>
                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->name}}"><b>: {{$project->customer->name}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Start Date</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $project->planned_start_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>

                        <div class="col-md-4 col-xs-4 no-padding">End Date</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $project->planned_end_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>
                    </div>
                </div>
            </div>
            @verbatim
            <div id="wbs">
                <div class="box-body">
                    <h4 class="box-title">Work Breakdown Structures</h4>
                    <table id="wbs-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="width: 15px">No</th>
                                <th style="width: 20%">Name</th>
                                <th style="width: 30%">Description</th>
                                <th style="width: 20%">Deliverables</th>
                                <th style="width: 85px">Deadline</th>
                                <th style="width: 85px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in wbs">
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
                $('div.overlay').hide();
            }
        });
        jQuery('#wbs-table').wrap('<div class="dataTables_scroll" />');
    });

    var data = {
        wbs : @json($wbs),
        menu : @json($menu)
    };

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var vm = new Vue({
        el: '#wbs',
        data: data,
        methods:{
            tooltipText: function(text) {
                return text
            },
            createActivityRoute(data){
                var url = "";
                if(this.menu == "addAct"){
                    url = "/activity/create/"+data.id;
                }else if(this.menu == "mngNet"){
                    url = "/activity/manageNetwork/"+data.id;
                }else if(this.menu == "viewAct"){
                    url = "/activity/index/"+data.id;
                }else if(this.menu == "confirmAct"){
                    var url = "/activity/confirmActivity/"+data.id;
                }
                return url;
            },
        },
    });
</script>
@endpush
