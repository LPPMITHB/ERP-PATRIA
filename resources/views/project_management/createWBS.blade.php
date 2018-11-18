@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Add Work Breakdown Structures',
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$project->code => route('project.show',$project->id),
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
                                <td>Start Date</td>
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
                                <td>End Date</td>
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
            <div id="add_wbs">
                <div class="box-body">
                    <h4 class="box-title">Work Breakdown Structures</h4>
                    <table id="wbs-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
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
                            <tr v-for="(data,index) in works" class="popoverData"  data-content="" v-on:mouseover="dataForTooltip(data)" data-trigger="hover" rel="popover" data-placement="auto top" data-original-title="Details">
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
                                <td class="p-l-0 textLeft">
                                    <selectize class="p-t-5" id="material" v-model="newWork.name" :settings="nameSettings">
                                        <option v-for="(structure, index) in structures" :value="structure.name">{{ structure.name }}</option>
                                    </selectize>
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
    works : "",
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
    editWork : {
        work_id: "",
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
                this.editWork.planned_deadline = $('#edit_planned_deadline').val();
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
        openEditModal(data){
            document.getElementById("wbs_code").innerHTML= data.code;
            this.editWork.work_id = data.id;
            this.editWork.name = data.name;
            this.editWork.description = data.description;
            this.editWork.deliverables = data.deliverables;
            this.editWork.planned_deadline = data.planned_deadline;
            $('#edit_planned_deadline').datepicker('setDate', new Date(data.planned_deadline));
        },
        createSubWBS(data){
            var url = "/project/createSubWBS/"+this.newWork.project_id+"/"+data.id;
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

            var text = '<table class="tableFixed width100"><thead><th style="width:35%">Attribute</th><th style="width:5%"></th><th>Value</th></thead><tbody><tr><td>Code</td><td>:</td><td>'+data.code+
            '</td></tr><tr><td class="valignTop">Name</td><td class="valignTop">:</td><td class="valignTop" style="overflow-wrap: break-word;">'+data.name+
            '</td></tr><tr><td class="valignTop">Description</td><td class="valignTop">:</td><td class="valignTop" style="overflow-wrap: break-word;">'+data.description+
            '</td></tr><tr><td class="valignTop">Deliverables</td><td class="valignTop">:</td><td class="valignTop" style="overflow-wrap: break-word;">'+data.deliverables+
            '</td></tr><tr><td>Status</td><td>:</td><td>'+status+
            '</td></tr><tr><td>Planned Deadline</td><td>:</td><td>'+data.planned_deadline+
            '</td></tr><tr><td>Actual Deadline</td><td>:</td><td>'+actual_deadline+
            '</td></tr><tr><td>Progress</td><td>:</td><td>'+data.progress+'%</td></tr></tbody></table>'
            
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

            
        },
        getWorks(){
            window.axios.get('/project/getWorks/'+this.newWork.project_id).then(({ data }) => {
                this.works = data;
                this.newIndex = Object.keys(this.works).length+1;

                $('#wbs-table').DataTable().destroy();
                this.$nextTick(function() {
                    $('#wbs-table').DataTable({
                        'paging'      : true,
                        'lengthChange': false,
                        'searching'   : false,
                        'ordering'    : false,
                        'info'        : true,
                        'autoWidth'   : false,
                        columnDefs : [
                            { targets: 0, sortable: false},
                        ]
                    });
                })
            });
        },
        add(){            
            var newWork = this.newWork;
            newWork = JSON.stringify(newWork);
            var url = "{{ route('project.storeWBS') }}";
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
                
                this.getWorks();
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

        }
    },
    watch : {
        // 'editWork.process_cost_string': function(newValue) {
        //     var string_newValue = newValue+"";
        //     this.editWork.process_cost = newValue;
        //     process_cost_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     Vue.nextTick(() => this.editWork.process_cost_string = process_cost_string);
        // },
        // 'editWork.other_cost_string': function(newValue) {
        //     var string_newValue = newValue+"";
        //     this.editWork.other_cost = newValue;
        //     other_cost_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     Vue.nextTick(() => this.editWork.other_cost_string = other_cost_string);
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
                    title: "this work deadline is behind project start date",
                    position: 'topRight',
                });
            }else if(deadline > pro_planned_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "this work deadline is after project end date",
                    position: 'topRight',
                });
            }
        },
        'editWork.planned_deadline': function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();
            
            var deadline = new Date(newValue);
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);
            if(deadline < pro_planned_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "this work deadline is behind project start date",
                    position: 'topRight',
                });
            }else if(deadline > pro_planned_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "this work deadline is after project end date",
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