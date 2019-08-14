@extends('layouts.main')
@section('content-header')
@if($route == "/estimator")
    @if($wbs->id)
        @breadcrumb(
            [
                'title' => 'Edit WBS Cost Estimation',
                'subtitle' => 'Edit',
                'items' => [
                    'Dashboard' => route('index'),
                    'View WBS Cost Estimation' => route('estimator.indexEstimatorWbs'),
                    'Edit WBS Cost Estimation' =>'',
                ]
            ]
        )
        @endbreadcrumb
    @else
        @breadcrumb(
            [
                'title' => 'Create WBS Cost Estimation',
                'items' => [
                    'Dashboard' => route('index'),
                    'View WBS Cost Estimation' => route('estimator.indexEstimatorWbs'),
                    'Create WBS Cost Estimation' => '',
                ]
            ]
        )
        @endbreadcrumb
    @endif
@elseif($route == "/estimator_repair")
    @if($wbs->id)
        @breadcrumb(
            [
                'title' => 'Edit WBS Cost Estimation',
                'subtitle' => 'Edit',
                'items' => [
                    'Dashboard' => route('index'),
                    'View WBS Cost Estimation' => route('estimator_repair.indexEstimatorWbs'),
                    'Edit WBS Cost Estimation' => '',
                ]
            ]
        )
        @endbreadcrumb
    @else
        @breadcrumb(
            [
                'title' => 'Create WBS Cost Estimation',
                'items' => [
                    'Dashboard' => route('index'),
                    'View WBS Cost Estimation' => route('estimator_repair.indexEstimatorWbs'),
                    'Create WBS Cost Estimation' => '',
                ]
            ]
        )
        @endbreadcrumb
    @endif
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                @if($route == "/estimator")
                    @if($wbs->id)
                        <form class="form-horizontal" method="POST" action="{{ route('estimator.updateWbs',['id'=>$wbs->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                    @else
                        <form class="form-horizontal" method="POST" action="{{ route('estimator.storeWbs') }}">
                    @endif
                @elseif($route == "/estimator_repair")
                    @if($wbs->id)
                        <form class="form-horizontal" method="POST" action="{{ route('estimator_repair.updateWbs',['id'=>$wbs->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                    @else
                        <form class="form-horizontal" method="POST" action="{{ route('estimator_repair.storeWbs') }}">
                    @endif
                @endif
                @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">Code *</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="code" name="code" required autofocus value="{{ $wbs->code == null ? $wbs_code: $wbs->code }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name *</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required autofocus
                                @if($wbs->name != null) value="{{ $wbs->name }}"
                                @else value="{{ old('name') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="description" name="description"
                                @if($wbs->description != null) value="{{ $wbs->description }}"
                                @else value="{{ old('description') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">Status *</label>
            
                            <div class="col-sm-10">
                                <select class="form-control" name="status" id="status" required>
                                    <option value="1">Active</option>
                                    <option value="0">Non Active</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        @if($wbs->id)
                            <button type="submit" class="btn btn-primary pull-right">SAVE</button>
                        @else
                            <button type="submit" class="btn btn-primary pull-right">CREATE</button>
                        @endif
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('#status').val("{{$wbs->status}}");
        if($('#status').val()==null){
            $('#status').val(1);
        }
        $('#status').select({
            minimumResultsForSearch: -1
        });
        $('div.overlay').hide();
        $('.alert').addClass('animated bounce');
        

    });
    
    document.getElementById("code").readOnly = true;
    
</script>
@endpush
