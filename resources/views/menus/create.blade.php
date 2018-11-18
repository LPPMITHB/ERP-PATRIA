@extends('layouts.main')

@section('content-header')
@if(isset($menu->id))
    @breadcrumb(
        [
            'title' => 'Edit Menu',
            'items' => [
                'Dashboard' => route('index'),
                'View All Menus' => route('menus.index'),
                'Edit Menu' => route('menus.create'),
            ]
        ]
    )
    @endbreadcrumb
@else
    @breadcrumb(
    [
        'title' => 'Create Menu',
        'items' => [
            'Dashboard' => route('index'),
            'View All Menus' => route('menus.index'),
            'Create Menu' => route('menus.create'),
        ]
    ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
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

                @if($menu->id)
                <form class="form-horizontal" method="POST" action="{{ route('menus.update',['id'=>$menu->id]) }}">
                <input type="hidden" name="_method" value="PATCH">
                @else
                <form class="form-horizontal" method="POST" action="{{ route('menus.store') }}">
                @endif
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                        <label for="level" class="col-sm-2 control-label">Level</label>
        
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="level" name="level" required autofocus value="{{ $menu->level }}">
                        </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required value="{{ $menu->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="icon" class="col-sm-2 control-label">Icon</label>
            
                            <div class="col-sm-10">
                                <select name="icon" id="icon" required>
                                    <option></option>
                                    @foreach($fontAwesomeIcons as $icon)
                                        <option value="{{ $icon }}">{{ $icon }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="route_name" class="col-sm-2 control-label">Route Name</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="route_name" name="route_name" required value="{{ $menu->route_name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="is_active" class="col-sm-2 control-label">Active</label>
            
                            {{-- <div class="col-sm-10">
                                <input type="text" class="form-control" id="is_active" name="is_active" required>
                            </div> --}}
                            <div class="col-sm-10">
                                <div class="checkbox icheck">
                                    <label>
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ $menu->is_active == 0 ? '' : 'checked' }}>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="roles" class="col-sm-2 control-label">Roles</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="roles" name="roles" required value="{{ $menu->roles }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="parent_id" class="col-sm-2 control-label">Parent</label>
            
                            <div class="col-sm-10">
                                <select name="parent_id" id="parent_id">
                                    <option></option>
                                    @foreach($parentMenus as $name => $id)
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
        $('#parent_id').val("{{ $menu->menu_id }}");
        $('#icon').val("{{ $menu->icon }}");
        $('#parent_id').selectize();
        $('#icon').selectize();
        $('div.overlay').remove();
        $('.alert').addClass('animated bounce');
    });
</script>
@endpush
