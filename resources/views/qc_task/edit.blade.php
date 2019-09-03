@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Edit Quality Control Task',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Edit Quality Control Task' => route('qc_task.edit',$modelQcTask->id),',
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    @if($route == 'qc_task')
                        <form id="edit-qc-task" class="form-horizontal" method="POST" action="{{ route('qc_task.update') }}">
                    @endif
                    @csrf
                        @verbatim
                        <div id="qc_task">
                        
                        </div>
                        @endverbatim
                        </form>
                </div>
            </div>
        </div>   
@endsection


@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();
    });



    var data = {

    }

    var vm = new Vue({
        el : '#qc_task',
        data : data,
    })

</script>
@endpush