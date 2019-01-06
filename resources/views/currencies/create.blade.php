@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage Currencies',
            'items' => [
                'Dashboard' => route('index'),
                'Manage Currencies' => '',
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
                <form class="form-horizontal" method="POST" action="{{ route('currencies.store') }}">
                @csrf
                    <div class="box-body">
                        
                        
                        <button type="submit" class="btn btn-primary pull-right">SAVE</button>
                    </div>
                </form>
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
