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
            <div class="box-header">
                <div class="box-tools pull-right">
                    <a href="{{ route('customer.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header -->
            <div class="box-body p-b-0 p-t-15">
                <table class="table table-bordered tablePaging tableFixed">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Code</th>
                            <th width="35%">Name</th>
                            <th width="40%">Address</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($customers as $customer)
                            <tr>
                                <td class="tdEllipsis">{{ $counter++ }}</td>
                                <td class="tdEllipsis">{{ $customer->code }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$customer->name}}">{{ $customer->name }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$customer->address}}">{{ $customer->address }}</td>
                                <td class="tdEllipsis" align="center">
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
        $('div.overlay').hide();
    });
</script>
@endpush
