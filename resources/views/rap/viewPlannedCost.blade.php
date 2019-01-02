@extends('layouts.main')
@section('content-header')
@if($route == "/rap")
    @breadcrumb(
        [
            'title' => 'View Planned Cost » '.$project->name,
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('rap.selectProjectViewCost'),
                'View Planned Cost' => ""
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/rap_repair")
    @breadcrumb(
        [
            'title' => 'View Planned Cost » '.$project->name,
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('rap_repair.selectProjectViewCost'),
                'View Planned Cost' => ""
            ]
        ]
    )
    @endbreadcrumb
@endif

@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header">
                <div class="row p-l-20">
                    <h4>
                        <b>Project Treeview</b>
                    </h4>
                </div>
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
            'core' : {
                'data' : data
            }
        });

        $('div.overlay').hide();
    });
    
</script>
@endpush