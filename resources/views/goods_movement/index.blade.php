@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Goods Movements',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'View All Goods Movements' => route('goods_movement.index'),
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
                <table class="table table-bordered tableFixed tablePaging" id="gi-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Number</th>
                            <th width="25%">Description</th>
                            <th width="20%">Storage Location From</th>
                            <th width="20%">Storage Location To</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGMs as $modelGM)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelGM->number }}</td>
                                <td>{{ $modelGM->description }}</td>
                                <td>{{ $modelGM->storageLocationFrom->name}}</td>
                                <td>{{ $modelGM->storageLocationTo->name}}</td>
                                <td align="center">
                                    @if($route == "/goods_movement")
                                        <a href="{{ route('goods_movement.show', ['id'=>$modelGM->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @elseif($route == "/goods_movement_repair")
                                        <a href="{{ route('goods_movement_repair.show', ['id'=>$modelGM->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @endif
                                </td>
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
