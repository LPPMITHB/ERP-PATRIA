@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Edit Work Breakdown Structures',
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$project->number => route('project.show',$project->id),
            'Edit WBS' => ""
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
                                <td>&ensp;<b>{{$project->number}}</b></td>
                            </tr>
                            <tr>
                                <td>Ship</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->ship->type}}</b></td>
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
                                <th style="width: 18%">Name</th>
                                <th style="width: 20%">Description</th>
                                <th style="width: 15%">Deliverables</th>
                                <th style="width: 10%">Deadline</th>
                                <th style="width: 15%"></th>
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
                                    <a class="btn btn-primary btn-xs" @click="openEditModal(data)" data-toggle="modal" href="#edit_wbs">
                                        EDIT
                                    </a>
                                    <a class="btn btn-primary btn-xs" @click="assignResource(data)" data-toggle="modal" href="#assign_resource">
                                        ASSIGN RESOURCE
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
                    <div class="modal fade" id="assign_resource">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Assign Resource for Work Breakdown Structures <b id="wbs_code"></b></h4>
                                </div>
                                <div class="modal-body">
                                    <label for="resource_category" class="control-label">Assigned Resources Category</label>
                                    <selectize id="resource_category" v-model="selected_resource_category" :settings="resourceCategoriesSettings">
                                        <option v-for="(resource_category, index) in resourceCategories" :value="resource_category.id">{{ resource_category.name }}</option>
                                    </selectize>

                                    <template v-if="selected_resource_category.length > 0">
                                        <br>
                                        <label for="resources" class="control-label">List Assigned Resources</label>
                                        <table id="resources" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">No</th>
                                                    <th style="width: 50%">Resource Name</th>
                                                    <th style="width: 30%">Quantity</th>
                                                    <th style="width: 15%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(resource,index) in dataResources">
                                                    <td>{{ index + 1 }}</td>
                                                    <td class="tdEllipsis">{{ resource.resource_code }} - {{ resource.resource_name }}</td>
                                                    <td class="tdEllipsis">{{ resource.quantity }}</td>
                                                    <td class="p-l-0 textCenter">
                                                        <a href="#" @click="removeRow(index)" class="btn btn-danger btn-xs">
                                                            DELETE
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="p-l-10">{{newIndex}}</td>
                                                    <td class="p-l-0 textLeft">
                                                        <selectize v-model="dataInput.resource_id" :settings="resourceSettings">
                                                            <option v-for="(resource, index) in resourcesSelectize" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                        </selectize>
                                                    </td>
                                                    <td class="p-l-0">
                                                        <input class="form-control" v-model="dataInput.quantity" placeholder="Please Input Quantity">
                                                    </td>
                                                    <td class="p-l-0 textCenter">
                                                        <button @click.prevent="addResource" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </template>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" :disabled="assignOk" data-dismiss="modal" @click.prevent="updateResource">SAVE</button>
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
    project_start_date : @json($project->planned_start_date),
    project_end_date : @json($project->planned_end_date),
    resourceCategories : @json($resourceCategories),
    selected_resource_category : "",
    editWork : {
        wbs_id: "",
        name : "",
        description : "",
        deliverables : "",
        planned_deadline : "",
        project_id : @json($project->id),
    },
    parent_work_deadline : "",
    resourceCategoriesSettings: {
        placeholder: 'Please pick Resource Categories..',
        maxItems : null,
        plugins: ['remove_button'],
    },
    resourceSettings : {
        placeholder: 'Please pick Resource..',
    },
    resourcesSelectize : [],
    dataResources : [],
    newIndex : "",
    dataInput : {
        resource_id :"",
        resource_code : "",
        resource_name : "",
        quantity : "",
        quantityInt : 0,
        category_id : "",
    },
};

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
        createOk: function(){
            let isOk = false;

            var string_newValue = this.dataInput.quantityInt+"";
            this.dataInput.quantityInt = parseInt(string_newValue.replace(/,/g , ''));

            if(this.dataInput.resource_id == "" || this.dataInput.quantityInt < 1 || this.dataInput.quantityInt == "" || isNaN(this.dataInput.quantityInt)){
                isOk = true;
            }

            return isOk;
        },
        assignOk: function(){
            let isOk = false;
                if(this.selected_resource_category.length < 1)
                {
                    isOk = true;
                }
            return isOk;
        },

    }, 
    methods:{
        openEditModal(data){
            document.getElementById("wbs_code").innerHTML= data.code;
            this.editWork.wbs_id = data.id;
            this.editWork.name = data.name;
            this.editWork.description = data.description;
            this.editWork.deliverables = data.deliverables;
            this.editWork.planned_deadline = data.planned_deadline;
            this.parent_work_deadline = "";
            this.works.forEach(work => {
                if(work.id == data.wbs_id){
                    this.parent_work_deadline = work.planned_deadline;
                }
            });
            $('#edit_planned_deadline').datepicker('setDate', new Date(data.planned_deadline));
        },
        assignResource(data){
            this.editWork.wbs_id = data.id;
            window.axios.get('/api/getAllResourcePM/'+data.id).then(({ data }) => {
                this.selected_resource_category = data[0].categories;
                if(data[0].resources.length > 0){
                    this.dataResources = data[0].resources;
                }else{
                    this.dataResources =  [];
                }
            });
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
                        columnDefs : [
                            { targets: 0, sortable: false},
                        ]
                    });
                })
            });
        },
        update(){            
            var editWork = this.editWork;
            var url = "/project/updateWBS/"+editWork.wbs_id;
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
        updateResource(){
            if(this.selected_resource_category.length > 0){
                if(this.dataResources.length > 0){
                    var data = {};
                    data['selected_resource_category']= this.selected_resource_category;
                    data['dataResources']  = this.dataResources;
                    var url = "/resource/storeResourceDetail/"+this.editWork.wbs_id;
                    data = JSON.stringify(data);
                    $('div.overlay').show();            
                    window.axios.patch(url,data)
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

                            this.selected_resource_category = "";
                            this.dataResources = "";           
                        }
                        
                    })
                    .catch((error) => {
                        console.log(error);
                        $('div.overlay').hide();            
                    })

                }else{
                    var selected_resource_category = this.selected_resource_category;
                    var url = "/resource/storeResourceCategory/"+this.editWork.wbs_id;
                    selected_resource_category = JSON.stringify(selected_resource_category);
                    $('div.overlay').show();            
                    window.axios.patch(url,selected_resource_category)
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

                            this.selected_resource_category = "";
                            this.dataResources = "";          
                        }
                        
                    })
                    .catch((error) => {
                        console.log(error);
                        $('div.overlay').hide();            
                    })
                }
            }
        },
        addResource(){
            var resource_id = this.dataInput.resource_id;
            $('div.overlay').show();
            window.axios.get('/api/getResourcePM/'+resource_id).then(({ data }) => {
                this.dataInput.resource_name = data.name;
                this.dataInput.resource_code = data.code;
                this.dataInput.category_id = data.category.id;

                var temp_data = JSON.stringify(this.dataInput);
                temp_data = JSON.parse(temp_data);
                this.dataResources.push(temp_data);
                // this.resource_id.push(temp_data.resource_id);

                this.dataInput.resource_name = "";
                this.dataInput.resource_code = "";
                this.dataInput.quantity = "";
                this.dataInput.resource_id = "";
                
                this.newIndex = Object.keys(this.dataResources).length+1;
                
                $('div.overlay').hide();
            })
            .catch((error) => {
                iziToast.warning({
                    title: 'Please Try Again.. '+error,
                    position: 'topRight',
                    displayMode: 'replace'
                });
                $('div.overlay').hide();
            })
        },
        removeRow(index){
            this.dataResources.splice(index, 1);
            
            this.newIndex = this.dataResources.length + 1;
        }
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
        selected_resource_category : function(newValue){
            this.dataInput.resource_id = "";
            if(newValue.length > 0){
                data = JSON.stringify(newValue);
                window.axios.get('/api/getResourceByCategoryPM/'+data).then(({ data }) => {
                    this.resourcesSelectize = data;
                });
                
                var index = 0;
                this.dataResources.forEach(data => {
                    if(this.selected_resource_category.indexOf(""+data.category_id) == -1){
                        this.dataResources.splice(index, 1);
            
                        this.newIndex = this.dataResources.length + 1;
                    }
                    index++;
                });
            }
        },
        'dataInput.quantity': function(newValue){
            this.dataInput.quantityInt = newValue;
            var string_newValue = newValue+"";
            quantity_string = string_newValue.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            this.dataInput.quantity = quantity_string;
        },
    },
    created: function() {
        this.getWorks();
        this.newIndex = Object.keys(this.dataResources).length+1;
    },
    
});


</script>
@endpush