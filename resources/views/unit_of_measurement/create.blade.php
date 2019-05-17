@extends('layouts.main')
@section('content-header')

@if($uom->id)
@breadcrumb(
    [
        'title' => 'Edit Unit Of Measurement',
        'subtitle' => 'Edit',
        'items' => [
            'Dashboard' => route('index'),
            'View All Unit Of Measurements' => route('unit_of_measurement.index'),
            $uom->name => route('unit_of_measurement.show',$uom->id),
            'Edit Unit Of Measurement' => route('unit_of_measurement.edit',$uom->id),
        ]
    ]
)
@endbreadcrumb
@else
@breadcrumb(
    [
        'title' => 'Create Unit Of Measurement',
        'items' => [
            'Dashboard' => route('index'),
            'View All Unit Of Measurements' => route('unit_of_measurement.index'),
            'Create Unit Of Measurement' => route('unit_of_measurement.create'),
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
                <!-- @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif -->

                @if($uom->id)
                    <form class="form-horizontal" method="POST" action="{{ route('unit_of_measurement.update',['id'=>$uom->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form class="form-horizontal" method="POST" action="{{ route('unit_of_measurement.store') }}">
                @endif
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">Code *</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="code" name="code" required autofocus value="{{ $uom->code == null ? $uom_code: $uom->code }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name *</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required autofocus value="{{ $uom->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">Unit *</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="unit" name="unit" required value="{{ $uom->unit }}">
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
                        <div class="form-group">
                            <label for="is_decimal" class="col-sm-2 control-label">Decimal?</label>
            
                            <div class="col-sm-10">
                                <select class="form-control" name="is_decimal" id="is_decimal" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        @if($uom->id)
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
        $('#status').val("{{$uom->status}}");
        if($('#status').val()==null){
            $('#status').val(1);
        }
        $('#status').select({
            minimumResultsForSearch: -1
        });
        $('div.overlay').remove();
        $('.alert').addClass('animated bounce');
    
    });
    
    document.getElementById("code").readOnly = true;
    
</script>
@endpush
