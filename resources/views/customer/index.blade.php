@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Customers',
        'items' => [
            'Dashboard' => route('index'),
            'View All Customers' => '',
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
                <div class="col-sm-6 p-l-0">
                    <div class="box-tools pull-left">
                        <a href="{{ route('customer.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                    </div>
                </div>
                <table id="customer-table" class="table table-bordered tableFixed">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Code</th>
                            <th width="35%">Name</th>
                            <th width="40%">Address</th>
                            <th width="10%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($customers as $customer)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="tdEllipsis">{{ $customer->code }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$customer->name}}">{{ $customer->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$customer->address_1}}">{{ $customer->address_1 }}</td>
                                <td>{{ $customer->status =="1" ? "Active":"Non Active" }}</td>
                                <td align="center">
                                    <a href="{{ route('customer.show', ['id'=>$customer->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                    <a href="{{ route('customer.edit', ['id'=>$customer->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
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
        $('#customer-table').DataTable({
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
