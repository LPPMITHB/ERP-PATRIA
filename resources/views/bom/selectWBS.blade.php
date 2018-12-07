@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Manage Bill Of Materials » Select WBS',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('bom.indexProject'),
            'Select WBS' => route('bom.indexProject'),
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
                        
                        <div class="col-md-4 col-xs-4 no-padding">Code</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->number}}</b></div>
                        
                        <div class="col-md-4 col-xs-4 no-padding">Ship</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{$project->ship->name}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Customer</div>
                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->name}}"><b>: {{$project->customer->name}}</b></div>

                        <div class="col-md-4 col-xs-4 no-padding">Start Date</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $project->planned_start_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>

                        <div class="col-md-4 col-xs-4 no-padding">End Date</div>
                        <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $project->planned_end_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                            @endphp
                            </b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body p-l-0 p-t-0">
                <div id="treeview">
                    
                </div>
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
        var data = @json($wbs);
        
        $('#treeview').jstree({
            "core": {
                'data': data,
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
                // you get two params - event & data - check the core docs for a detailed description
                $(this).jstree("open_all");
            });

        $('div.overlay').hide();
    });
    
</script>
@endpush