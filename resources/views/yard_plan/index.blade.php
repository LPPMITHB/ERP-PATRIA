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
                                <div class="col-sm-6">
                                    <label for="planned_end_date" class="control-label">Start Date</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input autocomplete="off" type="text"  class="form-control datepicker" id="planned_start_date" placeholder="Insert Start Date here...">                                                                                            
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="planned_end_date" class="control-label">End Date</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input autocomplete="off" type="text" class="form-control datepicker" id="planned_end_date" placeholder="Insert End Date here...">                                                                                            
                                    </div>
                                </div>
                            </div>
                            @verbatim
                            <div id="project_work">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="yard" class="control-label">Yard</label>
                                        <selectize id="yard" v-model="submittedForm.yard_id" :settings="yardSettings">
                                            <option v-for="(yard, index) in modelYard" :value="yard.id">{{ yard.code }}-{{ yard.name }}</option>
                                        </selectize>
                                    </div>
                                </div>

                            
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="project" class="control-label">Project</label>
                                        <selectize id="project" v-model="submittedForm.project_id" :settings="projectSettings">
                                            <option v-for="(project, index) in modelProject" :value="project.id">{{ project.code }}-{{ project.name }}</option>
                                        </selectize>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="work" class="control-label">Work</label>
                                        <selectize id="work" v-model="submittedForm.wbs_id" :settings="workSettings">
                                            <option v-for="(work, index) in modelWork" :value="work.id">{{ work.code }}-{{ work.name }}</option>
                                        </selectize>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="work" class="control-label">Description</label>
                                        <textarea v-model="submittedForm.description" class="form-control" rows="3" name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                            @endverbatim
                        </div>

                        <div class="modal-footer">
                            <button onclick="submit()" type="button" class="btn btn-primary" data-dismiss="modal">CREATE</button>
                        </div>    
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <form id="create-yardPlan" class="form-horizontal" method="POST" action="{{ route('yard_plan.store') }}">
                @csrf
            </form>
            
            <form id="confirm-yardPlan" class="form-horizontal" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" value="PATCH">
                <div class="modal fade" id="confirm_actual">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">Confirm Actual Yard Plan</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row form-group">
                                    <div class="col-sm-6">
                                        <label for="actual_end_date" class="control-label">Actual Start Date</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input autocomplete="off" type="text"  class="form-control datepicker" name="actual_start_date" id="actual_start_date" placeholder="Insert Start Date here...">                                                                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="actual_end_date" class="control-label">Actual End Date</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input autocomplete="off" type="text" class="form-control datepicker" name="actual_end_date" id="actual_end_date" placeholder="Insert End Date here...">                                                                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button onclick="submitActual()" type="submit" class="btn btn-primary" data-dismiss="modal">SAVE</button>
                            </div>    
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </form>
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
    const formConfirm = document.querySelector('form#confirm-yardPlan');
    var yardPlan = {!!$yardPlan!!};

    var events = [];
    for(var i =0; i < yardPlan.length; i++) 
    {
        events.push( 
            {
                id : yardPlan[i].id,
                title: yardPlan[i].yard.name+" - "+yardPlan[i].project.name+" ("+yardPlan[i].project.code+")", 
                start: yardPlan[i].planned_start_date,
                end: yardPlan[i].planned_end_date,
                actual_start : yardPlan[i].actual_start_date,
                actual_end : yardPlan[i].actual_end_date,
                clickable : true,
                textColor : 'black',
            }
        )
        if(yardPlan[i].actual_start_date != null && yardPlan[i].actual_end_date != null){
            if(yardPlan[i].actual_start_date > yardPlan[i].planned_start_date){
                events.push( 
                    {
                        title: "ACTUAL ALLOCATION for "+yardPlan[i].yard.name+" - "+yardPlan[i].project.name+" ("+yardPlan[i].project.code+")", 
                        start: yardPlan[i].actual_start_date,
                        end: yardPlan[i].actual_end_date,
                        clickable : false,
                        color : '#CCCC00',
                        textColor : 'black',
                    }
                ) 
            } else if(yardPlan[i].actual_end_date > yardPlan[i].planned_end_date){
                events.push( 
                    {
                        title: "ACTUAL ALLOCATION for "+yardPlan[i].yard.name+" - "+yardPlan[i].project.name+" ("+yardPlan[i].project.code+")", 
                        start: yardPlan[i].actual_start_date,
                        end: yardPlan[i].actual_end_date,
                        clickable : false,
                        color : '#CCCC00',
                        textColor : 'black',
                    }
                ) 
            }else{
                events.push( 
                    {
                        title: "ACTUAL ALLOCATION for "+yardPlan[i].yard.name+" - "+yardPlan[i].project.name+" ("+yardPlan[i].project.code+")", 
                        start: yardPlan[i].actual_start_date,
                        end: yardPlan[i].actual_end_date,
                        clickable : false,
                        color : 'green',
                        textColor : 'black',
                    }
                ) 
            }
        }
    }

    $(document).ready(function(){  
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose : true,
        });
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
                document.getElementById('planned_start_date').value =  date.format('YYYY/MM/DD');         
                document.getElementById('planned_start_date').disabled = true;

                document.getElementById('planned_end_date').value = "";
            },
            eventClick: function (calEvent, jsEvent, view) {
                if(calEvent.clickable == true){
                    $('#confirm_actual').modal('show');
                    document.getElementById('actual_start_date').value =  calEvent.actual_start;        
                    document.getElementById('actual_end_date').value =  calEvent.actual_end;     
                    document.getElementById("confirm-yardPlan").action = "/yard_plan/confirmActual/"+calEvent.id;
                }
            },
        }); 
        function eventRenderCallback(event, element, view){
            var title = element.find(".fc-title").val();
            element.find(".fc-title").html("<b>"+title+"</b>");
        }   
    });

    

    var data = {
        modelYard :   @json($modelYard),
        modelProject : @json($modelProject),
        modelWork : [],
        submittedForm :{
            planned_start_date : "",
            planned_end_date : "",
            yard_id : "", 
            project_id : "",
            wbs_id : "",
            description : "",
        },
        projectSettings: {
            placeholder: 'Please select project...',
        },
        yardSettings: {
            placeholder: 'Please select yard...',
        },
        workSettings: {
            placeholder: 'Please select work...',
        },
    }

    var vm = new Vue({
        el : '#project_work',
        data : data,
        computed : {
           
        },
        methods : {
            submitForm(){
                var planned_start_date = document.getElementById('planned_start_date').value;
                var planned_end_date = document.getElementById('planned_end_date').value;

                this.submittedForm.planned_start_date = planned_start_date;
                this.submittedForm.planned_end_date = planned_end_date;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                formCreate.appendChild(struturesElem);
                formCreate.submit();
            }
        },
        watch : {
            'submittedForm.project_id' : function(newValue){
                this.submittedForm.wbs_id = "";
                window.axios.get('/api/getWork/'+newValue).then(({ data }) => {
                    this.modelWork = data;
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
        mounted: function(){
        }
    });

    function submit() {
        vm.submitForm();
    }

    function submitActual() {
        formConfirm.submit();
    }
</script>
@endpush
