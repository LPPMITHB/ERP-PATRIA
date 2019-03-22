@extends('layouts.main')
@section('content-header')

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
                    <form class="form-horizontal" method="POST" action="{{ route('service.store') }}">
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
                            <label for="name" class="col-sm-2 control-label">Ship Type</label>
                
                                <div class="col-sm-10">
                                    <select class="form-control" name="type" id="type" required>
                                        <option value="-1" selected>General</option>
                                        @foreach ($ships as $ship)
                                        <option value="{{$ship->id}}">{{$ship->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        {{-- <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">Status</label>
            
                            <div class="col-sm-10">
                                <select class="form-control" name="status" id="status" required>
                                    <option value="1">Active</option>
                                    <option value="0">Non Active</option>
                                </select>
                            </div>
                        </div> --}}
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">CREATE</button>
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

// function validate(evt) {
//     document.getElementById('cost_standard_price').value = document.getElementById('cost_standard_price').value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
// }
    
</script>
@endpush
