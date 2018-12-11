@extends('layouts.main')
@section('content-header')
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
        }).bind("loaded.jstree", function (event, data) {
            // you get two params - event & data - check the core docs for a detailed description
            $(this).jstree("open_all");
        });

        $('div.overlay').hide();
    });
    
</script>
@endpush