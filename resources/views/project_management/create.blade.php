@extends('layouts.main')
@section('content-header')

@if($project->id)
@breadcrumb(
    [
        'title' => 'Edit Project',
        'items' => [
            'Home' => route('index'),
            'View all Projects' => route('project.index'),
            $project->name => route('project.show',$project->id),
            'Edit' => route('project.edit',$project->id),
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
            'View all Project' => route('project.index'),
            'Create' => route('project.create'),
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
                    <form class="form-horizontal" method="POST" action="{{ route('project.update',['id'=>$project->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form id="create-project" class="form-horizontal" method="POST" action="{{ route('project.store') }}">
                @endif
                    @csrf
                    <div class="box-body">
                        @verbatim
                        <div id="project">
                            <div class="form-group">
                                <label for="code" class="col-sm-2 control-label">Project Code</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="code" name="code" required autofocus v-model="project.code">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Project Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" required v-model="project.name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="customer" class="col-sm-2 control-label">Customer Name</label>
                
                                <div class="col-sm-10">
                                    <selectize name="customer" id="customer" v-model="customer" required autofocus >
                                        <option v-for="(customer, index) in customers" :value="customer.id">{{ customer.name }}</option>
                                    </selectize>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Owner Representative</label>
                                <div class="col-sm-10">
                                    <input type="text" disabled class="form-control" id="name" name="name" required v-model="ownerRep">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ship" class="col-sm-2 control-label">Flag</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="flag" name="flag" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ship" class="col-sm-2 control-label">Classification Name</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="class_name" name="class_name" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ship" class="col-sm-2 control-label">Classification Contact Person Name</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="class_contact_person_name" name="class_contact_person_name" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ship" class="col-sm-2 control-label">Classification Contact Person Phone</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="class_contact_person_phone" name="class_contact_person_phone" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ship" class="col-sm-2 control-label">Classification Contact Person E-Mail</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="class_contact_person_email" name="class_contact_person_email" required>
                                </div>
                            </div>

                            <div class="form-group">
                                    <label for="ship" class="col-sm-2 control-label">Ship Name</label>
                    
                                    <div class="col-sm-10">
                                        <selectize name="ship" id="ship" required>
                                            <option v-for="(ship, index) in ships" :value="ship.id">{{ ship.name }}</option>
                                        </selectize>
                                    </div>
                                </div>
                        
                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="3" name="description">{{ project.description }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="planned_start_date" class="col-sm-2 control-label">Start Date</label>
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
                                <label for="planned_end_date" class="col-sm-2 control-label">End Date</label>
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
                                <label for="planned_duration" class="col-sm-2 control-label">Duration</label>
                                <div class="col-sm-5">
                                    <input type="number" class="form-control" id="planned_duration" name="planned_duration" placeholder="Duration" >                                        
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="planned_duration" class="col-sm-2 control-label">Upload Drawing</label>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary pull-right width100">UPLOAD</button>
                                </div>
                            </div>
                        </div>
                        @endverbatim
                    </div>
                    <div class="box-footer">
                        @if($project->id)
                            <button type="submit" class="btn btn-primary pull-right">SAVE</button>
                        @else
                            <button type="submit" class="btn btn-primary pull-right">CREATE</button>
                        @endif
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
$(document).ready(function(){
    var data = {
        customers : @json($customers),
        ships : @json($ships),
        ownerRep : "",
        project : {
            code : @json($project->code == null ? $project_code: $project->code),
            name : @json($project->name == null ? "": $project->name),   
        },
        customer: "",
    };

    var vm = new Vue({
        el: '#project',
        data: data,
        watch : {
            customer: function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getCustomerPM/'+newValue).then(({ data }) => {
                        this.ownerRep = data.contact_person_name+" - "+data.contact_person_phone+" - "+data.contact_person_email;
                    });
                }
            }
        }

    });
    $('div.overlay').hide();
    $('#customer,#ship').selectize();
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
            var planned_end_date = new Date(planned_start_date);
            
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
    }
    



});


</script>
@endpush