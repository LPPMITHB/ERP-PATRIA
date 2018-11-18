@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Customers',
        'items' => [
            'Dashboard' => route('index'),
            'View All Customers' => route('customer.index'),
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
                    <a href="{{ route('customer.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="box-body">
                {{-- <div style ="overflow:scroll"> --}}
                <table class="table table-bordered table-hover tableFixed " id="customer-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 10%">Code</th>
                            <th style="width: 35%">Name</th>
                            <th style="width: 35%">Address</th>
                            <th style="width: 10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="tdEllipsis">{{ $customer->code }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$customer->name}}">{{ $customer->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$customer->address}}">{{ $customer->address }}</td>
                                <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('customer.show', ['id'=>$customer->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('customer.edit', ['id'=>$customer->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- </div> --}}
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
        $('#customer-table').DataTable({
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
