@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Resources Schedule',
        'items' => [
            'Dashboard' => route('index'),
            'Resources Schedule' => '',
        ]
    ]
)
@endbreadcrumb
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @verbatim
                    <div id="vue">
                        <div class="col-sm-12 p-l-0 p-b-10">
                            <div class="col-sm-4 col-xs-12 p-l-5">
                                <label for="">Resource</label>
                                <selectize v-model="dataInput.resource_id" :settings="resourceSettings">
                                    <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                </selectize>
                            </div>
                            <div class="col-sm-4 col-xs-12">
                                <label for="">Resource Detail</label>
                                <selectize v-model="dataInput.resource_detail_id" :settings="resourceDetailSettings" :disabled="resourceOk">
                                    <option v-for="(rd, index) in selectedRD" :value="rd.id">{{ rd.code }} - {{ rd.serial_number }}</option>
                                </selectize>
                            </div>
                        </div>
                        <div id="calendar" v-show="dataInput.resource_id != '' && dataInput.resource_detail_id != ''">
                
                        </div>

                        <div class="modal fade" id="detail_event">
                            <div class="modal-dialog modalNotif">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <b>Start</b><h5 class="modal-title" id="modal_start_date"></h5>
                                        <b>End</b><h5 class="modal-title" id="modal_end_date"></h5>
                                    </div>
                                    <div class="modal-body p-t-5 p-b-5">
                                        <div class="row p-l-10 p-r-10">
                                            <label class="control-label">Project Number</label>
                                            <input type="text" name="project" id="project" class="form-control" disabled/>

                                            <label class="control-label">WBS</label>
                                            <input type="text" name="wbs" id="wbs" class="form-control" disabled/>

                                            <label class="control-label">Booked By</label>
                                            <input type="text" name="booked_by" id="booked_by" class="form-control" disabled/>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">CLOSE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endverbatim
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
        events : [],
        resources : @json($resources),
        resourceDetail : @json($resourceDetail),
        selectedRD : [],
        dataInput: {
            resource_id : "",
            resource_detail_id : ""
        },
        resourceSettings: {
            placeholder: 'Please Select Resource'
        },
        resourceDetailSettings: {
            placeholder: 'Please Select Resource Detail'
        },
        days : ["Sun", "Mon", "Tues", "Wed", "Thurs", "Fri", "Sat"],
        months : ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "August", "Sept", "Oct", "Nov", "Dec"],
    }

    var vm = new Vue({
        el : '#vue',
        data : data,
        computed: {
            resourceOk: function(){
                let isOk = false;

                if(this.dataInput.resource_id == ""){
                    isOk = true;
                }

                return isOk;
            }
        },
        methods: {
            buildingDate(date){
                let day_start = this.days[date.getDay()];
                let date_start = date.getDate();
                let month_start = this.months[date.getMonth()];
                let year_start = date.getFullYear();
                let time_start = date.toLocaleTimeString();

                let result = day_start + ", " + date_start + " " + month_start + " " + year_start + " - " + time_start; 
                return result;
            },
            destroyFullCalendar(){
                $('#calendar').fullCalendar('destroy');
            },
            buildFullCalendar(){
                $('#calendar').fullCalendar({
                    events : this.events,
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
                        right: 'month,agendaWeek,agendaDay'
                    },
                    defaultView: 'agendaWeek',
                    eventClick: function (calEvent, jsEvent, view) {
                        if(calEvent.clickable == true){
                            document.getElementById('modal_start_date').innerHTML =  calEvent.start_date;        
                            document.getElementById('modal_end_date').innerHTML =  calEvent.end_date;        
                            document.getElementById('project').value =  calEvent.project;     
                            document.getElementById('wbs').value =  calEvent.wbs;     
                            document.getElementById('booked_by').value =  calEvent.booked_by;     
                            $('#detail_event').modal();
                        }
                    },
                });
            }
        },
        watch: {
            'dataInput.resource_id' : function(newValue){
                if(newValue != ''){
                    this.selectedRD = [];
                    this.resourceDetail.forEach(RD => {
                        if(RD.resource_id == newValue){
                            this.selectedRD.push(RD);
                        }  
                    });
                }else{
                    this.dataInput.resource_detail_id = "";
                }
            },
            'dataInput.resource_detail_id' : function(newValue){
                if(newValue != ''){
                    $('div.overlay').show();
                    this.destroyFullCalendar();
                    this.events = [];
                    window.axios.get('/api/getSchedule/'+newValue).then(({ data }) => {
                        data.forEach(TR =>{
                            let start_date = new Date((TR.start_date+"").replace(/-/g,"/"));
                            let end_date = new Date((TR.end_date+"").replace(/-/g,"/"));
                            
                            if(TR.project != null || TR.wbs != null){
                            this.events.push({
                                title: "Project: "+TR.project.number + " \n WBS: "+ TR.wbs.number+" - "+TR.wbs.description,
                                wbs: TR.wbs.number+" - "+TR.wbs.description,
                                project: TR.project.number,
                                start: TR.start_date,
                                end: TR.end_date,
                                booked_by : TR.user.name,
                                start_date : this.buildingDate(start_date),
                                end_date : this.buildingDate(end_date),
                                clickable : true,
                                color : '#007bff',
                                textColor : 'black',
                            })
                            }else{
                            this.events.push({
                                start: TR.start_date,
                                end: TR.end_date,
                                booked_by : TR.user.name,
                                start_date : this.buildingDate(start_date),
                                end_date : this.buildingDate(end_date),
                                clickable : true,
                                color : '#007bff',
                                textColor : 'black',
                            })
                            }
                        });
                        this.buildFullCalendar();
                        $('div.overlay').hide();
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again..',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        console.log(error);
                        $('div.overlay').hide();
                    })
                    console.log(this.events);
                }
            }
        },
    });
</script>
@endpush