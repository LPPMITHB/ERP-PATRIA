@extends('layouts.main')
@section('content-header')

@if($ship->id)
@breadcrumb(
    [
        'title' => 'Edit Ship',
        'items' => [
            'Dashboard' => route('index'),
            'View all Ships' => route('ship.index'),
            $ship->type => route('ship.show',$ship->id),
            'Edit' => route('ship.edit',$ship->id),
        ]
    ]
)
@endbreadcrumb
@else
@breadcrumb(
    [
        'title' => 'Create Ship',
        'items' => [
            'Dashboard' => route('index'),
            'View all Ships' => route('ship.index'),
            'Create' => route('ship.create'),
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
                @if($ship->id)
                    <form class="form-horizontal" method="POST" action="{{ route('ship.update',['id'=>$ship->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form class="form-horizontal" method="POST" action="{{ route('ship.store') }}">
                @endif
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Type</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="type" name="type" required autofocus value="{{ $ship->type }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="hull_number" class="col-sm-2 control-label">Hull Number</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="hull_number" name="hull_number" value={{ $ship->hull_number }}>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="description" name="description" value={{ $ship->description }}>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">Status</label>
            
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
                        @if($ship->id)
                            <button id="process" type="submit" class="btn btn-primary pull-right">SAVE</button>
                        @else
                            <button id="process" type="submit" class="btn btn-primary pull-right">CREATE</button>
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
        $('div.overlay').hide();
        $('#status').val("{{$ship->status}}");
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
