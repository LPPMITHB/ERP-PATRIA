@extends('layouts.main')
@section('content-header')

@if($service->id)
@breadcrumb(
    [
        'title' => 'Edit Service',
        'subtitle' => 'Edit',
        'items' => [
            'Dashboard' => route('index'),
            'View All Services' => route('service.index'),
            $service->name => route('service.show',$service->id),
            'Edit Service' => route('service.edit',$service->id),
        ]
    ]
)
@endbreadcrumb
@else
@breadcrumb(
    [
        'title' => 'Create Service',
        'items' => [
            'Dashboard' => route('index'),
            'View All Services' => route('service.index'),
            'Create Service' => route('service.create'),
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

                @if($service->id)
                    <form class="form-horizontal" method="POST" action="{{ route('service.update',['id'=>$service->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form class="form-horizontal" method="POST" action="{{ route('service.store') }}">
                @endif
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">Code</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="code" name="code" required autofocus value="{{ $service->code == null ? $service_code: $service->code }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required autofocus 
                                @if($service->name != null) value="{{ $service->name }}"
                                @else value="{{ old('name') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="description" name="description" 
                                @if($service->description != null) value="{{ $service->description }}"
                                @else value="{{ old('description') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cost_standard_price" class="col-sm-2 control-label">Cost Standard Price</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" onkeyup="validate(event)" id="cost_standard_price" name="cost_standard_price" required value="{{ number_format($service->cost_standard_price) }}">
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
                        @if($service->id)
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
        $('#status').val("{{$service->status}}");
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
    document.getElementById('cost_standard_price').value = document.getElementById('cost_standard_price').value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
    
</script>
@endpush
