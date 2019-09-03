@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Yard Plans',
        'items' => [
            'Dashboard' => route('index'),
            'View All Yards' => route('yard.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <form id="create-yardPlan" class="form-horizontal" method="POST" action="{{ route('yard_plan.store') }}">
        @csrf
    </form>

    <form id="edit-yardPlan" class="form-horizontal" method="POST">
        @csrf
        <input type="hidden" name="_method" value="PATCH">
    </form>
    
    <form id="delete-yardPlan" class="form-horizontal" method="POST">
        @csrf
        <input type="hidden" name="_method" value="DELETE" />
    </form>

    <div class="col-xs-12">
        <div class="box">
            {{-- <div class="box-header m-b-10">
                    <div class="box-tools pull-right p-t-5">
                        <a href="{{ route('yard.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                    </div>
            </div> <!-- /.box-header --> --}}
            <div class="box-body">
                <div id="calendar">
        
                </div>
            </div> <!-- /.box-body -->
            @verbatim
            <div id="yard_plan">
                <div class="modal fade" id="add_yard_plan">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">Create Yard Plan</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row form-group">
                                    <div class="col-sm-4">
                                        <label for="planned_end_date" class="control-label">Start Date</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input autocomplete="off" type="text" v-model="yardPlan.planned_start_date"  class="form-control datepicker" id="planned_start_date" placeholder="Insert Start Date here...">                                                                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="planned_end_date" class="control-label">End Date</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input autocomplete="off" type="text" v-model="yardPlan.planned_end_date" class="form-control datepicker" id="planned_end_date" placeholder="Insert End Date here...">                                                                                            
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="duration" class=" control-label">Duration</label>
                                        <input @keyup="setEndDateNew" @change="setEndDateNew" v-model="yardPlan.planned_duration"  type="number" class="form-control" id="edit_duration" placeholder="Duration" >                                        
                                    </div>
                                </div>
                                
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="yard" class="control-label">Yard</label>
                                        <selectize id="yard" v-model="yardPlan.yard_id" :settings="yardSettings">
                                            <option v-for="(yard, index) in modelYard" :value="yard.id">{{ yard.code }} - {{ yard.name }}</option>
                                        </selectize>
                                    </div>
                                </div>

                            
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="project" class="control-label">Project</label>
                                        <selectize id="project" v-model="yardPlan.project_id" :settings="projectSettings">
                                            <option v-for="(project, index) in modelProject" :value="project.id">{{ project.number }} - {{ project.name }}</option>
                                        </selectize>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="wbs" class="control-label">WBS</label>
                                        <div v-show="yardPlan.project_id == ''">
                                            <selectize disabled v-model="yardPlan.wbs_id" :settings="projectEmptySettings">
                                            </selectize>
                                        </div>
                                        <div v-show="modelWbs.length == 0 && yardPlan.project_id != ''">
                                            <selectize disabled v-model="yardPlan.wbs_id" :settings="wbsNullSettings">
                                            </selectize>
                                        </div>
                                        <div v-show="modelWbs.length > 0 && yardPlan.project_id != ''">
                                            <selectize id="wbs" v-model="yardPlan.wbs_id" :settings="wbsSettings">
                                                <option v-for="(wbs, index) in modelWbs" :value="wbs.id">{{ wbs.number }} - {{ wbs.description }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="wbs" class="control-label">Description</label>
                                        <textarea v-model="yardPlan.description" class="form-control" rows="3" name="description"></textarea>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="modal-footer">
                                <button :disabled="createOk" @click="submitForm" type="button" class="btn btn-primary" data-dismiss="modal">CREATE</button>
                            </div>    
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="edit_yard_plan">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">Edit Yard Plan</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row form-group">
                                    <div class="col-sm-4">
                                        <label for="planned_end_date" class="control-label">Start Date</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input autocomplete="off" type="text" v-model="editYardPlan.planned_start_date"  class="form-control datepicker" id="edit_planned_start_date" placeholder="Insert Start Date here...">                                                                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="planned_end_date" class="control-label">End Date</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input autocomplete="off" type="text" v-model="editYardPlan.planned_end_date" class="form-control datepicker" id="edit_planned_end_date" placeholder="Insert End Date here...">                                                                                            
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-4">
                                        <label for="duration" class=" control-label">Duration</label>
                                        <input @keyup="setEndDateEdit" @change="setEndDateEdit" v-model="editYardPlan.planned_duration"  type="number" class="form-control" id="edit_duration" placeholder="Duration" >                                        
                                    </div>
                                </div>
                                
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="yard" class="control-label">Yard</label>
                                        <selectize id="yard" v-model="editYardPlan.yard_id" :settings="yardSettings">
                                            <option v-for="(yard, index) in modelYard" :value="yard.id">{{ yard.code }} - {{ yard.name }}</option>
                                        </selectize>
                                    </div>
                                </div>

                            
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="project" class="control-label">Project</label>
                                        <selectize id="project" v-model="editYardPlan.project_id" :settings="projectSettings">
                                            <option v-for="(project, index) in modelProject" :value="project.id">{{ project.number }} - {{ project.name }}</option>
                                        </selectize>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="wbs" class="control-label">WBS</label>
                                        <div v-show="editYardPlan.project_id == ''">
                                            <selectize disabled v-model="editYardPlan.wbs_id" :settings="projectEmptySettings">
                                            </selectize>
                                        </div>
                                        <div v-show="modelWbsEdit.length == 0 && editYardPlan.project_id != ''">
                                            <selectize disabled v-model="editYardPlan.wbs_id" :settings="wbsNullSettings">
                                            </selectize>
                                        </div>
                                        <div v-show="modelWbsEdit.length > 0 && editYardPlan.project_id != ''">
                                            <selectize id="wbs" v-model="editYardPlan.wbs_id" :settings="wbsSettings">
                                                <option v-for="(wbs, index) in modelWbsEdit" :value="wbs.id">{{ wbs.number }} - {{ wbs.description }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="wbs" class="control-label">Description</label>
                                        <textarea v-model="editYardPlan.description" class="form-control" rows="3" name="description"></textarea>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-danger pull-left" type="button" @click="deleteYardPlan(editYardPlan)" data-toggle="modal">
                                    DELETE
                                </button>
                                <button :disabled="editOk" @click="submitFormEdit()" type="button" class="btn btn-primary" data-dismiss="modal">SAVE</button>
                            </div>    
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
            @endverbatim
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    const formCreate = document.querySelector('form#create-yardPlan');
    const formEdit = document.querySelector('form#edit-yardPlan');
    const formDelete = document.querySelector('form#delete-yardPlan');
    var yardPlan = {!!$yardPlan!!};

    var data = {
        modelYard :   @json($modelYard),
        modelProject : @json($modelProject),
        modelWbs : [],
        modelWbsEdit : [],
        yardPlan :{
            planned_start_date : "",
            planned_end_date : "",
            yard_id : "", 
            project_id : "",
            wbs_id : "",
            description : "",
        },
        editYardPlan :{
            id: "",
            planned_start_date : "",
            planned_end_date : "",
            yard_id : "", 
            project_id : "",
            wbs_id : "",
            description : "",
        },
        projectSettings: {
            placeholder: 'Please select project!',
        },
        projectNullSettings: {
            placeholder: 'There are no project!',
        },
        yardSettings: {
            placeholder: 'Please select yard!',
        },
        wbsSettings: {
            placeholder: 'Please select wbs!',
        },
        wbsNullSettings:{
            placeholder: "Project doesn't have WBS!"
        },
        projectEmptySettings:{
            placeholder: "Please select project first!"
        },
    }

    var vm = new Vue({
        el : '#yard_plan',
        data : data,
        mounted() {
            $('.datepicker').datepicker({
                autoclose : true,
                format : "dd-mm-yyyy"
            });
            $("#planned_start_date").datepicker().on(
                "changeDate", () => {
                    this.yardPlan.planned_start_date = $('#planned_start_date').val();
                    if(this.yardPlan.planned_end_date != ""){
                        this.yardPlan.planned_duration = datediff(parseDate(this.yardPlan.planned_start_date), parseDate(this.yardPlan.planned_end_date));
                    }
                    this.setEndDateNew();
                }
            );
            $("#planned_end_date").datepicker().on(
                "changeDate", () => {
                    this.yardPlan.planned_end_date = $('#planned_end_date').val();
                    if(this.yardPlan.planned_start_date != ""){
                        this.yardPlan.planned_duration = datediff(parseDate(this.yardPlan.planned_start_date), parseDate(this.yardPlan.planned_end_date));
                    }
                }
            );

            $("#edit_planned_start_date").datepicker().on(
                "changeDate", () => {
                    this.editYardPlan.planned_start_date = $('#edit_planned_start_date').val();
                    if(this.editYardPlan.planned_end_date != ""){
                        this.editYardPlan.planned_duration = datediff(parseDate(this.editYardPlan.planned_start_date), parseDate(this.editYardPlan.planned_end_date));
                    }
                    this.setEndDateNew();
                }
            );
            $("#edit_planned_end_date").datepicker().on(
                "changeDate", () => {
                    this.editYardPlan.planned_end_date = $('#edit_planned_end_date').val();
                    if(this.editYardPlan.planned_start_date != ""){
                        this.editYardPlan.planned_duration = datediff(parseDate(this.editYardPlan.planned_start_date), parseDate(this.editYardPlan.planned_end_date));
                    }
                }
            );
        },
        computed : {
            createOk: function(){
                let isOk = false;
                    if(this.yardPlan.yard_id == ""
                    || this.yardPlan.project_id == ""
                    || this.yardPlan.planned_start_date == ""
                    || this.yardPlan.planned_end_date == "")
                    {
                        isOk = true;
                    }
                return isOk;
            },
            editOk: function(){
                let isOk = false;
                    if(this.editYardPlan.yard_id == ""
                    || this.editYardPlan.project_id == ""
                    || this.editYardPlan.planned_start_date == ""
                    || this.editYardPlan.planned_end_date == "")
                    {
                        isOk = true;
                    }
                return isOk;
            },
        },
        methods : {
            submitForm(){
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.yardPlan));
                formCreate.appendChild(struturesElem);
                formCreate.submit();
            },
            submitFormEdit(){
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.editYardPlan));
                formEdit.appendChild(struturesElem);
                formEdit.submit();
            },
            setEndDateNew(){
                if(this.yardPlan.planned_duration != "" && this.yardPlan.planned_start_date != ""){
                    var planned_duration = parseInt(this.yardPlan.planned_duration);
                    var planned_start_date = this.yardPlan.planned_start_date;
                    var planned_end_date = new Date(planned_start_date.split("-").reverse().join("-"));
                    
                    planned_end_date.setDate(planned_end_date.getDate() + planned_duration-1);
                    $('#planned_end_date').datepicker('setDate', planned_end_date);
                }else{
                    this.yardPlan.planned_end_date = "";
                }
            },
            setEndDateEdit(){
                if(this.editYardPlan.planned_duration != "" && this.editYardPlan.planned_start_date != ""){
                    var planned_duration = parseInt(this.editYardPlan.planned_duration);
                    var planned_start_date = this.editYardPlan.planned_start_date;
                    var planned_end_date = new Date(planned_start_date.split("-").reverse().join("-"));
                    
                    planned_end_date.setDate(planned_end_date.getDate() + planned_duration-1);
                    $('#edit_planned_end_date').datepicker('setDate', planned_end_date);
                }else{
                    this.editYardPlan.planned_end_date = "";
                }
            },
            deleteYardPlan(data){
                var menuTemp = this.menu;
                iziToast.question({
                    close: false,
                    overlay: true,
                    timeout : 0,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirm',
                    message: 'Are you sure you want to delete this Yard Plan?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            var url = "/yard_plan/"+data.id;
                            
                            $('div.overlay').show();            
                            document.getElementById("delete-yardPlan").action = "/yard_plan/"+data.id;
                            formDelete.submit();

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                
                        }],
                    ],
                });
            },
        },
        watch : {
            'yardPlan.project_id' : function(newValue){
                this.yardPlan.wbs_id = "";
                this.modelWbs = [];
                if(newValue != ""){
                    window.axios.get('/api/getWbs/'+newValue).then(({ data }) => {
                        this.modelWbs = data;
                        $('div.overlay').hide();
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again.. ('+error+')',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })
                }
            },
            'editYardPlan.project_id' : function(newValue){
                this.editYardPlan.wbs_id = "";
                this.modelWbsEdit = [];
                if(newValue != ""){
                    window.axios.get('/api/getWbs/'+newValue).then(({ data }) => {
                        this.modelWbsEdit = data;
                        $('div.overlay').hide();
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again.. ('+error+')',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })
                }
            },
            yardPlan:{
                handler: function(newValue) {
                    this.yardPlan.planned_duration = newValue.planned_duration+"".replace(/\D/g, "");
                    if(parseInt(newValue.planned_duration) < 1 ){
                        iziToast.warning({
                            displayMode: 'replace',
                            title: 'End Date cannot be ahead Start Date',
                            position: 'topRight',
                        });
                        this.yardPlan.planned_duration = "";
                        this.yardPlan.planned_end_date = "";
                    }
                },
                deep: true
            },
            editYardPlan:{
                handler: function(newValue) {
                    this.editYardPlan.planned_duration = newValue.planned_duration+"".replace(/\D/g, "");
                    if(parseInt(newValue.planned_duration) < 1 ){
                        iziToast.warning({
                            displayMode: 'replace',
                            title: 'End Date cannot be ahead Start Date',
                            position: 'topRight',
                        });
                        this.editYardPlan.planned_duration = "";
                        this.editYardPlan.planned_end_date = "";
                    }
                },
                deep: true
            },
        },
    });

    var events = [];
    for(var i =0; i < yardPlan.length; i++) 
    {
        events.push( 
            {
                id : yardPlan[i].id,
                title: yardPlan[i].yard.name+" - "+yardPlan[i].project.name+" ("+yardPlan[i].project.number+") - "+yardPlan[i].description, 
                start: yardPlan[i].planned_start_date,
                end: yardPlan[i].planned_end_date,
                planned_duration : yardPlan[i].planned_duration,
                project_id : yardPlan[i].project_id,
                wbs_id : yardPlan[i].wbs_id,
                yard_id : yardPlan[i].yard_id,
                description : yardPlan[i].description,
                clickable : true,
                textColor : 'white',
            }
        )
    }

    $(document).ready(function(){ 
        $('div.overlay').hide();    
        $('#calendar').fullCalendar({
            events : events,
            eventRender: function(eventObj, $el) {
                $($el).css("font-weight", "bold");
                $el.tooltip({
                    title: eventObj.title,
                    trigger: 'hover',
                    placement: 'top',
                    container: 'body',
                });
            },
            aspectRatio:  2,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            //Set day biar bisa diklik
            dayClick: function(date, jsEvent, view, resourceObj) {
                $('#add_yard_plan').modal('show');
                console.log(date);
                $('#planned_start_date').datepicker('setDate', new Date(date.format('DD-MM-YYYY').split("-").reverse().join("-")));
                document.getElementById('planned_start_date').disabled = true;

                document.getElementById('planned_end_date').value = "";
            },
            eventClick: function (calEvent, jsEvent, view) {
                if(calEvent.clickable == true){
                    $('#edit_yard_plan').modal('show');
                    vm.editYardPlan.id = calEvent.id;
                    $('#edit_planned_start_date').datepicker('setDate', new Date(calEvent.start.format('DD-MM-YYYY').split("-").reverse().join("-")));
                    $('#edit_planned_end_date').datepicker('setDate', new Date(calEvent.end.format('DD-MM-YYYY').split("-").reverse().join("-")));
                    
                    vm.editYardPlan.yard_id = calEvent.yard_id;
                    vm.editYardPlan.project_id = calEvent.project_id;
                    if(calEvent.wbs_id != ""){
                        vm.editYardPlan.wbs_id = calEvent.wbs_id;
                    }
                    vm.editYardPlan.description = calEvent.description;
                    document.getElementById("edit-yardPlan").action = "/yard_plan/"+calEvent.id;
                }
            },
        }); 
        function eventRenderCallback(event, element, view){
            var title = element.find(".fc-title").val();
            element.find(".fc-title").html("<b>"+title+"</b>");
        }   
    });

    
    function parseDate(str) {
        var mdy = str.split('-');
        var date = new Date(mdy[2], mdy[1]-1, mdy[0]);
        return date;
    }

    //Additional Function
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
