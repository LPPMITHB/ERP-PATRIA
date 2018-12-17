@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'View Bill Of Material » Select WBS',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'View Bill Of Material' => route('bom.selectProject'),
            'Select WBS' => '',
        ]
    ]
)
@endbreadcrumb
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header">
                <div class="col-sm-4 p-l-0">
                    <table>
                        <thead>
                            <th colspan="2">Project Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->number}}</b></td>
                            </tr>
                            <tr>
                                <td>Ship</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->ship->type}}</b></td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->customer->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Planned Start Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $project->planned_start_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Planned End Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $project->planned_end_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-body">
                <div class="row p-l-20 p-b-10"><b>Treeview Project</b></div>
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
        var data = @json($data);
        
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