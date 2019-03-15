@extends('layouts.main')

@section('content-header')
    @if ($menu == "building")
        @breadcrumb(
            [
                'title' => 'View WBS » '.$wbs->code,
                'items' => [
                    'Dashboard' => route('index'),
                    'View all Projects' => route('project.index'),
                    'Project|'.$wbs->project->number => route('project.show',$wbs->project->id),
                    'Select WBS' =>  route('project.listWBS',['id'=>$wbs->project->id,'menu'=>'viewWbs']),
                    'View WBS|'.$wbs->code => ""
                ]
            ]
        )
        @endbreadcrumb
    @else
        @breadcrumb(
            [
                'title' => 'View WBS » '.$wbs->code,
                'items' => [
                    'Dashboard' => route('index'),
                    'View all Projects' => route('project_repair.index'),
                    'Project|'.$wbs->project->number => route('project_repair.show',$wbs->project->id),
                    'Select WBS' =>  route('project_repair.listWBS',['id'=>$wbs->project->id,'menu'=>'viewWbs']),
                    'View WBS|'.$wbs->code => ""
                ]
            ]
        )
        @endbreadcrumb
    @endif
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="box-title"></div>
                <div class="box-tools pull-right p-t-5">
                    @can('edit-material')
                        <a class="btn btn-primary btn-sm mobile_button_view" data-toggle="modal" href="#edit_wbs">
                            EDIT
                        </a>
                    @endcan
                </div>
            </div>
            @verbatim
            <div id="edit">

                    <div class="box-body">
                        <table class="table table-bordered width100 showTable tableFixed">
                            <thead>
                                <tr>
                                    <th style="width: 10%">#</th>
                                    <th style="width: 40%">Attribute</th>
                                    <th style="width: 58%">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Code</td>
                                    <td>{{ wbsDisplay.code }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Number</td>
                                    <td>{{ wbsDisplay.number }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Description</td>
                                    <td class="tdEllipsis" data-container="body" v-tooltip:top="tooltipText(wbsDisplay.description)">{{ wbsDisplay.description }}</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Deliverables</td>
                                    <td>{{ wbsDisplay.deliverables }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Project</td>
                                    <td class="tdEllipsis"  data-container="body" v-tooltip:top="tooltipText(wbsDisplay.projectText)">{{wbsDisplay.projectText}}</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Parent WBS</td>
                                    <td v-if="wbsDisplay.parent_wbs != null">[{{ wbsDisplay.parent_wbs.code+"] - "+wbsDisplay.parent_wbs.number }}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Planned Start Date</td>
                                    <td>{{ wbsDisplay.planned_start_date }}</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Planned End Date</td>
                                    <td>{{ wbsDisplay.planned_end_date }}</td>
                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>Planned Duration</td>
                                    <td>{{ wbsDisplay.planned_duration }} Day(s)</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Actual Start Date</td>
                                    <td v-if="wbsDisplay.actual_start_date != null">{{ wbsDisplay.actual_start_date }}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>Actual End Date</td>
                                    <td v-if="wbsDisplay.actual_end_date != null">{{ wbsDisplay.actual_end_date }}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td>Actual Duration</td>
                                    <td v-if="wbsDisplay.actual_duration != null">{{ wbsDisplay.actual_duration }} Day(s)</td>
                                    <td v-else>-</td>
                                </tr>
        
                                <tr>
                                    <td>13</td>
                                    <td>Progress</td>
                                    <td v-if="wbsDisplay.progress != null">{{ wbsDisplay.progress }} %</td>
                                    <td v-else>0 %</td>
                                </tr>
        
                                <tr>
                                    <td>14</td>
                                    <td>Weight</td>
                                    <td>{{ wbsDisplay.weight }} %</td>
                                </tr>
                                <tr>
                                    <td >15</td>
                                    <td>Status</td>
                                    <td class="iconTd">
                                        <i v-if="wbsDisplay.status == 0" class="fa fa-check"></i>
                                        <i v-else class="fa fa-times"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="edit_wbs">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit Work Breakdown Structures <b id="wbs_code">{{editWbs.code}}</b></h4>
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
                                                <label v-if="editWbs.parent_wbs != null" for="weight" class="control-label">Weight (Parent Weight = {{totalWeight}}%/{{editWbs.parent_wbs.weight}}%)</label>
                                                <label v-else for="weight" class="control-label">Weight (Parent Weight = {{totalWeight}}%/100%)</label>
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
                </div>
            </div>
            @endverbatim
            @if ($menu == "building")
                <form id="updateWbs" class="form-horizontal" method="POST" action="{{ route('wbs.updateWithForm',['id'=>$wbs->id]) }}">
            @elseif ($menu == "repair")
                <form id="updateWbs" class="form-horizontal" method="POST" action="{{ route('wbs_repair.updateWithForm',['id'=>$wbs->id]) }}"> 
            @else
                           
            @endif
                @csrf
                <input type="hidden" name="_method" value="PATCH">
            </form>
    </div>
</div>

@endsection
@push('script')
<script>
const form = document.querySelector('form#updateWbs');

var data = {
    project_start_date : @json($wbs->project->planned_start_date),
    project_end_date : @json($wbs->project->planned_end_date),
    rawPlannedDeadline : @json($wbs->planned_end_date),
    editWbs : {
        wbs_id: @json($wbs->id),
        code: @json($wbs->code),
        number : @json($wbs->number),
        description : @json($wbs->description),
        deliverables : @json($wbs->deliverables),
        project_id : @json($wbs->project->id),
        project : @json($wbs->project),
        projectText : @json($wbs->project->number)+" - "+@json($wbs->project->name),
        weight : @json($wbs->weight),
        parent_wbs : @json($wbs->wbs),
        planned_start_date : @json($wbs->planned_start_date).split("-").reverse().join("-"),
        planned_end_date : @json($wbs->planned_end_date).split("-").reverse().join("-"),
        planned_duration : @json($wbs->planned_duration),
    },
    wbsDisplay : {
        wbs_id: @json($wbs->id),
        code: @json($wbs->code),
        number : @json($wbs->number),
        description : @json($wbs->description),
        deliverables : @json($wbs->deliverables),
        projectText : @json($wbs->project->number)+" - "+@json($wbs->project->name),
        weight : @json($wbs->weight),
        parent_wbs : @json($wbs->wbs),
        planned_start_date : @json($wbs->planned_start_date).split("-").reverse().join("-"),
        planned_end_date : @json($wbs->planned_end_date).split("-").reverse().join("-"),
        planned_duration : @json($wbs->planned_duration),
    },
    maxWeight : 0,
    totalWeight : 0,
    constWeightWbs : @json($wbs->weight),
};

Vue.directive('tooltip', function(el, binding){
    $(el).tooltip({
        title: binding.value,
        placement: binding.arg,
        trigger: 'hover'             
    })
})

var vm = new Vue({
    el: '#edit',
    data: data,
    mounted() {
        $('.datepicker').datepicker({
            autoclose : true,
            format : "dd-mm-yyyy"
        });

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
        updateOk: function(){
            let isOk = false;
                if(this.editWbs.number == ""
                || this.editWbs.description == ""
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

    }, 
    methods:{
        tooltipText: function(text) {
            return text
        },
        update(){            
            var editWbs = this.editWbs;
            editWbs = JSON.stringify(editWbs);
            $('div.overlay').show();            
            let struturesElem = document.createElement('input');
            struturesElem.setAttribute('type', 'hidden');
            struturesElem.setAttribute('name', 'datas');
            struturesElem.setAttribute('value', editWbs);
            form.appendChild(struturesElem);
            form.submit();
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
    watch : {
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
        'editWbs.planned_start_date': function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();

            var planned_start_date = new Date(newValue.split("-").reverse().join("-")+" 00:00:00");
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);
            if(this.editWbs.parent_wbs != null){
                var parent_wbs_start_date = new Date(this.parent_wbs_start_date).toDateString();
                var parent_wbs_end_date = new Date(this.parent_wbs_end_date).toDateString();
                var parent_wbs_start_date = new Date(parent_wbs_start_date);
                var parent_wbs_end_date = new Date(parent_wbs_end_date);
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
        'editWbs.planned_end_date': function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();

            var planned_end_date = new Date(newValue.split("-").reverse().join("-")+" 00:00:00");
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);
            if(this.editWbs.parent_wbs != null){
                var parent_wbs_start_date = new Date(this.parent_wbs_start_date).toDateString();
                var parent_wbs_end_date = new Date(this.parent_wbs_end_date).toDateString();
                var parent_wbs_start_date = new Date(parent_wbs_start_date);
                var parent_wbs_end_date = new Date(parent_wbs_end_date);
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
        'editWbs.weight': function(newValue){
            var maxWeightEdit = 0;
            this.editWbs.weight = (this.editWbs.weight+"").replace(/[^0-9.]/g, "");
            if(this.editWbs.parent_wbs != null){
                window.axios.get('/api/getWeightWbs/'+this.editWbs.parent_wbs.id).then(({ data }) => {
                    this.totalWeight = data;
                    var totalEdit = roundNumber(data - this.constWeightWbs,2);
                    maxWeightEdit = roundNumber(this.editWbs.parent_wbs.weight - totalEdit,2); 
                    if(this.editWbs.weight>maxWeightEdit){
                        iziToast.warning({
                            displayMode: 'replace',
                            title: 'Total weight cannot exceed '+this.editWbs.parent_wbs.weight+'%',
                            position: 'topRight',
                        });
                    }
                });
            }else{
                window.axios.get('/api/getWeightProject/'+this.editWbs.project_id).then(({ data }) => {
                    this.totalWeight = data;
                    var totalEdit = roundNumber(data - this.constWeightWbs,2);
                    maxWeightEdit = roundNumber(100 - totalEdit,2); 
                    if(this.editWbs.weight>maxWeightEdit){
                        iziToast.warning({
                            displayMode: 'replace',
                            title: 'Total weight cannot exceed 100%',
                            position: 'topRight',
                        });
                    }
                });
            }          
        },
    },
    created: function(){
        if(this.editWbs.parent_wbs != null){
            window.axios.get('/api/getWeightWbs/'+this.editWbs.parent_wbs.id).then(({ data }) => {
                this.totalWeight = data;
                $('#edit_planned_deadline').datepicker('setDate', new Date(this.rawPlannedDeadline));
            });
            var maxWeightEdit = roundNumber(this.editWbs.parent_wbs.weight - roundNumber(this.totalWeight,2),2);            
        }else{
            window.axios.get('/api/getWeightProject/'+this.editWbs.project_id).then(({ data }) => {
                this.totalWeight = data;
                $('#edit_planned_deadline').datepicker('setDate', new Date(this.rawPlannedDeadline));
            });
            var maxWeightEdit = roundNumber(100 - roundNumber(this.totalWeight,2),2);            

        }
        $('div.overlay').hide();
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