@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Add Work Breakdown Structures',
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$project->number => route('project.show',$project->id),
            'Add WBS' => ""
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
                        
                        <div class="col-md-3 col-xs-4 no-padding">Code</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$project->number}}</b></div>
                        
                        <div class="col-md-3 col-xs-4 no-padding">Ship</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$project->ship->name}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Customer</div>
                        <div class="col-md-7 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->name}}"><b>: {{$project->customer->name}}</b></div>

                        <div class="col-md-3 col-xs-4 no-padding">Start Date</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $project->planned_start_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>

                        <div class="col-md-3 col-xs-4 no-padding">End Date</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: @php
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
                    <table id="wbs-table" class="table table-bordered" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 20%">Name</th>
                                <th style="width: 20%">Description</th>
                                <th style="width: 15%">Deliverables</th>
                                <th style="width: 11%">Deadline</th>
                                <th style="width: 12%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in wbs">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis">{{ data.name }}</td>
                                <td class="tdEllipsis">{{ data.description }}</td>
                                <td class="tdEllipsis">{{ data.deliverables }}</td>
                                <td>{{ data.planned_deadline }}</td>
                                <td class="p-l-0 textCenter">
                                    <a class="btn btn-primary btn-xs" :href="createSubWBS(data)">
                                        ADD WBS
                                    </a>
                                    <a class="btn btn-primary btn-xs" @click="openEditModal(data)" data-toggle="modal" href="#edit_wbs">
                                        EDIT
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="p-l-10">{{newIndex}}</td>
                                <td class="p-l-0">
                                    <input v-model="newWork.name" type="text" class="form-control width100" id="name" name="name" placeholder="Name">
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newWork.description" class="form-control width100" rows="2" name="description" placeholder="Description"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newWork.deliverables" class="form-control width100" rows="2" name="deliverables" placeholder="Deliverables"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <input v-model="newWork.planned_deadline" type="text" class="form-control datepicker width100" id="planned_deadline" name="planned_deadline" placeholder="Deadline">
                                </td>
                                <td>
                                    <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">SUBMIT</button>
                                </td>
                            </tr>
                        </tfoot>
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
                                            <input id="name" type="text" class="form-control" v-model="editWbs.name" placeholder="Insert Name here..." >
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="description" class="control-label">Description</label>
                                            <textarea id="description" v-model="editWbs.description" class="form-control" rows="2" placeholder="Insert Description here..."></textarea>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="deliverables" class="control-label">Deliverables</label>
                                            <textarea id="deliverables" v-model="editWbs.deliverables" class="form-control" rows="2" placeholder="Insert Deliverables here..."></textarea>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="edit_planned_deadline" class="control-label">Deadline</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                                </div>
                                                <input v-model="editWbs.planned_deadline" type="text" class="form-control datepicker" id="edit_planned_deadline" placeholder="Insert Deadline here...">                                                                                               
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
            <div id="myPopoverContent" style="display : none;">
                
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
    wbs : "",
    newIndex : "", 
    structures : @json($structures),
    project_start_date : @json($project->planned_start_date),
    project_end_date : @json($project->planned_end_date),
    newWork : {
        name : "",
        description : "",
        deliverables : "",
        planned_deadline : "",
        project_id : @json($project->id),
    },
    editWbs : {
        wbs_id: "",
        name : "",
        description : "",
        deliverables : "",
        planned_deadline : "",
        project_id : @json($project->id),
    },
    nameSettings: {
        placeholder: 'Name',
        create: function(input) {
            return {
                value: input,
                text: input
            }
        },
        plugins: ['dropdown_direction'],
        dropdownDirection : 'down',
    },
};

var vm = new Vue({
    el: '#add_wbs',
    data: data,
    mounted() {
        $('.datepicker').datepicker({
            autoclose : true,
        });
        $("#planned_deadline").datepicker().on(
            "changeDate", () => {
                this.newWork.planned_deadline = $('#planned_deadline').val();
            }
        );
        $("#edit_planned_deadline").datepicker().on(
            "changeDate", () => {
                this.editWbs.planned_deadline = $('#edit_planned_deadline').val();
            }
        );
    },
    computed:{
        createOk: function(){
            let isOk = false;
                if(this.newWork.name == ""
                || this.newWork.description == ""
                || this.newWork.deliverables == ""
                || this.newWork.planned_deadline == "")
                {
                    isOk = true;
                }
            return isOk;
        },
        updateOk: function(){
            let isOk = false;
                if(this.editWbs.name == ""
                || this.editWbs.description == ""
                || this.editWbs.deliverables == ""
                || this.editWbs.planned_deadline == "")
                {
                    isOk = true;
                }
            return isOk;
        },

    }, 
    methods:{
        openEditModal(data){
            document.getElementById("wbs_code").innerHTML= data.code;
            this.editWbs.wbs_id = data.id;
            this.editWbs.name = data.name;
            this.editWbs.description = data.description;
            this.editWbs.deliverables = data.deliverables;
            this.editWbs.planned_deadline = data.planned_deadline;
            $('#edit_planned_deadline').datepicker('setDate', new Date(data.planned_deadline));
        },
        createSubWBS(data){
            var url = "/wbs/createSubWBS/"+this.newWork.project_id+"/"+data.id;
            return url;
        },
        getWBS(){
            window.axios.get('/api/getWbs/'+this.newWork.project_id).then(({ data }) => {
                this.wbs = data;
                this.newIndex = Object.keys(this.wbs).length+1;

                $('#wbs-table').DataTable().destroy();
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
        add(){            
            var newWork = this.newWork;
            newWork = JSON.stringify(newWork);
            var url = "{{ route('wbs.store') }}";
            $('div.overlay').show();            
            window.axios.post(url,newWork)
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
                
                this.getWBS();
                this.newWork.name = "";
                this.newWork.description = "";
                this.newWork.deliverables = "";
                this.newWork.planned_deadline = "";                
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();            
            })

        },
        update(){            
            var editWbs = this.editWbs;            
            var url = "/wbs/update/"+editWbs.wbs_id;
            editWbs = JSON.stringify(editWbs);
            $('div.overlay').show();            
            window.axios.patch(url,editWbs)
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
                
                this.getWBS();   
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();            
            })

        }
    },
    watch : {
        // 'editWbs.process_cost_string': function(newValue) {
        //     var string_newValue = newValue+"";
        //     this.editWbs.process_cost = newValue;
        //     process_cost_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     Vue.nextTick(() => this.editWbs.process_cost_string = process_cost_string);
        // },
        // 'editWbs.other_cost_string': function(newValue) {
        //     var string_newValue = newValue+"";
        //     this.editWbs.other_cost = newValue;
        //     other_cost_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     Vue.nextTick(() => this.editWbs.other_cost_string = other_cost_string);
        // },
        'newWork.planned_deadline': function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();
            
            var deadline = new Date(newValue);
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);
            if(deadline < pro_planned_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "this WBS deadline is behind project start date",
                    position: 'topRight',
                });
            }else if(deadline > pro_planned_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "this WBS deadline is after project end date",
                    position: 'topRight',
                });
            }
        },
        'editWbs.planned_deadline': function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();
            
            var deadline = new Date(newValue);
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);
            if(deadline < pro_planned_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "this WBS deadline is behind project start date",
                    position: 'topRight',
                });
            }else if(deadline > pro_planned_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "this WBS deadline is after project end date",
                    position: 'topRight',
                });
            }
        },
    },
    created: function() {
        this.getWBS();
    },
    
});
</script>
@endpush