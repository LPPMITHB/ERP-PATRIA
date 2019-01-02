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
                                    <td>Name</td>
                                    <td>{{ wbsDisplay.name }}</td>
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
                                    <td v-if="wbsDisplay.wbs != null">{{ wbsDisplay.parent_wbs.code+" - "+wbsDisplay.parent_wbs.name }}</td>
                                    <td v-else>-</td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Planned Deadline</td>
                                    <td>{{ wbsDisplay.planned_deadline }}</td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Actual Deadline</td>
                                    <td v-if="wbsDisplay.actual_deadline != null">{{ wbsDisplay.actual_deadline }}</td>
                                    <td v-else>-</td>
                                </tr>
        
                                <tr>
                                    <td>9</td>
                                    <td>Progress</td>
                                    <td>{{ wbsDisplay.progress }} %</td>
                                </tr>
        
                                <tr>
                                    <td>9</td>
                                    <td>Weight</td>
                                    <td>{{ wbsDisplay.weight }} %</td>
                                </tr>
                                <tr>
                                    <td >10</td>
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
    rawPlannedDeadline : @json($wbs->planned_deadline),
    editWbs : {
        wbs_id: @json($wbs->id),
        code: @json($wbs->code),
        name : @json($wbs->name),
        description : @json($wbs->description),
        deliverables : @json($wbs->deliverables),
        planned_deadline : "",
        project_id : @json($wbs->project->id),
        project : @json($wbs->project),
        projectText : @json($wbs->project->number)+" - "+@json($wbs->project->name),
        weight : @json($wbs->weight),
        parent_wbs : @json($wbs->wbs),
    },
    wbsDisplay : {
        wbs_id: @json($wbs->id),
        code: @json($wbs->code),
        name : @json($wbs->name),
        description : @json($wbs->description),
        deliverables : @json($wbs->deliverables),
        planned_deadline : @json($wbs->planned_deadline),
        projectText : @json($wbs->project->number)+" - "+@json($wbs->project->name),
        weight : @json($wbs->weight),
        parent_wbs : @json($wbs->wbs),
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
        });
        $("#edit_planned_deadline").datepicker().on(
            "changeDate", () => {
                this.editWbs.planned_deadline = $('#edit_planned_deadline').val();
            }
        );
    },
    computed:{
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
    },
    watch : {
        'editWbs.planned_deadline': function(newValue){
            var pro_planned_start_date = new Date(this.project_start_date).toDateString();
            var pro_planned_end_date = new Date(this.project_end_date).toDateString();
            
            var deadline = new Date(newValue);
            var pro_planned_start_date = new Date(pro_planned_start_date);
            var pro_planned_end_date = new Date(pro_planned_end_date);
            if(this.editWbs.parent_wbs != null){
                var editWbs_planned_deadline = new Date(this.editWbs.parent_wbs.planned_deadline).toDateString();
                var editWbs_planned_deadline = new Date(editWbs_planned_deadline);
                if(deadline > editWbs_planned_deadline){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: "Your deadline is after parent WBS deadline",
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