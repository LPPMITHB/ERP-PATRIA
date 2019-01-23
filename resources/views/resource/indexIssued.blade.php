@extends('layouts.main')

@section('content-header')
@if($route == "/resource")
    @breadcrumb(
        [
            'title' => 'View All Issued Resource',
            'items' => [
                'Dashboard' => route('index'),
                'View All Issued Resource' => route('resource.indexIssued'),
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/resource_repair")
    @breadcrumb(
        [
            'title' => 'View All Issued Resource',
            'items' => [
                'Dashboard' => route('index'),
                'View All Issued Resource' => route('resource_repair.indexIssued'),
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
                <table class="table table-bordered tableFixed tablePaging">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">GI Number</th>
                            <th width="45%">Description</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGIs as $GI)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $GI->number }}</td>
                                <td>{{ $GI->description }}</td>
                                <td class="textCenter p-l-0 p-r-0">
                                    @if($route == "/resource")
                                        <a href="{{ route('resource.showGI', ['id'=>$GI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    @elseif($route == "/resource_repair")
                                        <a href="{{ route('resource_repair.showGI', ['id'=>$GI->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
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
