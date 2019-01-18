@extends('layouts.main')

@section('content-header')
@if($route == "/production_order")
    @breadcrumb(
        [   
            'title' => 'Create Production Order » '.$modelProject->name.' » Select WBS',
            'items' => [
                'Dashboard' => route('index'),
                'View all Projects' => route('production_order.selectProject'),
                'Select WBS' => ''
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/production_order_repair")
    @breadcrumb(
        [   
            'title' => 'Create Production Order » '.$modelProject->name.' » Select WBS',
            'items' => [
                'Dashboard' => route('index'),
                'View all Projects' => route('production_order_repair.selectProject'),
                'Select WBS' => ''
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
                <div class="col-md-12 col-lg-4 col-xs-12 p-l-0">
                    <div class="box-body no-padding">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
                            <div class="col-md-4 col-xs-4 no-padding">Number</div>
                                <div class="col-md-8 col-xs-8 no-padding"><b>: {{$modelProject->number}}</b></div>
                            <div class="col-md-4 col-xs-4 no-padding">Ship</div>
                                <div class="col-md-8 col-xs-8 no-padding"><b>: {{$modelProject->ship->type}}</b></div>
                            <div class="col-md-4 col-xs-4 no-padding">Customer</div>
                                <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelProject->customer->name}}"><b>: {{$modelProject->customer->name}}</b></div>
                            <div class="col-md-4 col-xs-4 no-padding">Start Date</div>
                                <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $modelProject->planned_start_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                                @endphp
                                </b>
                            </div>
                            <div class="col-md-4 col-xs-4 no-padding">End Date</div>
                                <div class="col-md-8 col-xs-8 no-padding"><b>: @php
                                $date = DateTime::createFromFormat('Y-m-d', $modelProject->planned_end_date);
                                $date = $date->format('d-m-Y');
                                echo $date;
                                @endphp
                                </b>
                            </div>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <h4 class="box-title">Work Breakdown Structures</h4>
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
        var data = @json($dataWbs);
        
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
