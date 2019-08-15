@extends('layouts.main')
@section('content-header')

@if($warehouse->id)
@breadcrumb(
    [
        'title' => 'Update Warehouse',
        'items' => [
            'Dashboard' => route('index'),
            'View All Warehouses' => route('warehouse.index'),
            $warehouse->name => route('warehouse.show',$warehouse->id),
            'Update' => route('warehouse.edit',$warehouse->id),
        ]
    ]
)
@endbreadcrumb
@else
@breadcrumb(
    [
        'title' => 'Create New Warehouse',
        'items' => [
            'Dashboard' => route('index'),
            'View All Warehouses' => route('warehouse.index'),
            'Create New Warehouses' => route('warehouse.create'),
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

                @if($warehouse->id)
                    <form class="form-horizontal" method="POST" action="{{ route('warehouse.update',['id'=>$warehouse->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form class="form-horizontal" method="POST" action="{{ route('warehouse.store') }}">
                @endif
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">Code *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="code" name="code" required autofocus value="{{ $warehouse->code == null ? $warehouse_code: $warehouse->code }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name *</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required autofocus
                                @if($warehouse->name != null) value="{{ $warehouse->name }}"
                                @else value="{{ old('name') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="description" name="description"
                                @if($warehouse->description != null) value="{{ $warehouse->description }}"
                                @else value="{{ old('description') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pic" class="col-sm-2 control-label">Person In-Charge</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="pic" id="pic">
                                    @foreach($users as $pic)
                                    <option value="{{ $pic->id }}">{{ $pic->name }}</option>
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
                        @if($warehouse->id)
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

    var data = {
        pics: @json($users),
    };

    $(document).ready(function(){
        $('#status').val("{{$warehouse->status}}");
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
