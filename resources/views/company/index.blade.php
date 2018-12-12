@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Companies',
        'subtitle' => 'Index',
        'items' => [
            'Dashboard' => route('index'),
            'View All Companies' => route('company.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header m-b-10">
                <div class="box-tools pull-right p-t-5">
                    <a href="{{ route('company.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-hover" id="company-table">
                    <thead>
                        <tr>
                            <th style ="width: 5%">No</th>
                            <th style ="width: 10%">Code</th>
                            <th style ="width: 35%">Name</th>
                            <th style ="width: 20%">Phone Number</th>
                            <th style ="width: 20%">Email</th>
                            <th style ="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($companies as $company)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $company->code }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$company->name}}">{{ $company->name }}</td>
                                <td>{{ $company->phone_number }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$company->email}}">{{ $company->email }}</td>
                                <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('company.show', ['id'=>$company->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('company.edit',['id'=>$company->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
        $('#company-table').DataTable({
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
