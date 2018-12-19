@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => $project->name,
        'items' => $array
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

                <div class="col-sm-6">
                    <table>
                        <thead>
                            <th>WBS Information</th>
                            <th></th>
                            <th></th>
                        </thead>
                    </table>
                    <table class="tableFixed width100">
                        <tbody>
                            <tr>
                                <td style="width: 25%">Name</td>
                                <td style="width: 3%">:</td>
                                <td><b>{{$wbs->name}}</b></td>
                            </tr>
                            <tr>
                                <td class="valignTop">Description</td>
                                <td class="valignTop">:</td>
                                <td class="valignTop" style="overflow-wrap: break-word;"><b >{{$wbs->description}}</b></td>
                            </tr>
                            <tr>
                                <td class="valignTop">Deliverable</td>
                                <td class="valignTop">:</td>
                                <td class="valignTop" style="overflow-wrap: break-word;"><b >{{$wbs->deliverables}}</b></td>
                            </tr>
                            <tr>
                                <td>Planned Deadline</td>
                                <td>:</td>
                                <td><b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $wbs->planned_deadline);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Progress</td>
                                <td>:</td>
                                <td><b>{{$wbs->progress}} %</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @verbatim
            <div id="add_wbs">
                <div class="box-body">
                    <h4 class="box-title">Work Breakdown Structures (Weight : <b>{{totalWeight}}%</b> / <b>{{parentWbsWeight}}%</b>)</h4>
                    <table id="wbs-table" class="table table-bordered" style="border-collapse:collapse; table-layout: fixed;">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 17%">Name</th>
                                <th style="width: 17%">Description</th>
                                <th style="width: 15%">Deliverables</th>
                                <th style="width: 11%">Deadline</th>
                                <th style="width: 11%">Weight</th>
                                <th style="width: 12%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in wbs">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.deliverables)">{{ data.deliverables }}</td>
                                <td>{{ data.planned_deadline }}</td>
                                <td>{{ data.weight }} %</td>
                                <td class="textCenter">
                                    <a class="btn btn-primary btn-xs" :href="createSubWBSRoute(data)">
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
                                <td class="textLeft p-l-0">
                                    <textarea v-model="newSubWBS.name" class="form-control width100" rows="2" name="name" placeholder="Name"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newSubWBS.description" class="form-control width100" rows="2" name="description" placeholder="Description"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newSubWBS.deliverables" class="form-control width100" rows="2" name="deliverables" placeholder="Deliverables"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <input v-model="newSubWBS.planned_deadline" type="text" class="form-control datepicker width100" id="planned_deadline" name="planned_deadline" placeholder="Deadline">
                                </td>
                                <td class="p-l-0">
                                    <input v-model="newSubWBS.weight" type="text" class="form-control width100" id="weight" weight="weight" placeholder="Weight (%)">
                                </td>
                                <td >
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
                                    <div class="row m-t-15">
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
                                        <div class="form-group col-sm-12">
                                            <label for="weight" class="control-label">Weight (%)</label>
                                            <input id="weight" type="text" class="form-control" v-model="editWbs.weight" placeholder="Insert Weight here..." >
                                        </div>
                                    </div>                                
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="update">SAVE</button>
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
    menu : @json($menu),
    wbs : "",
    newIndex : "", 
    parentWbsWeight : @json($wbs->weight),
    project_start_date : @json($project->planned_start_date),
    project_end_date : @json($project->planned_end_date),
    wbs_deadline : @json($wbs->planned_deadline),
    newSubWBS : {
        name : "",
        description : "",
        deliverables : "",
        planned_deadline : "",
        wbs_id : @json($wbs->id),
        project_id : @json($project->id),
        weight : "",
    },
    editWbs : {
        wbs_id: "",
        name : "",
        description : "",
        deliverables : "",
        planned_deadline : "",
        project_id : @json($project->id),
        weight : "",
    },
    maxWeight : 0,
    totalWeight : 0,
    active_id : "",
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
        $("#planned_deadline").datepicker().on(
            "changeDate", () => {
                this.newSubWBS.planned_deadline = $('#planned_deadline').val();
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
                if(this.newSubWBS.name == ""
                || this.newSubWBS.description == ""
                || this.newSubWBS.deliverables == ""
                || this.newSubWBS.weight == ""
                || this.newSubWBS.planned_deadline == "")
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
                || this.editWbs.weight == ""
                || this.editWbs.planned_deadline == "")
                {
                    isOk = true;
                }
            return isOk;
        },
        // updateOk: function(){
        //     let isOk = false;
        //         if(this.dataUpd.uom_id == ""
        //         || this.dataUpd.standard_price.replace(/,/g , '') < 1)
        //         {
        //             isOk = true;
        //         }
        //     return isOk;
        // },

    }, 
    methods:{
        tooltipText: function(text) {
            return text
        },
        openEditModal(data){
            document.getElementById("wbs_code").innerHTML= data.code;
            this.editWbs.wbs_id = data.id;
            this.active_id = data.id;
            this.editWbs.name = data.name;
            this.editWbs.description = data.description;
            this.editWbs.deliverables = data.deliverables;
            this.editWbs.planned_deadline = data.planned_deadline;
            this.editWbs.weight = data.weight;
            $('#edit_planned_deadline').datepicker('setDate', new Date(data.planned_deadline));
        },
        createSubWBSRoute(data){
            var url = "";
            if(this.menu == "building"){
                url = "/wbs/createSubWBS/"+this.newSubWBS.project_id+"/"+data.id;
            }else{
                url = "/wbs_repair/createSubWBS/"+this.newSubWBS.project_id+"/"+data.id;                
            }
            return url;
        },
        getSubWBS(){
            window.axios.get('/api/getWeightWbs/'+this.newSubWBS.wbs_id).then(({ data }) => {
                this.totalWeight = data;
            });
            window.axios.get('/api/getSubWbs/'+this.newSubWBS.wbs_id).then(({ data }) => {
                this.wbs = data;
                this.newIndex = Object.keys(this.wbs).length+1;

                this.maxWeight = roundNumber((this.parentWbsWeight-this.totalWeight),2);
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
            var newSubWBS = this.newSubWBS;
            newSubWBS = JSON.stringify(newSubWBS);
            var url = "";
            if(this.menu == "building"){
                url = "{{ route('wbs.store') }}";
            }else{
                url = "{{ route('wbs_repair.store') }}";              
            }
            $('div.overlay').show();            
            window.axios.post(url,newSubWBS)
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
                this.getSubWBS();
                this.newSubWBS.name = "";
                this.newSubWBS.description = "";
                this.newSubWBS.deliverables = "";
                this.newSubWBS.planned_deadline = "";
                this.newSubWBS.weight = "";
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();            
            })

        },
        update(){            
            var editWbs = this.editWbs;
            var url = "";
            if(this.menu == "building"){
                var url = "/wbs/update/"+editWbs.wbs_id;                
            }else{
                var url = "/wbs_repair/update/"+editWbs.wbs_id;                
            } 
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
                
                this.getSubWBS();   
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();            
            })

        }
    },
    watch: {
        'newSubWBS.planned_deadline': function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();
            var deadline_parent_wbs = new Date(this.wbs_deadline).toDateString();

            var deadline = new Date(newValue);
            var deadline_parent_wbs = new Date(deadline_parent_wbs);
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);
            if(deadline > deadline_parent_wbs){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS deadline is after parent WBS deadline",
                    position: 'topRight',
                });
            } else if(deadline < pro_planned_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS deadline is behind project start date",
                    position: 'topRight',
                });
            }else if(deadline > pro_planned_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS deadline is after project end date",
                    position: 'topRight',
                });
            }
        },
        'editWbs.planned_deadline': function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();
            var deadline_parent_wbs = new Date(this.wbs_deadline).toDateString();
            
            var deadline = new Date(newValue);
            var deadline_parent_wbs = new Date(deadline_parent_wbs);
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);
            if(deadline > deadline_parent_wbs){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS deadline is after parent WBS deadline",
                    position: 'topRight',
                });
            } else if(deadline < pro_planned_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS deadline is behind project start date",
                    position: 'topRight',
                });
            }else if(deadline > pro_planned_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS deadline is after project end date",
                    position: 'topRight',
                });
            }
        },  
        'newSubWBS.weight': function(newValue){
            this.newSubWBS.weight = (this.newSubWBS.weight+"").replace(/[^0-9.]/g, "");  
            if(roundNumber(newValue,2)>this.maxWeight){
                iziToast.warning({
                    displayMode: 'replace',
                    title: 'Total weight cannot exceed '+this.parentWbsWeight+'%',
                    position: 'topRight',
                });
            }
        },
        'editWbs.weight': function(newValue){
            this.editWbs.weight = (this.editWbs.weight+"").replace(/[^0-9.]/g, "");  
            var totalWeight = 0;
            this.wbs.forEach(data => {
                if(data.id != this.active_id){
                    totalWeight += data.weight;
                }
            });
            var maxWeightEdit = roundNumber(this.parentWbsWeight - roundNumber(totalWeight,2),2);            
            if(this.editWbs.weight>maxWeightEdit){
                iziToast.warning({
                    displayMode: 'replace',
                    title: 'Total weight cannot exceed '+this.parentWbsWeight+'%',
                    position: 'topRight',
                });
            }
        },
    },
    created: function() {
        this.getSubWBS();
    }
});

function roundNumber(num, scale) {
  if(!("" + num).includes("e")) {
    return +(Math.round(num + "e+" + scale)  + "e-" + scale);
  } else {
    var arr = ("" + num).split("e");
    var sig = ""
    if(+arr[1] + scale > 0) {
      sig = "+";
    }
    return +(Math.round(+arr[0] + "e" + sig + (+arr[1] + scale)) + "e-" + scale);
  }
}
</script>
@endpush