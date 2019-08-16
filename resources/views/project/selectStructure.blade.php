@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [   
            'title' => "Select Project Structure",
            'items' => [
                'Dashboard' => route('index'),
                'View All Projects' => route('project_repair.index'),
                'Create Project [Project Information]' => route('project_repair.edit',$newProject->id),
                'Select Project Structure' => ''
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
                <div class="col-xs-12 col-lg-4 col-md-12">    
                    <div class="box-body">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Code</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$newProject->number}}</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Ship</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$newProject->ship->type}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Customer</div>
                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$newProject->customer->name}}"><b>: {{$newProject->customer->name}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Start Date</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $newProject->planned_start_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>

                        <div class="col-md-4 col-xs-4 no-padding">End Date</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $newProject->planned_end_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div id="wbs"> --}}
                <div class="box-body">
                    <h4 class="box-title">Work Breakdown Structures</h4>
                    <div id="treeview">
                    
                    </div>
                </div>
            {{-- </div> --}}
                <form id="select-structure" class="form-horizontal" method="POST" action="{{route('project_repair.storeSelectedStructure') }}">
                @csrf
                <div class="box-footer">
                    <checkbox type="checkbox" class="btn btn-primary pull-right" onclick="submitForm()">CREATE</checkbox>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    var dataTree = @json($dataWbs);
    var project = @json($projectStandard);
    var newProject = @json($newProject);
    var checkedWbs = [];
    const form = document.querySelector('form#select-structure');

    function submitForm() {
        $('div.overlay').show();
        var selectedWbs = $(".iCheck:checked").map(function(){
            return $(this).val();
        }).toArray();

        var jsonData = JSON.stringify(selectedWbs);
        let struturesElem = document.createElement('input');
        struturesElem.setAttribute('type', 'hidden');
        struturesElem.setAttribute('name', 'structures');
        struturesElem.setAttribute('value', jsonData);
        form.appendChild(struturesElem);

        let project_id = document.createElement('input');
        project_id.setAttribute('type', 'hidden');
        project_id.setAttribute('name', 'project_id');
        project_id.setAttribute('value', newProject.id);
        form.appendChild(project_id);

        let project_standard_id = document.createElement('input');
        project_standard_id.setAttribute('type', 'hidden');
        project_standard_id.setAttribute('name', 'project_standard_id');
        project_standard_id.setAttribute('value', project.id);
        form.appendChild(project_standard_id);
        form.submit();
    }

    function getParents(){

    }

    $(document).ready(function(){     
        $('#treeview').jstree({
            "core": {
                'data': dataTree,
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
        }).on("changed.jstree", function (e, data) {
        
        }).on("loaded.jstree", function (event, data) {
            // you get two params - event & data - check the core docs for a detailed description
            $(this).jstree("open_all");
            dataTree.forEach(element => {
                if("PRO"+project.id != element.id){
                    const elem = document.getElementById(element.id+"_anchor");
                    let checkbox = document.createElement('input');
                    checkbox.setAttribute('type', 'checkbox');
                    checkbox.setAttribute('class', 'iCheck');
                    checkbox.setAttribute('id', "i-"+element.id);
                    checkbox.setAttribute('value', element.id);
                    if(elem != null){
                        elem.parentNode.insertBefore(checkbox, elem.nextSibling);
                    }
                }
            });
            $(".iCheck").each(function() {
                $(this).iCheck({
                    checkboxClass: "icheckbox_square-blue",
                    radioClass: "iradio_square-blue",
                    increaseArea: "20%" // optional
                }).on('ifChecked', function(event){
                    var selected_val = event.target.value;
                    dataTree.forEach(element => {
                        if(!element.parent.includes("PRO") && !element.parent.includes("#")){
                            if(element.id === selected_val){
                                $('#i-'+element.parent).iCheck('check');
                            }
                        }
                    });
                }).on('ifUnchecked', function(event){
                    var unselected_val = $(this).val();
                    dataTree.forEach(element => {
                        if(!element.parent.includes("PRO") && !element.parent.includes("#")){
                            if(element.parent === unselected_val){
                                $('#i-'+element.id).iCheck('uncheck');
                            }
                        }
                    });
                });
            });
        }); 

        $('div.overlay').hide();
    });

    
</script>
@endpush
