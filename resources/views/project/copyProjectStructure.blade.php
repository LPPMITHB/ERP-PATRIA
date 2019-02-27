@extends('layouts.main')

@section('content-header')
    @if ($mainMenu == "building")
        @breadcrumb(
            [   
                'title' => "Copy Project [Project Structure]",
                'items' => [
                    'Dashboard' => route('index'),
                    'View All Projects' => route('project.index'),
                    'Select Project' => route('project.indexCopyProject'),
                    'Copy Project [Project Information]' => route('project.edit',$newProject->id),
                    'Copy Project [Project Structure]' => ''
                ]
            ]
        )
        @endbreadcrumb
    @else
        @breadcrumb(
            [   
                'title' => "Copy Project [Project Structure]",
                'items' => [
                    'Dashboard' => route('index'),
                    'View All Projects' => route('project_repair.index'),
                    'Select Project' => route('project_repair.indexCopyProject'),
                    'Copy Project [Project Information]' => route('project_repair.edit',$newProject->id),
                    'Copy Project [Project Structure]' => ''
                ]
            ]
        )
        @endbreadcrumb
    @endif
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
            @if($mainMenu == "building")
                <form id="create-project-structure" class="form-horizontal" method="POST" action="{{route('project.storeCopyProjectStructure') }}">
            @else
                <form id="create-project-structure" class="form-horizontal" method="POST" action="{{route('project_repair.storeCopyProjectStructure') }}">
            @endif
                @csrf
                <div class="box-footer">
                    <button type="button" class="btn btn-primary pull-right" onclick="submitForm()">CREATE</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    var dataTree = @json($dataWbs);
    var project = @json($project);
    var newProject = @json($newProject);
    const form = document.querySelector('form#create-project-structure');

    function submitForm() {
        $('div.overlay').show();
        var treeData = $('#treeview').jstree(true).get_json('#', {flat:true})
        // set flat:true to get all nodes in 1-level json
        var jsonData = JSON.stringify(treeData);
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
        form.submit();
    }
    function deleteWbs(evt){
        var node = $("#treeview").jstree(true).get_node(evt.srcElement.id);//111 is node id
        $("#treeview").jstree("delete_node", node);
        dataTree.forEach(element => {
            if(project.number != element.id){
                const elem = document.getElementById(element.id+"_anchor");
                let button = document.createElement('button');
                button.innerHTML = "DELETE"
                button.setAttribute('class', 'btn btn-primary btn-xs delete');
                button.setAttribute('id', element.id);
                button.setAttribute('onclick', "deleteWbs(event)");
                let existing = document.querySelector('button#'+element.id);
                if(elem != null && existing == null){
                    elem.parentNode.insertBefore(button, elem.nextSibling);
                }
            }
        });
        
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
                if(project.number != element.id){
                    const elem = document.getElementById(element.id+"_anchor");
                    let button = document.createElement('button');
                    button.innerHTML = "DELETE"
                    button.setAttribute('class', 'btn btn-primary btn-xs delete');
                    button.setAttribute('id', element.id);
                    button.setAttribute('onclick', "deleteWbs(event)");
                    if(elem != null){
                        elem.parentNode.insertBefore(button, elem.nextSibling);
                    }
                }
            });
        }); 

        $('div.overlay').hide();
    });

    
</script>
@endpush
