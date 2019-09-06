@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'Post Complaints » Select Project',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('delivery_document.selectProject'),
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
                <table class="table table-hover table-striped" id="project-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Project Name</th>
                            <th width="30%">Customer</th>
                            <th width="25%">Ship</th>
                            <th width="25%"></th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelProject as $project)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->customer->name }}</td>
                                <td>{{ $project->ship->type }}</td>
                                <td>
                                    <span class="pull-right-container">
                                        @if ($project->new_post)
                                            <small class="label bg-green">{{$project->new_post_qty}} new post(s)</small>
                                        @endif
                                        @if ($project->new_comment)
                                            <small class="label bg-green">{{$project->new_comment_qty}} new comment(s)</small>
                                        @endif
                                    </span>
                                </td>
                                <td class="p-l-5 p-r-5" align="center">
                                    <a class="btn btn-primary btn-xs" href="{{ route('customer_portal.selectPost', ['id'=>$project->id]) }}">SELECT</a>
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
        $('#project-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'bFilter'     : true,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
    });
</script>
@endpush