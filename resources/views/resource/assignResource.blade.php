@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Assign Resources',
        'items' => [
            'Dashboard' => route('index'),
            'Assign Resources' => route('resource.assignResource'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 p-b-20">
        <div class="box">
            <div class="box-body">
                @csrf
                    @verbatim
                    <div id="assignRsc">
                        <div class="box-header no-padding">
                            <template v-if="selectedProject.length > 0">
                                <div class="col-xs-12 col-md-4">
                                    <div class="col-sm-12 no-padding"><b>Project Information</b></div>
            
                                    <div class="col-xs-5 no-padding">Project Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject[0].number}}</b></div>
                                    
                                    <div class="col-xs-5 no-padding">Ship Type</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject[0].ship.type}}</b></div>
            
                                    <div class="col-xs-5 no-padding">Customer</div>
                                    <div class="col-xs-7 no-padding tdEllipsis" v-tooltip:top="tooltip(selectedProject[0].customer.name)"><b>: {{selectedProject[0].customer.name}}</b></div>

                                    <div class="col-xs-5 no-padding">Start Date</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject[0].planned_start_date}}</b></div>

                                    <div class="col-xs-5 no-padding">End Date</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{selectedProject[0].planned_end_date}}</b></div>
                                </div>
                            </template>
                            <div class="col-xs-12 col-md-4">
                                <label for="" >Project Name</label>
                                <selectize v-model="project_id" :settings="projectSettings">
                                    <option v-for="(project, index) in projects" :value="project.id">{{ project.number }} - {{ project.name }}</option>
                                </selectize>  
                            </div>
                            <template v-if="selectedProject.length > 0">
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary pull-right" @click.prevent="openSchedule">RESOURCE SCHEDULE</button>
                                </div>
                            </template>
                        </div>
                        <template v-if="selectedProject.length > 0">
                            <div class="row">
                                <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                    <table id="assign-rsc" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th style="width: 15%">Category</th>
                                                <th style="width: 25%">Resource</th>
                                                <th style="width: 25%">Resource Detail</th>
                                                <th style="width: 10%">Quantity</th>
                                                <th style="width: 25%">WBS</th>
                                                <th style="width: 12%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data,index) in modelAssignResource">
                                                <td>{{ index + 1 }}</td>
                                                <td v-if="data.category_id == 0">SubCon</td>
                                                <td v-else-if="data.category_id == 1">Others</td>
                                                <td v-else-if="data.category_id == 2">External Equipment</td>
                                                <td v-else-if="data.category_id == 3">Internal Equipment</td>
                                                <td>{{ data.resource.code }} - {{ data.resource.name }}</td>
                                                <td v-if="data.resource_detail != null && data.resource_detail.serial_number == null || data.resource_detail != null && data.resource_detail.serial_number == ''">{{ data.resource_detail.code }}</td>
                                                <td v-else-if="data.resource_detail != null && data.resource_detail.serial_number != null && data.resource_detail.serial_number != ''">{{ data.resource_detail.code }} - {{ data.resource_detail.serial_number }}</td>
                                                <td v-else>-</td>
                                                <td>{{ data.quantity }}</td>
                                                <td>{{ data.wbs.number }} - {{ data.wbs.description }}</td>
                                                <td class="p-l-3 textCenter">
                                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(data,index)">
                                                        EDIT
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <td class="p-l-10">{{newIndex}}</td>
                                            <td class="p-l-0 textLeft">
                                                <selectize v-model="dataInput.category_id" :settings="categorySettings">
                                                    <option v-for="(category,index) in resource_categories" :value="category.id">{{ category.name }}</option>
                                                </selectize>
                                            </td>
                                            
                                            <td class="no-padding" v-show="dataInput.category_id == ''">
                                                <selectize id="material" v-model="dataInput.null" :settings="nullSettings" disabled>
                                                    <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="dataInput.category_id != ''">
                                                <selectize v-model="dataInput.resource_id" :settings="resourceSettings">
                                                    <option v-for="(resource,index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                </selectize>
                                            </td>
            
                                            <td class="no-padding" v-show="dataInput.category_id == 3 && dataInput.resource_id == '' || dataInput.category_id == '' && dataInput.resource_id == ''">
                                                <selectize id="material" v-model="dataInput.null" :settings="nullResourceSettings" disabled>
                                                    <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="no-padding" v-show="dataInput.category_id != 3 && dataInput.category_id != ''">
                                                <selectize id="material" v-model="dataInput.null" :settings="otherSettings" disabled>
                                                    <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="dataInput.category_id == 3 && dataInput.resource_id != '' && selectedRD.length < 1">
                                                <selectize v-model="dataInput.null" :settings="nullRdSettings" disabled>
                                                    <option v-for="(rd, index) in selectedRD" :value="rd.id">{{ rd.code }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textLeft" v-show="dataInput.category_id == 3 && dataInput.resource_id != '' && selectedRD.length > 0">
                                                <selectize v-model="dataInput.resource_detail_id" :settings="resourceDetailSettings">
                                                    <option v-for="(rd, index) in selectedRD" :value="rd.id">{{ rd.code }} - {{ rd.serial_number }}</option>
                                                </selectize>
                                            </td>
                                          
                                            <td class="p-l-0 textLeft">
                                                <input type="text" v-model="dataInput.quantity" class="form-control" placeholder="Please Input Quantity" :disabled='resourceDetail'>
                                            </td>
                                            <td class="p-l-0 textLeft">
                                                <selectize v-model="dataInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in modelWBS" :value="wbs.id">{{ wbs.number }} - {{ wbs.description }}</option>
                                                </selectize>
                                            </td>
                                            <td class="p-l-0 textCenter">
                                                <button :disabled="createOk" class="btn btn-primary btn-xs" data-toggle="modal" @click.prevent="inputSchedule">ADD</button>
                                            </td>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </template>

                        <div class="modal fade" id="edit_item">
                            <div class="modal-dialog ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Edit Assign Resource</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="control-label">Resource</label>
                                                <selectize v-model="editInput.resource_id" :settings="resourceSettings">
                                                    <option v-for="(resource,index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                </selectize>
                                            </div>
                                            <template v-if="editInput.category_id == 3">
                                                <div class="col-sm-12">
                                                    <label class="control-label">Resource Detail</label>
                                                    <selectize v-model="editInput.resource_detail_id" :settings="resourceDetailSettings">
                                                        <option v-for="(resource,index) in selectedRDModal" :value="resource.id">{{ resource.code }}</option>
                                                    </selectize>
                                                </div>
                                            </template>
                                            <div class="col-sm-12">
                                                <label class="control-label">WBS Name</label>
                                                <selectize v-model="editInput.wbs_id" :settings="wbsSettings">
                                                    <option v-for="(wbs, index) in modelWBS" :value="wbs.id">{{ wbs.number }} - {{ wbs.description }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label class="control-label">Quantity</label>
                                                <input type="text" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity" :disabled="editResource">
                                            </div>
                                            <div class="col-sm-12" v-show="editInput.category_id == 3 && editInput.resource_detail_id != '' && editInput.resource_detail_id != null">
                                                <label class="control-label">Schedule</label>
                                                <input type="text" name="daterangeModal" id="daterangeModal" class="form-control" placeholder="Please Input Schedule (Optional)" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" @click.prevent="update">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="input_schedule">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Input Schedule - Operation Hour : <b class="blink">{{operation_hours.start}} - {{operation_hours.end}}</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="control-label">Schedule</label>
                                                <input v-model="dataInput.schedule" type="text" name="daterange" id="daterange" class="form-control" placeholder="Please Input Schedule (Optional)" autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" @click.prevent="add">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="resource_schedule">
                            <div class="modal-dialog modalFull">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Internal Resource Schedule</h4>
                                    </div>
                                    <div class="modal-body p-t-5 p-b-5">
                                        <div class="row p-l-10 p-r-10">
                                            <div class="col-sm-12 p-l-0 p-b-10">
                                                <div class="col-sm-4 col-xs-12 p-l-5">
                                                    <label for="">Resource</label>
                                                    <selectize v-model="schedule.resource_id" :settings="resourceSettings">
                                                        <option v-for="(resource, index) in resources" :value="resource.id">{{ resource.code }} - {{ resource.name }}</option>
                                                    </selectize>
                                                </div>
                                                <div class="col-sm-4 col-xs-12">
                                                    <label for="">Resource Detail</label>
                                                    <selectize v-model="schedule.resource_detail_id" :settings="resourceDetailSettings" :disabled="resourceOk">
                                                        <option v-for="(rd, index) in schedule.selectedRD" :value="rd.id">{{ rd.code }} - {{ rd.serial_number }}</option>
                                                    </selectize>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="calendar" v-show="schedule.resource_id != '' && schedule.resource_detail_id != ''">
                                
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" aria-label="Close">CLOSE</button>
                                    </div>
                                </div>
                            </div>
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
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    const form = document.querySelector('form#assign-resource');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        route : @json($route),
        resources : @json($resources),
        resourceDetails : @json($resourceDetails),
        resource_categories : @json($resource_categories),
        operation_hours : @json($operation_hours[0]),
        projects : @json($modelProject),
        selectedProject : [],
        project_id : "",
        modelWBS : [],
        selectedRD : [],
        modelAssignResource : [],
        newIndex : "",
        dataInput : {
            resource_id :"",
            category_id :"",
            resource_detail_id :"",
            wbs_id : "",
            quantity : "",
            start : "",
            end : "",
            start_date : "",
            end_date : "",
        },
        editInput : {
            old_resource_id :"",
            resource_id :"",
            resource_detail_id :"",
            wbs_id : "",
            quantity : "",
            category_id : "",
            start : "",
            end : "",
            start_date : "",
            end_date : "",
        },
        projectSettings: {
            placeholder: 'Please Select Project'
        },
        resourceSettings: {
            placeholder: 'Please Select Resource'
        },
        wbsSettings: {
            placeholder: 'Please Select WBS'
        },
        categorySettings: {
            placeholder: 'Please Select Category'
        },
        resourceDetailSettings: {
            placeholder: 'Select Resource Detail (Optional)'
        },
        nullSettings: {
            placeholder: 'Please Select Category First'
        },
        nullResourceSettings: {
            placeholder: 'Please Select Resource First'
        },
        nullRdSettings: {
            placeholder: 'Resource Detail Not Available !'
        },
        otherSettings: {
            placeholder: '-'
        },
        schedule: {
            resource_id : "",
            resource_detail_id : "",
            selectedRD : [],
            events : [],
        },
        days : ["Sun", "Mon", "Tues", "Wed", "Thurs", "Fri", "Sat"],
        months : ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "August", "Sept", "Oct", "Nov", "Dec"],
        selectedRDModal : [],
    }

    var vm = new Vue({
        el : '#assignRsc',
        data : data,
        mounted() {
            $(function() {
                $('input[name="daterange"]').daterangepicker({
                    opens: 'left',
                    timePicker: true,
                    timePicker24Hour: true,
                    minDate: moment(),
                    timePickerIncrement: 30,
                    showDropdowns: true,
                    locale: {
                        timePicker24Hour: true,
                        format: 'DD-MM-YYYY hh:mm A'
                    },
                });
                $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                    vm.dataInput.start = picker.startDate.format('HH:mm');
                    vm.dataInput.end = picker.endDate.format('HH:mm');
                    vm.dataInput.datetime_start = picker.startDate.format('YYYY-MM-DD HH:mm');
                    vm.dataInput.datetime_end = picker.endDate.format('YYYY-MM-DD HH:mm');
                    vm.checkTime(vm.dataInput.start,vm.dataInput.end,vm.dataInput.datetime_start,vm.dataInput.datetime_end);
                });
                $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                    vm.dataInput.start = '';
                    vm.dataInput.end = '';
                    $('input[name="daterange"]').val('');
                });
            });

            
        },
        computed : {
            createOk: function(){
                let isOk = false;

                if(this.dataInput.resource_id == "" || this.dataInput.quantity == "" || this.dataInput.wbs_id == ""){
                    isOk = true;
                }

                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                if(this.editInput.resource_id == "" || this.editInput.quantity == "" || this.editInput.wbs_id == ""){
                    isOk = true;
                }

                return isOk;
            },
            resourceDetail : function(){
                let isOk = false;

                if(this.dataInput.resource_detail_id != ""){
                    isOk = true;
                }
                return isOk;
            },
            resourceOk: function(){
                let isOk = false;

                if(this.schedule.resource_id == ""){
                    isOk = true;
                }

                return isOk;
            },
            editResource: function(){
                let isOk = false;

                if(this.editInput.category_id == 3){
                    if(this.editInput.resource_detail_id != "" && this.editInput.resource_detail_id != null){
                        isOk = true;
                    }
                }

                return isOk;
            }
        },
        methods : {
            clearEditData(){
                this.editInput.old_resource_id ="";
                this.editInput.resource_id ="";
                this.editInput.resource_detail_id ="";
                this.editInput.wbs_id = "";
                this.editInput.quantity = "";
                this.editInput.category_id = "";
                this.editInput.start = '';
                this.editInput.end = '';
                this.editInput.start_date = '';
                this.editInput.end_date = '';
                this.editInput.datetime_start = '';
                this.editInput.datetime_end = '';
            },
            buildDateRangePicker(){
                $(function() {
                    let startDate = moment(vm.editInput.start_date).format('DD-MM-YYYY HH:mm');
                    let endDate = moment(vm.editInput.end_date).format('DD-MM-YYYY HH:mm');

                    if(startDate != "Invalid date"){
                        $('input[name="daterangeModal"]').daterangepicker({
                            startDate : startDate,
                            endDate: endDate,
                            opens: 'center',
                            timePicker: true,
                            timePicker24Hour: true,
                            timePickerIncrement: 30,
                            showDropdowns: true,
                            locale: {
                                timePicker24Hour: true,
                                format: 'DD-MM-YYYY hh:mm A'
                            },
                            drops: "up"
                        });
                    }else{
                        $('input[name="daterangeModal"]').daterangepicker({
                            autoUpdateInput: false,
                            opens: 'center',
                            timePicker: true,
                            timePicker24Hour: true,
                            minDate: moment(),
                            timePickerIncrement: 30,
                            showDropdowns: true,
                            locale: {
                                timePicker24Hour: true,
                                format: 'DD-MM-YYYY hh:mm A'
                            },
                            drops: "up"
                        });
                    }
                    $('input[name="daterangeModal"]').on('apply.daterangepicker', function(ev, picker) {
                        vm.editInput.start = picker.startDate.format('HH:mm');
                        vm.editInput.end = picker.endDate.format('HH:mm');
                        vm.editInput.datetime_start = picker.startDate.format('YYYY-MM-DD HH:mm');
                        vm.editInput.datetime_end = picker.endDate.format('YYYY-MM-DD HH:mm');
                        var validation = vm.checkTime(vm.editInput.start,vm.editInput.end,vm.editInput.datetime_start,vm.editInput.datetime_end);
                        if(validation === true){
                            $(this).val(picker.startDate.format('DD-MM-YYYY hh:mm A') + ' - ' + picker.endDate.format('DD-MM-YYYY hh:mm A'));
                        }
                    });
                    $('input[name="daterangeModal"]').on('cancel.daterangepicker', function(ev, picker) {
                        vm.editInput.start = '';
                        vm.editInput.end = '';
                        vm.editInput.start_date = '';
                        vm.editInput.end_date = '';
                        vm.editInput.datetime_start = '';
                        vm.editInput.datetime_end = '';
                        $('input[name="daterangeModal"]').val('');
                    });
                });
            },
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
                    events : this.schedule.events,
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
            },
            inputSchedule(){
                if(this.dataInput.category_id == 3 && this.dataInput.resource_detail_id != ""){
                    $('#input_schedule').modal();
                }else{
                    this.add();
                }
            },
            openSchedule(){
                this.schedule.resource_id = "";
                this.schedule.resource_detail_id = "";
                $('#resource_schedule').modal();
            },
            clearTime(){
                $('input[name="daterange"]').val('');
                $('input[name="daterangeModal"]').val('');
            },
            checkTime(start,end,datetime_start,datetime_end){
                let status = true;
                var operation_start = this.operation_hours.start;
                var operation_end = this.operation_hours.end;
                if(start < operation_start){
                    this.clearTime();
                    iziToast.warning({
                        displayMode: 'replace',
                        title: 'Start Time Cannot Less Than '+ operation_start,
                        position: 'topRight',
                    });
                    status = false;
                }else if(start > operation_end){
                    this.clearTime();
                    iziToast.warning({
                        displayMode: 'replace',
                        title: 'Start Time Cannot More Than '+ operation_end,
                        position: 'topRight',
                    });
                    status = false;
                }else if(end > operation_end){
                    this.clearTime();
                    iziToast.warning({
                        displayMode: 'replace',
                        title: 'End Time Cannot More Than '+ operation_end,
                        position: 'topRight',
                    });
                    status = false;
                }else if(end < operation_start){
                    this.clearTime();
                    iziToast.warning({
                        displayMode: 'replace',
                        title: 'End Time Cannot Less Than '+ operation_start,
                        position: 'topRight',
                    });
                    status = false;
                }
                if(status === true){
                    if(this.dataInput.start != "" && this.dataInput.end != ""){
                        this.dataInput.start_date = datetime_start;
                        this.dataInput.end_date = datetime_end;
                    }else if(this.editInput.start != "" && this.editInput.end != ""){
                        this.editInput.start_date = datetime_start;
                        this.editInput.end_date = datetime_end;
                    }
                }
                return status;
            },
            tooltip(text){
                Vue.directive('tooltip', function(el, binding){
                    $(el).tooltip('destroy');
                    $(el).tooltip({
                        title: text,
                        placement: binding.arg,
                        trigger: 'hover'             
                    })
                })
                return text
            },
            getResource(){
                window.axios.get('/api/getResourceTrx/' + this.project_id).then(({ data }) => {
                    this.modelAssignResource = data;
                    this.newIndex = Object.keys(this.modelAssignResource).length+1;
                });
            },
            add(){
                $('div.overlay').show();            

                let status = false;
                if(this.dataInput.category_id == 3){
                    let start_date = this.dataInput.start_date;
                    this.modelAssignResource.forEach(TrxResource =>{
                        if(start_date >= TrxResource.start_date && start_date < TrxResource.end_date){
                            status = true;
                        }
                    })
                    if(!status){
                        let end_date = this.dataInput.end_date;
                        this.modelAssignResource.forEach(TrxResource =>{
                            if(end_date >= TrxResource.start_date && end_date < TrxResource.end_date){
                                status = true;
                            }
                        })
                    }
                }
                if(status){
                    iziToast.warning({
                        title: 'The Selected Time Already Booked By Another WBS !.',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();            
                }else{
                    this.dataInput.project_id = this.project_id;
                    var dataInput = this.dataInput;
                    dataInput = JSON.stringify(dataInput);
                    if(this.route == "/resource"){
                        var url = "{{ route('resource.storeAssignResource') }}";
                    }else if(this.route == "/resource_repair"){
                        var url = "{{ route('resource_repair.storeAssignResource') }}";
                    }
                    window.axios.post(url,dataInput).then((response) => {
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
                        
                        this.getResource();
                        this.dataInput.resource_id = "";
                        this.dataInput.resource_detail_id = "";
                        this.dataInput.wbs_id = "";             
                        this.dataInput.quantity = ""; 
                        this.dataInput.category_id = ""; 
                        $('#input_schedule').modal('hide');
                    })
                    .catch((error) => {
                        console.log(error);
                        $('div.overlay').hide();            
                    })
                }
            },
            update(){
                $('div.overlay').show();   
                if($('input[name="daterangeModal"]').val() == "" || $('input[name="daterangeModal"]').val() == null){
                    this.editInput.start = '';
                    this.editInput.end = '';
                    this.editInput.start_date = '';
                    this.editInput.end_date = '';
                    this.editInput.datetime_start = '';
                    this.editInput.datetime_end = '';
                }
                if(this.route == "/resource"){
                    var url = "/resource/updateAssignResource/"+this.editInput.id;
                }else if(this.route == "/resource_repair"){
                    var url = "/resource_repair/updateAssignResource/"+this.editInput.id;
                }         
                let editInput = JSON.stringify(this.editInput);
                window.axios.put(url,editInput).then((response) => {
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
                        $('#edit_item').modal('hide');
                        $('div.overlay').hide();            
                    }
                    this.clearEditData();
                    this.getResource();   
                })
                .catch((error) => {
                    $('div.overlay').hide();            
                })
            },
            openEditModal(data,index){
                $('input[name="daterangeModal"]').val('');
                this.editInput.id = data.id
                this.editInput.category_id = data.category_id;
                this.editInput.resource_id = data.resource_id;
                this.editInput.old_resource_id = data.resource_id;
                this.editInput.resource_detail_id = data.resource_detail_id;
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.quantity = data.quantity;
                this.editInput.start_date = data.start_date;
                this.editInput.end_date = data.end_date;

                this.buildDateRangePicker();
            },
        },
        watch : {
            'project_id' : function(newValue){
                if(newValue != ""){
                    $('div.overlay').show();
                    this.getResource();

                    window.axios.get('/api/getProjectPR/'+newValue).then(({ data }) => {
                        this.selectedProject = [];
                        this.selectedProject.push(data);
                        
                        window.axios.get('/api/getWbsAssignResource/'+newValue).then(({ data }) => {
                            this.modelWBS = data;
                        })
                        .catch((error) => {
                            iziToast.warning({
                                title: 'Please Try Again..',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            $('div.overlay').hide();
                        })
                        this.dataInput.resource_id = "";
                        this.dataInput.wbs_id = "";
                        this.dataInput.quantity = "";
                        $('div.overlay').hide();
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again..',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })
                }else{
                    this.selectedProject = [];
                }              
            },
            'dataInput.quantity': function(newValue){
                this.dataInput.quantity = (this.dataInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            },
            'editInput.quantity': function(newValue){
                this.editInput.quantity = (this.editInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            },
            'dataInput.resource_id' : function(newValue){
                this.selectedRD = [];
                this.dataInput.resource_detail_id = '';
                this.dataInput.quantity = '';
                this.resourceDetails.forEach(data => {
                    if(data.resource_id == newValue && data.category_id == this.dataInput.category_id){
                        this.selectedRD.push(data);
                    }
                })
            },
            'dataInput.category_id' : function(newValue){
                this.selectedRD = [];
                this.dataInput.resource_id = '';
                this.dataInput.resource_detail_id = '';
                this.dataInput.quantity = '';
            },
            'dataInput.resource_detail_id': function(newValue){
                if(newValue != ''){
                    this.dataInput.quantity = 1;
                }else{
                    this.dataInput.quantity = '';
                }
            },
            'schedule.resource_id' : function(newValue){
                this.schedule.resource_detail_id = "";
                if(newValue != ''){
                    this.schedule.selectedRD = [];
                    this.resourceDetails.forEach(RD => {
                        if(RD.resource_id == newValue && RD.category_id == 3){
                            this.schedule.selectedRD.push(RD);
                        }  
                    });
                }
            },
            'schedule.resource_detail_id' : function(newValue){
                if(newValue != ''){
                    $('div.overlay').show();
                    this.destroyFullCalendar();
                    this.schedule.events = [];
                    window.axios.get('/api/getSchedule/'+newValue).then(({ data }) => {
                        data.forEach(TR =>{
                            let start_date = new Date((TR.start_date+"").replace(/-/g,"/"));
                            let end_date = new Date((TR.end_date+"").replace(/-/g,"/"));

                            this.schedule.events.push({
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
                }
            },
            'editInput.resource_id' : function(newValue){
                if(this.editInput.category_id == 3){
                    this.selectedRDModal = [];
                    this.resourceDetails.forEach(data => {
                        if(data.resource_id == newValue && data.category_id == 3){
                            this.selectedRDModal.push(data);
                        }
                    })
                    if(this.editInput.old_resource_id != newValue){
                        this.editInput.resource_detail_id = '';
                    }
                }
                
            },
            'editInput.resource_detail_id' : function(newValue){
                if(newValue != "" && newValue != null){
                    if(this.editInput.category_id == 3){
                        this.editInput.quantity = 1;
                    }
                }             
            },
        },
    });
</script>
@endpush
