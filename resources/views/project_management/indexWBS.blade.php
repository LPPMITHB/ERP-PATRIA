@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'View All WBS',
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$project->code => route('project.show',$project->id),
            'Select WBS' => ""
        ]
    ]
)
@endbreadcrumb
@endsection
@section('content')

<div id="myPopoverContent" style="display : none;">
                
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header">
                <div class="col-xs-12 col-lg-4 col-md-12">    
                    <div class="box-body">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Code</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->code}}</b></div>
                        
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
            <div id="add_wbs">
                <div class="box-body">
                    <h4 class="box-title">Work Breakdown Structures</h4>
                    <table id="wbs-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="width: 5px">No</th>
                                <th style="width: 18%">Name</th>
                                <th style="width: 30%">Description</th>
                                <th style="width: 18%">Deliverables</th>
                                <th style="width: 85px">Deadline</th>
                                <th style="width: 85px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in works">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.deliverables)">{{ data.deliverables }}</td>
                                <td>{{ data.planned_deadline }}</td>
                                <td class="p-l-0 textCenter">
                                    <a class="btn btn-primary btn-xs" :href="createRouteView(data.id)">
                                        VIEW
                                    </a>
                                    <a class="btn btn-primary btn-xs mobile_button_view" @click="openEditModal(data)" data-toggle="modal" href="#edit_wbs">
                                        EDIT
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal fade" id="edit_wbs">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit Work Breakdown Structures <b id="wbs_code"></b></h4>
                                </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label for="name" class="control-label">Name</label>
                                                <input id="name" type="text" class="form-control" v-model="editWork.name" placeholder="Insert Name here..." >
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label for="description" class="control-label">Description</label>
                                                <textarea id="description" v-model="editWork.description" class="form-control" rows="2" placeholder="Insert Description here..."></textarea>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label for="deliverables" class="control-label">Deliverables</label>
                                                <textarea id="deliverables" v-model="editWork.deliverables" class="form-control" rows="2" placeholder="Insert Deliverables here..."></textarea>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label for="edit_planned_deadline" class="control-label">Deadline</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input v-model="editWork.planned_deadline" type="text" class="form-control datepicker" id="edit_planned_deadline" placeholder="Insert Deadline here...">                                                                                               
                                                </div>  
                                            </div>
                                        </div>  
                                    </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update">SAVE</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
            </div>
            @endverbatim
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
    $('div.overlay').hide();
});

var data = {
    works : "",
    newIndex : "",
    project_start_date : @json($project->planned_start_date),
    project_end_date : @json($project->planned_end_date),
    editWork : {
        work_id: "",
        name : "",
        description : "",
        deliverables : "",
        planned_deadline : "",
        project_id : @json($project->id),
    },
    parent_work_deadline : "",
};

Vue.directive('tooltip', function(el, binding){
    $(el).tooltip({
        title: binding.value,
        placement: binding.arg,
        trigger: 'hover'             
    })
})

var vm = new Vue({
    el: '#add_wbs',
    data: data,
    mounted() {
        $('.datepicker').datepicker({
            autoclose : true,
        });
        $("#edit_planned_deadline").datepicker().on(
            "changeDate", () => {
                this.editWork.planned_deadline = $('#edit_planned_deadline').val();
            }
        );
    },
    computed:{
        updateOk: function(){
            let isOk = false;
                if(this.editWork.name == ""
                || this.editWork.description == ""
                || this.editWork.deliverables == ""
                || this.editWork.planned_deadline == "")
                {
                    isOk = true;
                }
            return isOk;
        },

    }, 
    methods:{
        tooltipText: function(text) {
            return text
        },       
        createRouteView(data){
            return "/project/showWBS/"+data;
        },
        openEditModal(data){
            document.getElementById("wbs_code").innerHTML= data.code;
            this.editWork.work_id = data.id;
            this.editWork.name = data.name;
            this.editWork.description = data.description;
            this.editWork.deliverables = data.deliverables;
            this.editWork.planned_deadline = data.planned_deadline;
            this.parent_work_deadline = "";
            this.works.forEach(work => {
                if(work.id == data.work_id){
                    this.parent_work_deadline = work.planned_deadline;
                }
            });
            $('#edit_planned_deadline').datepicker('setDate', new Date(data.planned_deadline));
        },
        
        getWorks(){
            window.axios.get('/project/getAllWorks/'+this.editWork.project_id).then(({ data }) => {
                this.works = data;
                var dT = $('#wbs-table').DataTable();
                dT.destroy();
                this.$nextTick(function() {
                    $('#wbs-table').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : false,
                        'ordering'    : false,
                        'info'        : true,
                        'autoWidth'   : false,
                    });
                })
            });
        },
        update(){            
            var editWork = this.editWork;
            var url = "/project/updateWBS/"+editWork.work_id;
            editWork = JSON.stringify(editWork);
            $('div.overlay').show();            
            window.axios.patch(url,editWork)
            .then((response) => {
                if(response.data.error != undefined){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: response.data.error,
                        position: 'topRight',
                    });
                    $('div.overlay').hide();            
                }else{
                    iziToast.success({
                        displayMode: 'replace',
                        title: response.data.response,
                        position: 'topRight',
                    });
                    $('div.overlay').hide();            
                }
                
                this.getWorks();   
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();            
            })         
        },
    },
    watch : {
        'editWork.planned_deadline': function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();
            
            var deadline = new Date(newValue);
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);
            if(this.parent_work_deadline != ""){
                var parent_work_deadline = new Date(this.parent_work_deadline).toDateString();
                var parent_work_deadline = new Date(parent_work_deadline);
                if(deadline > parent_work_deadline){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: "Your deadline is after parent work deadline",
                        position: 'topRight',
                    });
                }
            }else if(deadline < pro_planned_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "Your deadline is behind project start date",
                    position: 'topRight',
                });
            }else if(deadline > pro_planned_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "Your deadline is after project end date",
                    position: 'topRight',
                });
            }
        },
    },
    created: function() {
        this.getWorks();
    },
    
});


</script>
@endpush