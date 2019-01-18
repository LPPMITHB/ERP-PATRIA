@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Goods Return » Select Goods Receipt',
        'items' => [
            'Dashboard' => route('index'),
            'Select Goods Receipt' => "",
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
                <table class="table table-bordered tableFixed tablePaging" id="mr-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">GR Number</th>
                            <th width="20%">PO Number</th>
                            <th width="20%">Description</th>
                            <th width="25%">Project Name</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGRs as $modelGR)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $modelGR->number }}</td>
                                <td>{{ $modelGR->purchaseOrder->number }}</td>
                                <td>{{ $modelGR->description }}</td>
                                <td>{{ $modelGR->vendor->name }}</td>
                                <td class="p-l-0 p-r-0 textCenter">
                                    @if($menu == 'building')
                                        <a href="{{ route('goods_issue.createGiWithRef', ['id'=>$modelGR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
                                    @else
                                        <a href="{{ route('goods_issue_repair.createGiWithRef', ['id'=>$modelGR->id]) }}" class="btn btn-primary btn-xs">SELECT</a>
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
