@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Goods Movement',
        'items' => [
            'Dashboard' => route('index'),
            'View Goods Movement' => route('goods_movement.show',$modelGM->id),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-blue">
            <div class="row">
                <div class="col-sm-3 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">GM Number</span>
                            <span class="info-box-number">{{ $modelGM->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-4">
                            Storage Location From
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelGM->storageLocationFrom->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Storage Location To
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelGM->storageLocationTo->name }} </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            Description
                        </div>
                        <div class="col-md-8">
                            : <b> {{ $modelGM->description }} </b>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 m-t-10">
                    <div class="row">
                        <div class="col-md-5">
                            Created By
                        </div>
                        <div class="col-md-7">
                            : <b> {{ $modelGM->user->name }} </b>
                        </div>
                        <div class="col-md-5">
                            Created At
                        </div>
                        <div class="col-md-7">
                            : <b> {{ $modelGM->created_at }} </b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-body p-t-0 p-b-0">
                <table class="table table-bordered showTable" id="boms-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">Material Code</th>
                            <th width="40%">Material Name</th>
                            <th width="25%">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGM->goodsMovementDetails as $GMD)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $GMD->material->code }}</td>
                                <td>{{ $GMD->material->name }}</td>
                                <td>{{ number_format($GMD->quantity) }}</td>
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
        $('#boms-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').remove();
            }
        });
    });
</script>
@endpush
