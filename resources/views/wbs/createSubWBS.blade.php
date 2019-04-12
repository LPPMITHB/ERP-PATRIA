@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Manage Work Breakdown Structures',
        'items' => $array
    ]
)
@endbreadcrumb
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12 col-lg-4 col-md-12">    
                    <div class="box-header">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
                        
                        <div class="col-md-3 col-xs-4 no-padding">Code</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$project->number}}</b></div>
                        
                        <div class="col-md-3 col-xs-4 no-padding">Ship</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$project->ship->type}}</b></div>

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
                <div class="box-header">
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
            @verbatim
            <div id="add_wbs">
                <div class="box-body">
                    <h4 class="box-title">Work Breakdown Structures (Weight : <b>{{totalWeight}}%</b> / <b>{{parentWbsWeight}}%</b>)</h4>
                    <table id="wbs-table" class="table table-bordered tableFixed" style="border-collapse:collapse">
                        <thead>
                            <tr>
                                <th style="width: 2px">No</th>
                                <th style="width: 10%">Number</th>
                                <th style="width: 15%">Description</th>
                                <th style="width: 15%">Deliverables</th>
                                <th style="width: 7%">Start Date</th>
                                <th style="width: 7%">End Date</th>
                                <th style="width: 7%">Duration</th>
                                <th style="width: 30px">Weight</th>
                                <th style="width: 75px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in wbs">
                                <td>{{ index + 1 }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.number)">{{ data.number }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(data.deliverables)">{{ data.deliverables }}</td>
                                <td>{{ data.planned_start_date }}</td>
                                <td>{{ data.planned_end_date }}</td>
                                <td>{{ data.planned_duration }} Day(s)</td>
                                <td>{{ data.weight }} %</td>
                                <td class="p-l-0 p-r-0 p-b-0 textCenter">
                                    <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                        <div class="col-sm-12 col-xs-12 no-padding p-r-5 p-b-5">
                                            <a class="btn btn-primary btn-xs col-xs-12" :href="createSubWBSRoute(data)">
                                                MANAGE WBS
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                        <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                            <a class="btn btn-primary btn-xs col-xs-12" @click="openEditModal(data)" data-toggle="modal" href="#edit_wbs">
                                                EDIT
                                            </a>
                                        </div>
                                        <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                            <a class="btn btn-danger btn-xs col-xs-12" @click="deleteWbs(data)" data-toggle="modal">
                                                DELETE
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="p-l-10">{{newIndex}}</td>
                                <td class="p-l-0">
                                    <input v-model="newSubWBS.number" type="text" class="form-control width100" id="number" name="number" placeholder="Number">
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newSubWBS.description" class="form-control width100" rows="2" name="description" placeholder="Description"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <textarea v-model="newSubWBS.deliverables" class="form-control width100" rows="2" name="deliverables" placeholder="Deliverables"></textarea>
                                </td>
                                <td class="p-l-0">
                                    <input autocomplete="off" v-model="newSubWBS.planned_start_date" type="text" class="form-control datepicker width100" id="planned_start_date" name="planned_start_date" placeholder="Start Date">
                                </td>
                                <td class="p-l-0">
                                    <input autocomplete="off" v-model="newSubWBS.planned_end_date" type="text" class="form-control datepicker width100" id="planned_end_date" name="planned_end_date" placeholder="End Date">
                                </td>
                                <td class="p-l-0">
                                    <input @keyup="setEndDateNew" @change="setEndDateNew" v-model="newSubWBS.planned_duration"  type="number" class="form-control width100" id="duration" name="duration" placeholder="Duration" >                                        
                                </td>
                                <td class="p-l-0">
                                    <input v-model="newSubWBS.weight" type="text" class="form-control width100" id="weight" placeholder="Weight (%)">
                                </td>
                                <td align="center" class="p-l-0">
                                    <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">CREATE</button>
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
                                            <label for="number" class="control-label">Number</label>
                                            <input id="number" type="text" class="form-control" v-model="editWbs.number" placeholder="Insert Number here..." >
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="description" class="control-label">Description</label>
                                            <textarea id="description" v-model="editWbs.description" class="form-control" rows="2" placeholder="Insert Description here..."></textarea>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="deliverables" class="control-label">Deliverables</label>
                                            <textarea id="deliverables" v-model="editWbs.deliverables" class="form-control" rows="2" placeholder="Insert Deliverables here..."></textarea>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="edit_planned_start_date" class=" control-label">Start Date</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input autocomplete="off" v-model="editWbs.planned_start_date" type="text" class="form-control datepicker" id="edit_planned_start_date" placeholder="Insert Start Date here...">                                             
                                            </div>
                                        </div>
                                                
                                        <div class="form-group col-sm-4">
                                            <label for="edit_planned_end_date" class=" control-label">End Date</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input autocomplete="off" v-model="editWbs.planned_end_date" type="text" class="form-control datepicker" id="edit_planned_end_date" placeholder="Insert End Date here...">                                                                                            
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-sm-4">
                                            <label for="duration" class=" control-label">Duration</label>
                                            <input @keyup="setEndDateEdit" @change="setEndDateEdit" v-model="editWbs.planned_duration"  type="number" class="form-control" id="edit_duration" placeholder="Duration" >                                        
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="weight" class="control-label">Weight (%)</label>
                                            <input id="weight" type="text" class="form-control" v-model="editWbs.weight" placeholder="Insert Weight here..." >
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
                    
                    <div class="modal fade" id="adopt_wbs">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Adopt from WBS Profiles</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="">WBS Profiles</label>
                                            <selectize v-model="selected_wbs_profile" :settings="wbsProfilesSettings">
                                                <option v-for="(wbs_profile, index) in wbs_profiles" :value="wbs_profile.id">{{ wbs_profile.number }} - {{ wbs_profile.description }}</option>
                                            </selectize>
                                        </div>
                                        <div class="form-group col-sm-12" v-show="selected_wbs_profile != ''">
                                            <label for="">WBS Profile Structure</label>
                                            <div id="treeview">
                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" :disabled="profileOk" data-dismiss="modal" @click.prevent="adoptWbs">ADOPT</button>
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
    wbs : [],
    newIndex : "", 
    parentWbsWeight : @json($wbs->weight),
    project_start_date : @json($project->planned_start_date),
    project_end_date : @json($project->planned_end_date),
    parent_wbs_start_date : @json($wbs->planned_start_date),
    parent_wbs_end_date : @json($wbs->planned_end_date),
    newSubWBS : {
        number : "",
        description : "",
        deliverables : "",
        wbs_id : @json($wbs->id),
        project_id : @json($project->id),
        weight : "",
        planned_start_date : "",
        planned_end_date : "",
        planned_duration : "",
    },
    editWbs : {
        wbs_id: "",
        number : "",
        description : "",
        deliverables : "",
        project_id : @json($project->id),
        weight : "",
        planned_start_date : "",
        planned_end_date : "",
        planned_duration : "",
    },
    maxWeight : 0,
    totalWeight : 0,
    active_id : "",
    wbs_profiles : @json($wbs_profiles),
    selected_wbs_profile : "",
    wbsProfilesSettings: {
        placeholder: 'WBS Profiles',
    },
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
            format : "dd-mm-yyyy"
        });
        $("#planned_start_date").datepicker().on(
            "changeDate", () => {
                this.newSubWBS.planned_start_date = $('#planned_start_date').val();
                if(this.newSubWBS.planned_end_date != ""){
                    this.newSubWBS.planned_duration = datediff(parseDate(this.newSubWBS.planned_start_date), parseDate(this.newSubWBS.planned_end_date));
                }
                this.setEndDateNew();
            }
        );
        $("#planned_end_date").datepicker().on(
            "changeDate", () => {
                this.newSubWBS.planned_end_date = $('#planned_end_date').val();
                if(this.newSubWBS.planned_start_date != ""){
                    this.newSubWBS.planned_duration = datediff(parseDate(this.newSubWBS.planned_start_date), parseDate(this.newSubWBS.planned_end_date));
                }
            }
        );

        $("#edit_planned_start_date").datepicker().on(
            "changeDate", () => {
                this.editWbs.planned_start_date = $('#edit_planned_start_date').val();
                if(this.editWbs.planned_end_date != ""){
                    this.editWbs.planned_duration = datediff(parseDate(this.editWbs.planned_start_date), parseDate(this.editWbs.planned_end_date));
                }
                this.setEndDateEdit();
            }
        );
        $("#edit_planned_end_date").datepicker().on(
            "changeDate", () => {
                this.editWbs.planned_end_date = $('#edit_planned_end_date').val();
                if(this.editWbs.planned_start_date != ""){
                    this.editWbs.planned_duration = datediff(parseDate(this.editWbs.planned_start_date), parseDate(this.editWbs.planned_end_date));
                }
            }
        );
    },
    computed:{
        createOk: function(){
            let isOk = false;
                if(this.newSubWBS.number == ""
                || this.newSubWBS.deliverables == ""
                || this.newSubWBS.weight == ""
                || this.newSubWBS.planned_start_date == ""
                || this.newSubWBS.planned_end_date == ""
                || this.newSubWBS.planned_duration == "")
                {
                    isOk = true;
                }
            return isOk;
        },
        updateOk: function(){
            let isOk = false;
                if(this.editWbs.number == ""
                || this.editWbs.deliverables == ""
                || this.editWbs.weight == ""
                || this.editWbs.planned_start_date == ""
                || this.editWbs.planned_end_date == ""
                || this.editWbs.planned_duration == "")
                {
                    isOk = true;
                }
            return isOk;
        },
        profileOk: function(){
            let isOk = false;
                if(this.selected_wbs_profile == "")
                {
                    isOk = true;
                }
            return isOk;
        }
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
        openAdoptModal(){
            if(this.wbs_profiles.length > 0){
                $('#adopt_wbs').modal();            
            }else{
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This project type doesn't have WBS Profiles",
                    position: 'topRight',
                });
            }
        },
        openEditModal(data){
            this.editWbs.number = "";
            this.editWbs.description = "";
            this.editWbs.deliverables = "";
            this.editWbs.weight = ""; 
            document.getElementById("wbs_code").innerHTML= data.code;
            this.editWbs.wbs_id = data.id;
            this.active_id = data.id;
            this.editWbs.number = data.number;
            this.editWbs.description = data.description;
            this.editWbs.deliverables = data.deliverables;
            this.editWbs.weight = data.weight;
            if(data.planned_start_date != null){
                this.editWbs.planned_start_date = data.planned_start_date;
                $('#edit_planned_start_date').datepicker('setDate', new Date(data.planned_start_date.split("-").reverse().join("-")));
            }

            if(data.planned_end_date != null){
                this.editWbs.planned_end_date = data.planned_end_date;
                $('#edit_planned_end_date').datepicker('setDate', new Date(data.planned_end_date.split("-").reverse().join("-")));
            }
            
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
                window.axios.get('/api/getSubWbs/'+this.newSubWBS.wbs_id).then(({ data }) => {
                    this.wbs = data;
                    this.newIndex = Object.keys(this.wbs).length+1;
                    this.wbs.forEach(data => {
                        if(data.planned_start_date != null){
                        data.planned_start_date = data.planned_start_date.split("-").reverse().join("-");   
                        }

                        if(data.planned_end_date != null){
                            data.planned_end_date = data.planned_end_date.split("-").reverse().join("-");   
                        }
                    });
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
            });
        },
        adoptWbs(){
            var data = {};
            data.selected_wbs_profile = this.selected_wbs_profile;
            data.project_id = this.newSubWBS.project_id;
            data.parent_wbs = this.newSubWBS.wbs_id;
            data = JSON.stringify(data);
            var url = "";
            if(this.menu == "building"){
                url = "{{ route('wbs.adoptWbs') }}";
            }else{
                url = "{{ route('wbs_repair.adoptWbs') }}";              
            }
            $('div.overlay').show();            
            window.axios.post(url,data)
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
                this.selected_wbs_profile = "";                
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();            
            })
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
                this.newSubWBS.number = "";
                this.newSubWBS.description = "";
                this.newSubWBS.deliverables = "";
                this.newSubWBS.planned_start_date = "";                
                this.newSubWBS.planned_end_date = "";                
                this.newSubWBS.planned_duration = "";         
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
            window.axios.put(url,editWbs)
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
                this.editWbs.number = "";
                this.editWbs.description = "";
                this.editWbs.deliverables = "";
                this.editWbs.planned_start_date = "";                
                this.editWbs.planned_end_date = "";                
                this.editWbs.planned_duration = "";                
                this.editWbs.weight = "";   
            })
            .catch((error) => {
                console.log(error);
                $('div.overlay').hide();            
            })

        },
        deleteWbs(data){
            var menuTemp = this.menu;
            iziToast.question({
                close: false,
                overlay: true,
                timeout : 0,
                displayMode: 'once',
                id: 'question',
                zindex: 9999,
                title: 'Confirm',
                message: 'Are you sure you want to delete this WBS?',
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {
                        var url = "";
                        if(menuTemp == "building"){
                            url = "/wbs/deleteWbs/"+data.id;
                        }else{
                            url = "/wbs_repair/deleteWbs/"+data.id;
                        }
                        $('div.overlay').show();            
                        window.axios.delete(url)
                        .then((response) => {
                            if(response.data.error != undefined){
                                response.data.error.forEach(error => {
                                    iziToast.warning({
                                        displayMode: 'replace',
                                        title: error,
                                        position: 'topRight',
                                    });
                                });
                                $('div.overlay').hide();
                            }else{
                                iziToast.success({
                                    displayMode: 'replace',
                                    title: response.data.response,
                                    position: 'topRight',
                                });
                                $('div.overlay').hide();   
                                vm.getSubWBS();
                            }
                        })
                        .catch((error) => {
                            iziToast.warning({
                                displayMode: 'replace',
                                title: "Please try again.. ",
                                position: 'topRight',
                            });
                            console.log(error);
                            $('div.overlay').hide();            
                        })

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
            
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }],
                ],
            });
        },
        setEndDateNew(){
            if(this.newSubWBS.planned_duration != "" && this.newSubWBS.planned_start_date != ""){
                var planned_duration = parseInt(this.newSubWBS.planned_duration);
                var planned_start_date = this.newSubWBS.planned_start_date;
                var planned_end_date = new Date(planned_start_date.split("-").reverse().join("-"));
                
                planned_end_date.setDate(planned_end_date.getDate() + planned_duration-1);
                $('#planned_end_date').datepicker('setDate', planned_end_date);
            }else{
                this.newSubWBS.planned_end_date = "";
            }
        },
        setEndDateEdit(){
            if(this.editWbs.planned_duration != "" && this.editWbs.planned_start_date != ""){
                var planned_duration = parseInt(this.editWbs.planned_duration);
                var planned_start_date = this.editWbs.planned_start_date;
                var planned_end_date = new Date(planned_start_date.split("-").reverse().join("-"));
                
                planned_end_date.setDate(planned_end_date.getDate() + planned_duration-1);
                $('#edit_planned_end_date').datepicker('setDate', planned_end_date);
            }else{
                this.editWbs.planned_end_date = "";
            }
        },
    },
    watch: {
        newSubWBS:{
            handler: function(newValue) {
                this.newSubWBS.planned_duration = newValue.planned_duration+"".replace(/\D/g, "");
                if(parseInt(newValue.planned_duration) < 1 ){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: 'End Date cannot be ahead Start Date',
                        position: 'topRight',
                    });
                    this.newSubWBS.planned_duration = "";
                    this.newSubWBS.planned_end_date = "";
                    this.newSubWBS.planned_start_date = "";
                }
            },
            deep: true
        },
        editWbs:{
            handler: function(newValue) {
                this.editWbs.planned_duration = newValue.planned_duration+"".replace(/\D/g, "");
                if(parseInt(newValue.planned_duration) < 1 ){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: 'End Date cannot be ahead Start Date',
                        position: 'topRight',
                    });
                    this.editWbs.planned_duration = "";
                    this.editWbs.planned_end_date = "";
                    this.editWbs.planned_start_date = "";
                }
            },
            deep: true
        },
        'newSubWBS.planned_start_date': function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();
            var parent_wbs_start_date = new Date(this.parent_wbs_start_date).toDateString();
            var parent_wbs_end_date = new Date(this.parent_wbs_end_date).toDateString();

            var planned_start_date = new Date(newValue.split("-").reverse().join("-")+" 00:00:00");
            var parent_wbs_start_date = new Date(parent_wbs_start_date);
            var parent_wbs_end_date = new Date(parent_wbs_end_date);
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);

            if(planned_start_date < parent_wbs_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS start date is behind parent WBS start date",
                    position: 'topRight',
                });
                $('#planned_start_date').datepicker('setDate', parent_wbs_start_date);
            }else if(planned_start_date > parent_wbs_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS start date is after parent WBS end date",
                    position: 'topRight',
                });
                $('#planned_start_date').datepicker('setDate', parent_wbs_end_date);
            }else if(planned_start_date < pro_planned_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS start date is behind project start date",
                    position: 'topRight',
                });
                $('#planned_start_date').datepicker('setDate', pro_planned_start_date);
            }else if(planned_start_date > pro_planned_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS start date is after project end date",
                    position: 'topRight',
                });
                $('#planned_start_date').datepicker('setDate', pro_planned_end_date);
            }
        },
        'newSubWBS.planned_end_date': function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();
            var parent_wbs_start_date = new Date(this.parent_wbs_start_date).toDateString();
            var parent_wbs_end_date = new Date(this.parent_wbs_end_date).toDateString();

            var planned_end_date = new Date(newValue.split("-").reverse().join("-")+" 00:00:00");
            var parent_wbs_start_date = new Date(parent_wbs_start_date);
            var parent_wbs_end_date = new Date(parent_wbs_end_date);
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);

            if(planned_end_date < parent_wbs_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS end date is behind parent WBS start date",
                    position: 'topRight',
                });
                $('#planned_end_date').datepicker('setDate', parent_wbs_start_date);
            }else if(planned_end_date > parent_wbs_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS end date is after parent WBS end date",
                    position: 'topRight',
                });
                $('#planned_end_date').datepicker('setDate', parent_wbs_end_date);
            }else if(planned_end_date < pro_planned_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS end date is behind project start date",
                    position: 'topRight',
                });
                $('#planned_end_date').datepicker('setDate', pro_planned_start_date);
            }else if(planned_end_date > pro_planned_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS end date is after project end date",
                    position: 'topRight',
                });
                $('#planned_end_date').datepicker('setDate', pro_planned_end_date);
            }
        },
        'editSubWBS.planned_start_date': function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();
            var parent_wbs_start_date = new Date(this.parent_wbs_start_date).toDateString();
            var parent_wbs_end_date = new Date(this.parent_wbs_end_date).toDateString();

            var planned_start_date = new Date(newValue.split("-").reverse().join("-")+" 00:00:00");
            var parent_wbs_start_date = new Date(parent_wbs_start_date);
            var parent_wbs_end_date = new Date(parent_wbs_end_date);
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);

            if(planned_start_date < parent_wbs_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS start date is behind parent WBS start date",
                    position: 'topRight',
                });
                $('#edit_planned_start_date').datepicker('setDate', parent_wbs_start_date);
            }else if(planned_start_date > parent_wbs_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS start date is after parent WBS end date",
                    position: 'topRight',
                });
                $('#edit_planned_start_date').datepicker('setDate', parent_wbs_end_date);
            }else if(planned_start_date < pro_planned_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS start date is behind project start date",
                    position: 'topRight',
                });
                $('#edit_planned_start_date').datepicker('setDate', pro_planned_start_date);
            }else if(planned_start_date > pro_planned_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS start date is after project end date",
                    position: 'topRight',
                });
                $('#edit_planned_start_date').datepicker('setDate', pro_planned_end_date);
            }
        },
        'editSubWBS.planned_end_date': function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();
            var parent_wbs_start_date = new Date(this.parent_wbs_start_date).toDateString();
            var parent_wbs_end_date = new Date(this.parent_wbs_end_date).toDateString();

            var planned_end_date = new Date(newValue.split("-").reverse().join("-")+" 00:00:00");
            var parent_wbs_start_date = new Date(parent_wbs_start_date);
            var parent_wbs_end_date = new Date(parent_wbs_end_date);
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);

            if(planned_end_date < parent_wbs_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS end date is behind parent WBS start date",
                    position: 'topRight',
                });
                $('#edit_planned_end_date').datepicker('setDate', parent_wbs_start_date);
            }else if(planned_end_date > parent_wbs_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS end date is after parent WBS end date",
                    position: 'topRight',
                });
                $('#edit_planned_end_date').datepicker('setDate', parent_wbs_end_date);
            }else if(planned_end_date < pro_planned_start_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS end date is behind project start date",
                    position: 'topRight',
                });
                $('#edit_planned_end_date').datepicker('setDate', pro_planned_start_date);
            }else if(planned_end_date > pro_planned_end_date){
                iziToast.warning({
                    displayMode: 'replace',
                    title: "This WBS end date is after project end date",
                    position: 'topRight',
                });
                $('#edit_planned_end_date').datepicker('setDate', pro_planned_end_date);
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
                this.newSubWBS.weight = this.maxWeight;
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
                this.editWbs.weight = maxWeightEdit;
            }
        },
        selected_wbs_profile : function(newValue){
            if(newValue != ""){
                window.axios.get('/api/getDataProfileJstree/'+newValue).then(({ data }) => {
                    $('#treeview').jstree("destroy");
                    $('#treeview').jstree({
                        "core": {
                            'data': data,
                            "check_callback": true,
                            "animation": 200,
                            "dblclick_toggle": false,
                            "keep_selected_style": false
                        },
                        "plugins": ["dnd", "contextmenu"],
                        "contextmenu": {
                            "select_node": false, 
                            "show_at_node": false,
                            'items' : null
                        }
                    }).bind("changed.jstree", function (e, data) {
                    }).bind("loaded.jstree", function (event, data) {
                        // you get two params - event & data - check the core docs for a detailed description
                    });
                });
            }
        }
    },
    created: function() {
        this.getSubWBS();
    }
});
function parseDate(str) {
    var mdy = str.split('-');
    var date = new Date(mdy[2], mdy[1]-1, mdy[0]);
    return date;
}

function datediff(first, second) {
    // Take the difference between the dates and divide by milliseconds per day.
    // Round to nearest whole number to deal with DST.
    return Math.round(((second-first)/(1000*60*60*24))+1);
}
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