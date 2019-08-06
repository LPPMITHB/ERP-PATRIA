@extends('layouts.main')
@section('content-header')

@if($storage_location->id)
@breadcrumb(
    [
        'title' => 'Update Storage Locations',
        'items' => [
            'Dashboard' => route('index'),
            'View All Storage Locations' => route('storage_location.index'),
            $storage_location->name => route('storage_location.show',$storage_location->id),
            'Update' => route('storage_location.edit',$storage_location->id),
        ]
    ]
)
@endbreadcrumb
@else
@breadcrumb(
    [
        'title' => 'Create New Storage Locations',
        'items' => [
            'Dashboard' => route('index'),
            'View All Storage Locations' => route('storage_location.index'),
            'Create New Storage Locations' => route('storage_location.create'),
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
                {{-- @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}

                @if($storage_location->id)
                    <form class="form-horizontal" method="POST" action="{{ route('storage_location.update',['id'=>$storage_location->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form class="form-horizontal" method="POST" action="{{ route('storage_location.store') }}">
                @endif
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">Code *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="code" name="code" required autofocus value="{{ $storage_location->code == null ? $storage_location_code: $storage_location->code }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required autofocus
                                @if($storage_location->name != null) value="{{ $storage_location->name }}"
                                @else value="{{ old('name') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="type" class="col-sm-2 control-label">Area (m<sup>2</sup>)</label>

                            <div class="col-sm-10">
                                <input type='text' class="form-control" id="area" name="area"
                                @if($storage_location->area != null) value="{{ $storage_location->area }}"
                                @else value="{{ old('area') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="description" name="description"
                                @if($storage_location->description != null) value="{{ $storage_location->description }}"
                                @else value="{{ old('description') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                                <label for="warehouse" class="col-sm-2 control-label">Warehouse *</label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="warehouse" id="warehouse" required>
                                        @foreach($warehouses as $warehouse)
                                            @if($storage_location->warehouse_id == $warehouse->id)
                                                <option value="{{ $warehouse->id }}" selected>{{$warehouse->name}}</option>
                                            @else
                                                <option value="{{ $warehouse->id }}">{{$warehouse->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">Status *</label>

                            <div class="col-sm-10">
                                <select class="form-control" name="status" id="status" required>
                                    <option value="1">Active</option>
                                    <option value="0">Not Active</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        @if($storage_location->id)
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
        $('#status').val("{{$storage_location->status}}");
        if($('#status').val()==null){
            $('#status').val(1);
        }

        $('#warehouse').val("{{$storage_location->warehouse}}");
        if($('#warehouse').val()==null){
            $('#warehouse').val(0);
        }

        $('#status').select({
            minimumResultsForSearch: -1
        });
        $('div.overlay').remove();
        $('.alert').addClass('animated bounce');
    });
    document.getElementById("code").readOnly = true;

    function validate(evt) {
    var theEvent = evt || window.event;

    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
    // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
    }
</script>

@endpush
