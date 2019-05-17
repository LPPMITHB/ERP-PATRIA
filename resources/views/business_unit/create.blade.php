@extends('layouts.main')
@section('content-header')

@if($business_unit->id)
@breadcrumb(
    [
        'title' => 'Edit Business Unit',
        'items' => [
            'Dashboard' => route('index'),
            'View All Business Units' => route('business_unit.index'),
            $business_unit->name => route('business_unit.show',$business_unit->id),
            'Edit BusinessUnit' => route('business_unit.edit',$business_unit->id),
        ]
    ]
)
@endbreadcrumb
@else
@breadcrumb(
    [
        'title' => 'Create Business Unit',
        'items' => [
            'Dashboard' => route('index'),
            'View All Business Units' => route('business_unit.index'),
            'Create Business Unit' => route('business_unit.create'),
        ]
    ]
)
@endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                @if($business_unit->id)
                    <form class="form-horizontal" method="POST" action="{{ route('business_unit.update',['id'=>$business_unit->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form class="form-horizontal" method="POST" action="{{ route('business_unit.store') }}">
                @endif
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name *</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required autofocus value="{{ $business_unit->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description *</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="description" name="description" required value="{{ $business_unit->description }}">
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
                        @if($business_unit->id)
                            <button type="submit" class="btn btn-primary pull-right">SAVE</button>
                        @else
                            <button type="submit" class="btn btn-primary pull-right">CREATE</button>
                        @endif
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div> <!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('#status').val("{{$business_unit->status}}");
        if($('#status').val()==null){
            $('#status').val(1);
        }
        $('#status').select({
            minimumResultsForSearch: -1
        });
        $('div.overlay').remove();
        $('.alert').addClass('animated bounce');
    });
    
</script>
@endpush
