@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage Material » Select WBS',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('project_standard.selectProject'),
                'Select WBS' => '',
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
                <div class="col-xs-12 col-lg-4 col-md-12 no-padding">
                    <div class="box-body no-padding">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Name</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->name}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Description</div>
                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->description}}"><b>: {{$project->description}}</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Ship Type</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->ship->type}}</b></div>
                    </div>
                </div>
            </div>
            <div class="box-body p-l-0 p-t-0">
                <div id="treeview">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function(){
        var data = @json($data);
        var project = @json($project);

        $('#treeview').jstree({
            "core": {
                "data": data,
                "check_callback": true,
                "animation": 200,
                "dblclick_toggle": false,
                "keep_selected_style": false
            },
            "plugins": ["dnd", "contextmenu"],
            "contextmenu": {
                "select_node": false, 
                "show_at_node": false,
            }
        }).bind("changed.jstree", function (e, data) {
            if(data.node) {
                document.location = data.node.a_attr.href;
            }
        }).bind("loaded.jstree", function (event, data) {
            $(this).jstree("open_all");
        });
        $('div.overlay').hide();
    });

    $('#treeview').on("select_node.jstree", function (e, data) {
        if(data.node.a_attr.href != '#'){
            $('div.overlay').show();
        }
     });
</script>
@endpush