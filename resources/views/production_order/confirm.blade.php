@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Confirm Production Order » '.$modelPrO->number,
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('production_order.selectProject'),
            'Select WBS' => route('production_order.selectWBS', ['id' => $project->id]),
            'Add Additional Material & Resource' => ''
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-4 p-l-0">
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

                <div class="col-sm-4 p-l-0">
                    <table>
                        <thead>
                            <th colspan="2">WBS Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelPrO->wbs->code}}</b></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelPrO->wbs->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelPrO->wbs->description}}</b></td>
                            </tr>
                            <tr>
                                <td>Deliverable</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelPrO->wbs->deliverables}}</b></td>
                            </tr>
                            <tr>
                                <td>Progress</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$modelPrO->wbs->progress}}</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <form id="confirm-wo" class="form-horizontal" method="POST" action="{{ route('production_order.storeConfirm') }}">
            <input type="hidden" name="_method" value="PATCH">
            @csrf
            @verbatim
            <div id="production_order">
                <div class="box-body">
                    <h4 class="box-title">List of Activities</h4>
                    <table id="activity-table" class="table table-bordered tableFixed" >
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th style="width: 20%">Name</th>
                                <th style="width: 30%">Description</th>
                                <th style="width: 8%">Status</th>
                                <th style="width: 8%">Progress</th>
                                <th style="width: 8%">Weight</th>
                                <th style="width: 55px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in activities" >
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                <td class="textCenter">
                                    <template v-if="data.status == 0">
                                        <i class='fa fa-check'></i>
                                    </template>
                                    <template v-else>
                                        <i class='fa fa-times'></i>
                                    </template>
                                </td>
                                <td>{{ data.progress }} %</td>
                                <td>{{ data.weight }} %</td>
                                <td class="textCenter">
                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#confirm_activity_modal"  @click.prevent="openConfirmModal(data)">CONFIRM</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="modal fade" id="confirm_activity_modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Confirm Activity <b id="confirm_activity_code"></b></h4>
                                </div>
                                <div class="modal-body">
                                    <table>
                                        <thead>
                                            <th colspan="2">Activity Details</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Planned Start Date</td>
                                                <td>:</td>
                                                <td>&ensp;<b id="planned_start_date"></b></td>
                                            </tr>
                                            <tr>
                                                <td>Planned End Date</td>
                                                <td>:</td>
                                                <td>&ensp;<b id="planned_end_date"></b></td>
                                            </tr>
                                            <tr>
                                                <td>Planned Duration</td>
                                                <td>:</td>
                                                <td>&ensp;<b id="planned_duration"></b></td>
                                            </tr>
                                            <tr>
                                                <td>Predecessor</td>
                                                <td>:</td>
                                                <td>&ensp;<template v-if="havePredecessor == false">-</template></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <template v-if="havePredecessor == false"><br></template>
                                    <template v-if="havePredecessor == true">
                                        <table class="table table-bordered tableFixed">
                                            <thead>
                                                <tr>
                                                    <th class="p-l-5" style="width: 5%">No</th>
                                                    <th style="width: 15%">Code</th>
                                                    <th style="width: 29%">Name</th>
                                                    <th style="width: 29%">Description</th>
                                                    <th style="width: 15%">WBS Code</th>
                                                    <th style="width: 12%">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(data,index) in predecessorActivities">
                                                    <td class="p-b-15 p-t-15">{{ index + 1 }}</td>
                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.code)">{{ data.code }}</td>
                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.name)">{{ data.name }}</td>
                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                    <td class="tdEllipsis p-b-15 p-t-15" data-container="body" v-tooltip:top="tooltipText(data.wbs.code)">{{ data.wbs.code }}</td>
                                                    <td class="textCenter">
                                                        <template v-if="data.status == 0">
                                                            <i class='fa fa-check'></i>
                                                        </template>
                                                        <template v-else>
                                                            <i class='fa fa-times'></i>
                                                        </template>    
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </template>
                                    <div class="row">
                                        <div class=" col-sm-6">
                                            <label for="actual_start_date" class=" control-label">Actual Start Date</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input v-model="confirmActivity.actual_start_date" type="text" class="form-control datepicker" id="actual_start_date" placeholder="Start Date">                                             
                                            </div>
                                        </div>
                                                
                                        <div class=" col-sm-6">
                                            <label for="actual_end_date" class=" control-label">Actual End Date</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input v-model="confirmActivity.actual_end_date" type="text" class="form-control datepicker" id="actual_end_date" placeholder="End Date">                                                                                            
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="row">
                                        <div class=" col-sm-6">
                                            <label for="duration" class=" control-label">Actual Duration (Days)</label>
                                            <input @keyup="setEndDateEdit" @change="setEndDateEdit" v-model="confirmActivity.actual_duration"  type="number" class="form-control" id="actual_duration" placeholder="Duration" >                                        
                                        </div> 
                                        <div class=" col-sm-6">
                                            <label for="duration" class=" control-label">Current Progress (%)</label>
                                            <input v-model="confirmActivity.current_progress"  type="number" class="form-control" id="current_progress" placeholder="Current Progress" >                                        
                                        </div> 
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button id="btnSave" type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="confirm">SAVE</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="box-title m-t-0">Material</h4>
                            <table id="material-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 25%">Code</th>
                                        <th style="width: 25%">Name</th>
                                        <th style="width: 15%">Quantity</th>
                                        <th style="width: 15%">Actual</th>
                                        <th style="width: 15%">Remaining</th>
                                        <th style="width: 15%">Used</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data,index) in materials">
                                        <td>{{ index + 1 }}</td>
                                        <td class="tdEllipsis">{{ data.material.code }}</td>
                                        <td class="tdEllipsis">{{ data.material.name }}</td>
                                        <td class="tdEllipsis">{{ data.quantity }}</td>
                                        <td class="tdEllipsis">{{ data.actual }}</td>
                                        <td class="tdEllipsis">{{ data.sugQuantity }}</td>
                                        <td class="tdEllipsis no-padding ">
                                            <input class="form-control width100" v-model="data.used" placeholder="Please Input Quantity">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="box-title m-t-0">Resource</h4>
                            <table id="resource-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 25%">Code</th>
                                        <th style="width: 25%">Name</th>
                                        <th style="width: 15%">Available</th>
                                        <th style="width: 15%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data,index) in resources">
                                        <td>{{ index + 1 }}</td>
                                        <td class="tdEllipsis">{{ data.resource.code }}</td>
                                        <td class="tdEllipsis">{{ data.resource.name }}</td>
                                        <template v-if="data.resource.status == 1">
                                            <td class="tdEllipsis" >
                                                {{ 'YES' }}
                                            </td>
                                            <td class="tdEllipsis">
                                                <i class="fa fa-check text-success"></i>
                                            </td> 
                                        </template>
                                        <template v-else>
                                            <td class="tdEllipsis">
                                                {{ 'NO' }}
                                            </td>
                                            <td class="tdEllipsis">
                                                <i class="fa fa-times text-danger"></i>
                                            </td>
                                        </template>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 p-t-10 p-r-0">
                        <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">CONFIRM</button>
                    </div>
                </div>
            </div>
            @endverbatim
            </form>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const form = document.querySelector('form#confirm-wo');

    $(document).ready(function(){
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose : true,
        });
        $('#material-table,#resource-table,#activity-table').DataTable({
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
    });

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var data = {
        modelPrOD : @json($modelPrOD),
        activities : @json($modelPrO->wbs->activities),
        materials : [],
        resources : [],
        wbs_id: @json($modelPrO->wbs->id),
        predecessorActivities : [],
        activities : [],
        confirmActivity : {
            activity_id : "",
            actual_start_date : "",
            actual_end_date : "",
            actual_duration : "",
            current_progress : 0,
        },
        havePredecessor : false,
        submittedForm : {
        }
    };

    var vm = new Vue({
        el: '#production_order',
        data: data,
        mounted() {
            $('.datepicker').datepicker({
                autoclose : true,
            });

            $("#actual_start_date").datepicker().on(
                "changeDate", () => {
                    this.confirmActivity.actual_start_date = $('#actual_start_date').val();
                    if(this.confirmActivity.actual_end_date != "" && this.confirmActivity.actual_start_date != ""){
                        this.confirmActivity.actual_duration = datediff(parseDate(this.confirmActivity.actual_start_date), parseDate(this.confirmActivity.actual_end_date));
                    }else{
                        this.confirmActivity.actual_duration ="";
                    }
                    this.setEndDateEdit();
                }
            );
            $("#actual_end_date").datepicker().on(
                "changeDate", () => {
                    this.confirmActivity.actual_end_date = $('#actual_end_date').val();
                    if(this.confirmActivity.actual_start_date != "" && this.confirmActivity.actual_end_date != ""){
                        this.confirmActivity.actual_duration = datediff(parseDate(this.confirmActivity.actual_start_date), parseDate(this.confirmActivity.actual_end_date));
                    }else{
                        this.confirmActivity.actual_duration ="";
                    }
                }
            );
        },
        computed : {
            createOk: function(){
                let isOk = false;

                return isOk;
            }
        },
        methods: {
            tooltipText: function(text) {
                return text
            },
            submitForm() {
                // var data = this.PRDetail;
                // data = JSON.stringify(data);
                // data = JSON.parse(data);

                // data.forEach(PRD => {
                //     PRD.quantity = PRD.quantity.replace(/,/g , '');      
                // });

                this.submittedForm.modelPrOD = this.modelPrOD;
                this.submittedForm.materials = this.materials;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            openConfirmModal(data){
                this.predecessorTableView = [];
                if(data.predecessor != null){
                    this.havePredecessor = true;
                    window.axios.get('/api/getPredecessor/'+data.id).then(({ data }) => {
                        this.predecessorActivities = data;
                        if(this.predecessorActivities.length>0){
                            this.predecessorActivities.forEach(activity => {
                                if(activity.status == 1){
                                    $('#actual_start_date').datepicker('setDate', null);
                                    document.getElementById("actual_start_date").disabled = true;
                                    document.getElementById("actual_start_date").value = null;
                                    document.getElementById("actual_end_date").disabled = true;
                                    document.getElementById("actual_duration").disabled = true;
                                    document.getElementById("btnSave").disabled = true;
                                    document.getElementById("current_progress").disabled = true;
                                }else{
                                    document.getElementById("actual_start_date").disabled = false;
                                }
                            });
                        }else{
                            document.getElementById("actual_start_date").disabled = false;
                        }
                    });
                }else{
                    document.getElementById("actual_start_date").disabled = false;
                    this.havePredecessor = false;
                    this.predecessorActivities = [];
                }
                
                this.confirmActivity.current_progress = data.progress;
                if(this.confirmActivity.current_progress != 100){
                    document.getElementById("actual_end_date").disabled = true;
                    document.getElementById("actual_duration").disabled = true;
                    this.confirmActivity.actual_end_date = "";
                    this.confirmActivity.actual_duration = "";
                }else{
                    document.getElementById("actual_end_date").disabled = false;
                    document.getElementById("actual_duration").disabled = false;
                }
                document.getElementById("confirm_activity_code").innerHTML= data.code;
                document.getElementById("planned_start_date").innerHTML= data.planned_start_date;
                document.getElementById("planned_end_date").innerHTML= data.planned_end_date;
                document.getElementById("planned_duration").innerHTML= data.planned_duration+" Days";


                this.confirmActivity.activity_id = data.id;
                $('#actual_start_date').datepicker('setDate', (data.actual_start_date != null ? new Date(data.actual_start_date):new Date(data.planned_start_date)));
                $('#actual_end_date').datepicker('setDate', (data.actual_end_date != null ? new Date(data.actual_end_date):null));

            },
            setEndDateEdit(){
                if(this.confirmActivity.actual_duration != "" && this.confirmActivity.actual_start_date != ""){
                    var actual_duration = parseInt(this.confirmActivity.actual_duration);
                    var actual_start_date = this.confirmActivity.actual_start_date;
                    var actual_end_date = new Date(actual_start_date);
                    
                    actual_end_date.setDate(actual_end_date.getDate() + actual_duration-1);
                    $('#actual_end_date').datepicker('setDate', actual_end_date);

                }else{
                    this.confirmActivity.actual_end_date = "";
                }
            },
            getActivities(){
                window.axios.get('/api/getActivities/'+this.wbs_id).then(({ data }) => {
                    this.activities = data;
                    var dT = $('#activity-table').DataTable();
                    dT.destroy();
                    this.$nextTick(function() {
                        $('#activity-table').DataTable({
                            'paging'      : true,
                            'lengthChange': false,
                            'searching'   : false,
                            'ordering'    : false,
                            'info'        : true,
                            'autoWidth'   : false,
                            'initComplete': function(){
                                $('div.overlay').remove();
                            },
                            columnDefs : [
                                { targets: 0, sortable: false},
                            ]
                        });
                    })
                });

            },
            confirm(){            
                var confirmActivity = this.confirmActivity;
                var url = "";
                if(this.menu == "building"){
                    var url = "/activity/updateActualActivity/"+confirmActivity.activity_id;
                }else{
                    var url = "/activity_repair/updateActualActivity/"+confirmActivity.activity_id;
                }
                confirmActivity = JSON.stringify(confirmActivity);
                window.axios.put(url,confirmActivity)
                .then((response) => {
                    if(response.data.error != undefined){
                        iziToast.warning({
                            displayMode: 'replace',
                            title: response.data.error,
                            position: 'topRight',
                        });
                    }else{
                        iziToast.success({
                            displayMode: 'replace',
                            title: response.data.response,
                            position: 'topRight',
                        });
                    }
                    this.getActivities();   
                })
                .catch((error) => {
                    iziToast.warning({
                        displayMode: 'replace',
                        title: "Please try again.. ",
                        position: 'topRight',
                    });
                    console.log(error);
                })

            }
        },
        watch : {
            confirmActivity:{
                handler: function(newValue) {
                    if(this.confirmActivity.actual_start_date == ""){
                        document.getElementById("actual_end_date").disabled = true;
                        document.getElementById("actual_duration").disabled = true;
                        document.getElementById("btnSave").disabled = true;
                        document.getElementById("current_progress").disabled = true;
                    }else{
                        document.getElementById("actual_end_date").disabled = false;
                        document.getElementById("actual_duration").disabled = false;
                        document.getElementById("btnSave").disabled = false;
                        document.getElementById("current_progress").disabled = false;
                    }     

                    if(this.confirmActivity.current_progress != 100){
                        document.getElementById("actual_end_date").disabled = true;
                        document.getElementById("actual_duration").disabled = true;
                        this.confirmActivity.actual_end_date = "";
                        this.confirmActivity.actual_duration = "";
                    }else{
                        document.getElementById("actual_end_date").disabled = false;
                        document.getElementById("actual_duration").disabled = false;
                        if(this.confirmActivity.actual_end_date == ""){
                            document.getElementById("btnSave").disabled = true;
                        }else{
                            document.getElementById("btnSave").disabled = false;
                        }
                    }
                },
                deep: true
            }, 
            'confirmActivity.actual_start_date' :function(newValue){
                if(newValue == ""){
                    $('#actual_end_date').datepicker('setDate', null);
                    this.confirmActivity.actual_duration = "";
                }
            },
            'confirmActivity.actual_duration' : function(newValue){
                this.confirmActivity.actual_duration = newValue+"".replace(/\D/g, "");
                    if(parseInt(newValue) < 1 ){
                        iziToast.warning({
                            displayMode: 'replace',
                            title: 'End Date cannot be ahead Start Date',
                            position: 'topRight',
                        });
                        this.confirmActivity.actual_duration = "";
                        this.confirmActivity.actual_end_date = "";
                    }
            },
        },
        created: function() {
            $('div.overlay').show();
            this.getActivities();
            this.modelPrOD.forEach(POD => {
                if(POD.material_id != null){
                    if(POD.actual == null){
                        POD.actual = 0;
                    }
                    POD.sugQuantity = POD.quantity-POD.actual;
                    POD.used = POD.quantity-POD.actual;
                    this.materials.push(POD);
                }else if(POD.resource_id != null){
                    this.resources.push(POD);
                }
            });
        },
    });

function parseDate(str) {
    var mdy = str.split('/');
    return new Date(mdy[2], mdy[0]-1, mdy[1]);
}

function datediff(first, second) {
    // Take the difference between the dates and divide by milliseconds per day.
    // Round to nearest whole number to deal with DST.
    return Math.round(((second-first)/(1000*60*60*24))+1);
}
</script>
@endpush
