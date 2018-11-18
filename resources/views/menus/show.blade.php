@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Menu',
        'items' => [
            'Dashboard' => route('index'),
            'View All Menus' => route('menus.index'),
            'Menu' => route('menus.show', ['id' => $menu->id]),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box box-solid">
            <div class="box-header">
            <div class="box-title"></div>
            <div class="box-tools pull-right p-t-5">
                <a href="{{ route('menus.edit',['id'=>$menu->id]) }}" class="btn btn-primary btn-sm">EDIT</a>
                <!-- {{-- <a href="{{ route('menus.destroy',['id'=>$menu->id]) }}" class="btn btn-danger btn-sm">DELETE</a> --}}
                <button class="btn btn-danger btn-sm" onclick="event.preventDefault();document.getElementById('delete-form-{{ $menu->id }}').submit();">DELETE</button>

                <form id="delete-form-{{ $menu->id }}" action="{{ route('menus.destroy', ['id' => $menu->id]) }}" method="POST" style="display: none;">
                    <input type="hidden" name="_method" value="DELETE">
                    @csrf
                </form> -->
            </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover showTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Attribute</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Level</td>
                            <td>{{ $menu->level }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Name</td>
                            <td>{{ $menu->name }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Icon</td>
                            <td class="iconTd"><i class="fa {{ $menu->icon }}"></i></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Route Name</td>
                            <td>
                                @if(Route::has($menu->route_name))
                                    <a target="_blank" href="{{ route($menu->route_name) }}">{{ route($menu->route_name) }}</a>
                                @else
                                    No route specify for this menu
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Active</td>
                            <td class="iconTd"><i class="fa {{ $menu->is_active == 1 ? 'fa-check' : 'fa-times' }}"></i></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Roles</td>
                            <td>{{ $menu->roles }}</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Parent</td>
                            <td>{{ $menu->menu->name ?? 'This is a parent menu' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection