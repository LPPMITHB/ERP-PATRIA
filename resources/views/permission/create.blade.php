@extends('layouts.main')
@section('content-header')

@breadcrumb(
    [
        'title' => 'Create Permission',
        'items' => [
            'Dashboard' => route('index'),
            'View All Permissions' => route('permission.index'),
            'Create Permissions' => route('permission.create'),
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
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="form-horizontal" method="POST" action="{{ route('permission.store') }}">
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required autofocus value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="middleware" class="col-sm-2 control-label">Middleware</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="middleware" name="middleware" required value="{{ old('middleware') }}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="menu" class="col-sm-2 control-label">Menu</label>
            
                            <div class="col-sm-10">
                                    <select name="menu" id="menu" required>
                                    <option></option>
                                    @foreach($menus as $name => $id)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
        $('#menu').val("{{ old('menu') }}");
        $('#menu').selectize();
        $('div.overlay').remove();
        $('.alert').addClass('animated bounce');
    });
    document.getElementById("name").onkeyup = function() {insertToMiddleware()};
    document.getElementById("middleware").readOnly = true;

    function insertToMiddleware() {
        var name = document.getElementById("name").value;
        name=name.replace(/ /g,"-");
        document.getElementById("middleware").value = name.toLowerCase();
    }
</script>
@endpush
