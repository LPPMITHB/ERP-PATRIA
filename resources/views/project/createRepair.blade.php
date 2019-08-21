@extends('layouts.main')
@section('content-header')

@if($project->id)
    @breadcrumb(
        [
            'title' => 'Edit Project',
            'items' => [
                'Home' => route('index'),
                'View all Projects' => route('project_repair.index'),
                $project->name => route('project_repair.show',$project->id),
                'Edit' => route('project_repair.edit',$project->id),
            ]
        ]
    )
    @endbreadcrumb
@else
    @breadcrumb(
        [
            'title' => 'Create Project',
            'items' => [
                'Dashboard' => route('index'),
                'View all Project' => route('project_repair.index'),
                'Create' => route('project_repair.create'),
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid p-t-20">
            <div class="box-body">
                @if($project->id)
                    <form class="form-horizontal" method="POST" action="{{ route('project_repair.update',['id'=>$project->id]) }}" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form id="create-project" class="form-horizontal" method="POST" action="{{ route('project_repair.storeGeneralInfo') }}" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="box-body">
                        @verbatim
                        <div id="project">
                            <div class="form-group">
                                <label for="number" class="col-sm-2 control-label">Project Number*</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="number" name="number"  required v-model="project.number">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="person_in_charge" class="col-sm-2 control-label">Project Leader</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="person_in_charge" name="person_in_charge" v-model="project.person_in_charge">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Ship Name*</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" v-model="project.name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="project_type" class="col-sm-2 control-label">Project Type*</label>

                                <div class="col-sm-10">
                                    <selectize name="project_type" id="project_type" required>
                                        <option v-for="(data, index) in projectType" v-if="data.business_unit_id == 2" :value="data.id">{{ data.name }}</option>
                                    </selectize>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="customer" class="col-sm-2 control-label">Customer Name*</label>

                                <div class="col-sm-10">
                                    <selectize name="customer" id="customer" v-model="customer" required autofocus >
                                        <option v-for="(customer, index) in customers" :value="customer.id">{{ customer.name }}</option>
                                    </selectize>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Owner Representative</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" minlength="10" maxlength="12" id="owner_rep" name="owner_rep"  v-model="ownerRep">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ship" class="col-sm-2 control-label">Ship Type*</label>

                                <div class="col-sm-10">
                                    <selectize v-model="project.ship_id" name="ship" id="ship" required>
                                        <option v-for="(ship, index) in ships" :value="ship.id">{{ ship.type }}</option>
                                    </selectize>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="project_standard" class="col-sm-2 control-label">Project Standard*</label>

                                <div class="col-sm-10">
                                    <selectize v-model="project.project_standard_id" :disabled="shipSelected" name="project_standard" id="project_standard" required>
                                        <option v-for="(project_standard, index) in projectStandards" :value="project_standard.id">{{ project_standard.name }} - {{ project_standard.description }}</option>
                                    </selectize>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="3" name="description" >{{ project.description }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="planned_start_date" class="col-sm-2 control-label">Start Date *</label>
                                <div class="col-sm-5">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input autocomplete="off" type="text" class="form-control datepicker" name="planned_start_date" id="planned_start_date" placeholder="Start Date">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="planned_end_date" class="col-sm-2 control-label">End Date *</label>
                                <div class="col-sm-5">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input autocomplete="off" type="text" class="form-control datepicker" name="planned_end_date" id="planned_end_date" placeholder="End Date">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="planned_duration" class="col-sm-2 control-label">Duration (Days)</label>
                                <div class="col-sm-5">
                                    <input type="number" class="form-control" id="planned_duration" name="planned_duration" placeholder="Duration" >
                                </div>
                            </div>

                            <div class="form-group" v-if="(menu=='repair')">
                                <label for="arrival_date" class="col-sm-2 control-label">Arrival Date *</label>
                                <div class="col-sm-5">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input autocomplete="off" type="text" class="form-control datepicker" name="arrival_date" id="arrival_date" placeholder="Arrival Date">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="upload" class="col-sm-2 control-label">Upload Drawing</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <label class="input-group-btn">
                                            <span class="btn btn-primary">
                                                Browse&hellip; <input type="file" style="display: none;" multiple id="drawing" name="drawing">
                                            </span>
                                        </label>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="box-footer">
                                <button v-if="projectUpdate!=''" type="submit" class="btn btn-primary pull-right">SAVE</button>
                                <button v-else @click.prevent="submitForm()" type="button" class="btn btn-primary pull-right">NEXT</button>
                            </div>
                        </div>
                        @endverbatim
                    </div>
                </form>
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
    const form = document.querySelector('form#create-project');
$(document).ready(function(){
    $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    // We can watch for our custom `fileselect` event like this
    $(document).ready( function() {
        $(':file').on('fileselect', function(event, numFiles, label) {
            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;
            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }
        });
    });

    var data = {
        oldData : {
            number : @json(Request::old('number')),
            name : @json(Request::old('name')),
            flag : @json(Request::old('flag')),
            hull_number : @json(Request::old('hull_number')),
            class_name : @json(Request::old('class_name')),
            class_name_2 : @json(Request::old('class_name_2')),
            class_cp_name : @json(Request::old('class_contact_person_name')),
            class_cp_name_2 : @json(Request::old('class_contact_person_name_2')),
            class_cp_phone : @json(Request::old('class_contact_person_phone')),
            class_cp_phone_2 : @json(Request::old('class_contact_person_phone_2')),
            class_cp_email :@json(Request::old('class_contact_person_email')),
            class_cp_email_2 :@json(Request::old('class_contact_person_email_2')),
            description : @json(Request::old('description')),
            person_in_charge : @json(Request::old('person_in_charge')),
            budget_value : @json(Request::old('budget_value')),
            ship_id : @json(Request::old('ship_id')),
            project_standard_id : @json(Request::old('project_standard_id')),
        },
        projectUpdate:  @json($project->id== null ? "": $project->id),
        customers : @json($customers),
        ships : @json($ships),
        projectType : @json($projectType),
        projectStandards : [],
        ownerRep : "",
        project : {
            number : @json($project->number == null ? "": $project->number),
            name : @json($project->name == null ? "": $project->name),
            flag : @json($project->flag == null ? "": $project->flag),
            hull_number : @json($project->hull_number == null ? "": $project->hull_number),
            class_name : @json($project->class_name == null ? "": $project->class_name),
            class_name_2 : @json($project->class_name_2 == null ? "": $project->class_name_2),
            class_cp_name : @json($project->class_contact_person_name == null ? "": $project->class_contact_person_name),
            class_cp_name_2 : @json($project->class_contact_person_name_2 == null ? "": $project->class_contact_person_name_2),
            class_cp_phone : @json($project->class_contact_person_phone == null ? "": $project->class_contact_person_phone),
            class_cp_phone_2 : @json($project->class_contact_person_phone_2 == null ? "": $project->class_contact_person_phone_2),
            class_cp_email : @json($project->class_contact_person_email == null ? "": $project->class_contact_person_email),
            class_cp_email_2 : @json($project->class_contact_person_email_2 == null ? "": $project->class_contact_person_email_2),
            description : @json($project->description == null ? "": $project->description),
            person_in_charge : @json($project->person_in_charge == null ? "": $project->person_in_charge),
            budget_value : @json($project->budget_value == null ? "": $project->budget_value),
            ship_id : @json($project->ship_id == null ? "": $project->ship_id),
            project_standard_id : @json($project->project_standard_id == null ? "": $project->project_standard_id),
        },
        customer: "",
        menu : @json($menu),
        business_unit_id: @json($menu != "building" ? 2 : 1),
    };

    var vm = new Vue({
        el: '#project',
        data: data,
        computed : {
            shipSelected: function(){
                let isOk = false;
                    if(this.project.ship_id == "")
                    {
                        isOk = true;
                    }
                return isOk;
            },
        },
        methods : {
            submitForm(){
                if(this.project.class_cp_phone.length > 13 || this.project.class_cp_phone.length < 10 && this.menu == "building" && this.project.class_cp_phone != ""){
                    iziToast.warning({
                        title: 'Classification Contact Person Phone format is not appropriate !',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                }else{
                    let struturesElem = document.createElement('input');
                    struturesElem.setAttribute('type', 'hidden');
                    struturesElem.setAttribute('name', 'business_unit_id');
                    struturesElem.setAttribute('value', JSON.stringify(this.business_unit_id));
                    let struturesElem_BV = document.createElement('input');
                    struturesElem_BV.setAttribute('type', 'hidden');
                    struturesElem_BV.setAttribute('name', 'budget_value_int');
                    var temp_value = this.project.budget_value.replace(/,/g , '');
                    struturesElem_BV.setAttribute('value', temp_value);
                    form.appendChild(struturesElem);
                    form.appendChild(struturesElem_BV);
                    form.submit();
                }
            },
        },
        watch : {
            customer: function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getCustomerPM/'+newValue).then(({ data }) => {
                        if(data.contact_name == null && data.phone_number_1 == null && data.email == null){
                            this.ownerRep = " - ";
                        }
                        else if(data.contact_name == null && data.phone_number_1 == null){
                            this.ownerRep = data.email;
                        }
                        else if(data.contact_name == null && data.email == null){
                            this.ownerRep = data.phone_number_1;
                        }
                        else if(data.phone_number_1 == null && data.email == null){
                            this.ownerRep = data.contact_name;
                        }
                        else if(data.contact_name == null){
                            this.ownerRep = data.phone_number_1+" - "+data.email;
                        }
                        else if(data.phone_number_1 == null){
                            this.ownerRep = data.contact_name+" - "+data.email;
                        }
                        else if(data.email == null){
                            this.ownerRep = data.contact_name+" - "+data.phone_number_1;
                        }
                        else
                            this.ownerRep = data.contact_name+ " - " +data.phone_number_1+ " - " +data.email;
                        });
                    }
                else
                    this.ownerRep = " - ";
                },
            'ownerRep': function(newValue){
                if(newValue != ""){
                    this.ownerRep = (this.ownerRep+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g,"");
                }
            },
            'project.class_cp_phone': function(newValue){
                if(newValue != ""){
                    this.project.class_cp_phone = (this.project.class_cp_phone+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g,"");
                }
            },
            'project.class_cp_phone_2': function(newValue){
                if(newValue != ""){
                    this.project.class_cp_phone_2 = (this.project.class_cp_phone_2+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g,"");
                }
            },
            'project.budget_value': function (newValue){
                var decimal = (newValue+"").replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.project.budget_value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.project.budget_value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.project.budget_value = (this.project.budget_value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'project.ship_id' : function(newValue){
                if(newValue != ""){
                    this.project.project_standard_id = "";
                    window.axios.get('/api/getProjectStandard/'+newValue).then(({ data }) => {
                        this.projectStandards = data;
                    });
                }else{
                    this.project.project_standard_id = "";
                    this.projectStandards = [];
                }
            }
        },
        created: function() {
            this.project.ship_id = "";
            if(this.oldData.number !=null) {
                this.project.number=this.oldData.number;
            }
            if(this.oldData.name !=null) {
                this.project.name=this.oldData.name;
            }
            if(this.oldData.flag !=null) {
                this.project.flag=this.oldData.flag;
            }
            if(this.oldData.class_name !=null) {
                this.project.class_name=this.oldData.class_name;
            }
            if(this.oldData.class_name_2 !=null) {
                this.project.class_name_2=this.oldData.class_name_2;
            }
            if(this.oldData.class_cp_name !=null) {
                this.project.class_cp_name=this.oldData.class_cp_name;
            }
            if(this.oldData.class_cp_name_2 !=null) {
                this.project.class_cp_name_2=this.oldData.class_cp_name_2;
            }
            if(this.oldData.class_cp_phone !=null) {
                this.project.class_cp_phone=this.oldData.class_cp_phone;
            }
            if(this.oldData.class_cp_phone_2 !=null) {
                this.project.class_cp_phone_2=this.oldData.class_cp_phone_2;
            }
            if(this.oldData.class_cp_email !=null) {
                this.project.class_cp_email=this.oldData.class_cp_email;
            }
            if(this.oldData.class_cp_email_2 !=null) {
                this.project.class_cp_email_2=this.oldData.class_cp_email_2;
            }
            if(this.oldData.description !=null) {
                this.project.description=this.oldData.description;
        }
    },

    });
    $('div.overlay').hide();
    $('#customer,#ship,#project_type').selectize();
    $('.datepicker').datepicker({
        autoclose : true,
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

    $("#planned_start_date").datepicker().on(
        "changeDate", () => {
            var planned_start_date = $('#planned_start_date').val();
            var planned_end_date = $('#planned_end_date').val();
            if(planned_end_date != ""){
                var planned_duration = datediff(parseDate(planned_start_date), parseDate(planned_end_date));
                if(parseInt(planned_duration) < 1 ){
                    iziToast.show({
                        timeout: 6000,
                        color : 'red',
                        displayMode: 'replace',
                        icon: 'fa fa-warning',
                        title: 'Warning !',
                        message: 'End Date cannot be ahead Start Date',
                        position: 'topRight',
                        progressBarColor: 'rgb(0, 255, 184)',
                    });
                    $('#planned_start_date').datepicker('setDate', null);
                    $('#planned_end_date').datepicker('setDate', null);
                    document.getElementById('planned_duration').value = null;
                }else{
                    document.getElementById('planned_duration').value = planned_duration;
                }
            }
        }
    );
    $("#planned_end_date").datepicker().on(
        "changeDate", () => {
            var planned_start_date = $('#planned_start_date').val();
            var planned_end_date = $('#planned_end_date').val();
            if(planned_start_date != "" && planned_end_date != ""){
                var planned_duration = datediff(parseDate(planned_start_date), parseDate(planned_end_date));
                if(parseInt(planned_duration) < 1 ){
                    iziToast.show({
                        timeout: 6000,
                        color : 'red',
                        displayMode: 'replace',
                        icon: 'fa fa-warning',
                        title: 'Warning !',
                        message: 'End Date cannot be ahead Start Date',
                        position: 'topRight',
                        progressBarColor: 'rgb(0, 255, 184)',
                    });
                    $('#planned_start_date').datepicker('setDate', null);
                    $('#planned_end_date').datepicker('setDate', null);
                    document.getElementById('planned_duration').value = null;
                }else{
                    document.getElementById('planned_duration').value = planned_duration;
                }
            }
        }
    );

    function setEndDate(){
        document.getElementById('planned_duration').value = document.getElementById('planned_duration').value+"".replace(/\D/g, "");
        var planned_start_date = $('#planned_start_date').val();
        var planned_duration = document.getElementById('planned_duration').value;
        if(planned_duration != "" && planned_start_date != ""){
            var planned_duration = parseInt(planned_duration);
            var planned_start_date_temp = (planned_start_date+"").split("-");
            planned_start_date_temp = planned_start_date_temp[1]+"-"+planned_start_date_temp[0]+"-"+planned_start_date_temp[2];
            console.log(planned_start_date_temp);
            var planned_end_date = new Date(planned_start_date);
            console.log(planned_end_date);
            planned_end_date.setDate(planned_end_date.getDate() + planned_duration-1);
            $('#planned_end_date').datepicker('setDate', planned_end_date);
        }else{
            $('#planned_end_date').datepicker('setDate', null);
        }
    }
    document.getElementById('planned_duration').addEventListener("keyup", setEndDate);
    document.getElementById('planned_duration').addEventListener("change", setEndDate);

    if(@JSON($project->id)){
        var planned_start_date = new Date(@JSON($project->planned_start_date));
        var planned_end_date = new Date(@JSON($project->planned_end_date));
        $('#planned_start_date').datepicker('setDate', planned_start_date);
        $('#planned_end_date').datepicker('setDate', planned_end_date);

        var $selectCustomer = $("#customer").selectize();
        var selectizeCustomer = $selectCustomer[0].selectize;
        selectizeCustomer.setValue(@JSON($project->customer_id));

        var $selectShip = $("#ship").selectize();
        var selectizeShip = $selectShip[0].selectize;
        selectizeShip.setValue(@JSON($project->ship_id));

        var $selectProjectType = $("#project_type").selectize();
        var selectizeProjectType = $selectProjectType[0].selectize;
        selectizeProjectType.setValue(@JSON($project->project_type));
    }

    if(@JSON(Request::old('planned_start_date')) != null){
        var planned_start_date = new Date(@JSON(Request::old('planned_start_date')));
        $('#planned_start_date').datepicker('setDate', @JSON(Request::old('planned_start_date')) );
    }
    if(@JSON(Request::old('planned_end_date')) != null){
        var planned_end_date = new Date(@JSON(Request::old('planned_end_date')));
        $('#planned_end_date').datepicker('setDate', @JSON(Request::old('planned_end_date')) );
    }

    if(@JSON(Request::old('customer')) != null){
        var $selectCustomer = $("#customer").selectize();
        var selectizeCustomer = $selectCustomer[0].selectize;
        selectizeCustomer.setValue(@JSON(Request::old('customer')) );
    }
    if(@JSON(Request::old('ship')) != null){
        var $selectShip = $("#ship").selectize();
        var selectizeShip = $selectShip[0].selectize;
        selectizeShip.setValue(@JSON(Request::old('ship')));
    }
    if(@JSON(Request::old('project_type')) != null){
        var $selectProjectType = $("#project_type").selectize();
        var selectizeProjectType = $selectProjectType[0].selectize;
        selectizeProjectType.setValue(@JSON(Request::old('project_type')));
    }


});


</script>
@endpush
