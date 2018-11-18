@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View All Currencies',
        'items' => [
            'Dashboard' => route('index'),
            'View All Currencies' => route('currencies.index'),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            {{-- <div class="box-header m-b-10">
                <div class="box-tools pull-right p-t-5">
                    <a href="{{ route('currencies.create') }}" class="btn btn-primary btn-sm">CREATE</a>
                </div>
            </div> <!-- /.box-header --> --}}
            <div class="box-body">
            {{-- <div style ="overflow:scroll"> --}}
                <table class="table table-bordered table-hover tableFixed" id="currencies-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 78%">Name</th>
                            <th style="width: 17%">Value(Rupiah)</th>
                            {{-- <th></th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($currencies as $currency)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$currency->name}}">{{ $currency->name }}</td>
                                <td class="no-padding"> 
                                    <input type="text" class="form-control width100"  onkeypress="validate(event)" id="value" name="value" required value="{{ $currency->value }}">
                                </td>
                                {{-- <td class="p-l-0 p-r-0" align="center">
                                    <a href="{{ route('currencies.edit',['id'=>$currency->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                </td> --}}
                                
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
        $('#currencies-table').DataTable({
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

    function validate(evt) {
        var theEvent = evt || window.event;

        // Handle paste
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
        // Handle key press
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9]|\./;
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>
@endpush
