@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Material Write Off',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'View All Material Write Off' => '',
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            {{-- <div class="box-header p-b-20">
                <div class="box-tools pull-right p-t-5">
                    <a href="{{ route('material_write_off.selectPR') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header --> --}}
            <div class="box-body">
                <table class="table table-bordered tableFixed tablePaging">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Number</th>
                            <th width="35%">Description</th>
                            <th width="15%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelWriteOffs as $modelWriteOff)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelWriteOff->number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelWriteOff->description}}">{{ $modelWriteOff->description }}</td>
                                @if($modelWriteOff->status == 1)
                                    <td>OPEN</td>
                                    <td class="textCenter">
                                        @if($route == "/material_write_off")
                                            <a href="{{ route('material_write_off.edit', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('material_write_off.show', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/material_write_off_repair")
                                            <a href="{{ route('material_write_off_repair.edit', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('material_write_off_repair.show', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelWriteOff->status == 2)
                                    <td>APPROVED</td>
                                    <td class="textCenter">
                                        @if($route == "/material_write_off")
                                            <a href="{{ route('material_write_off.show', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/material_write_off_repair")
                                            <a href="{{ route('material_write_off_repair.show', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelWriteOff->status == 3)
                                    <td>NEED REVISION</td>
                                    <td class="textCenter">
                                        @if($route == "/material_write_off")
                                            <a href="{{ route('material_write_off.edit', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('material_write_off.show', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/material_write_off_repair")
                                            <a href="{{ route('material_write_off_repair.edit', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('material_write_off_repair.show', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelWriteOff->status == 4)
                                    <td>REVISED</td>
                                    <td class="textCenter">
                                        @if($route == "/material_write_off")
                                            <a href="{{ route('material_write_off.edit', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('material_write_off.show', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/material_write_off_repair")
                                            <a href="{{ route('material_write_off_repair.edit', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                            <a href="{{ route('material_write_off_repair.show', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @elseif($modelWriteOff->status == 5)
                                    <td>REJECTED</td>
                                    <td class="textCenter">
                                        @if($route == "/material_write_off")
                                            <a href="{{ route('material_write_off.show', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/material_write_off_repair")
                                            <a href="{{ route('material_write_off_repair.show', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @else
                                    <td>ISSUED</td>
                                    <td class="textCenter">
                                        @if($route == "/material_write_off")
                                            <a href="{{ route('material_write_off.show', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @elseif($route == "/material_write_off_repair")
                                            <a href="{{ route('material_write_off_repair.show', ['id'=>$modelWriteOff->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
    });
</script>
@endpush
