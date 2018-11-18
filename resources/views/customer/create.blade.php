@extends('layouts.main')
@section('content-header')

@if($customer->id)
@breadcrumb(
    [
        'title' => 'Edit Customer',
        'items' => [
            'Dashboard' => route('index'),
            'View All Customers' => route('customer.index'),
            $customer->name => route('customer.show',$customer->id),
            'Edit' => route('customer.edit',$customer->id),
        ]
    ]
)
@endbreadcrumb
@else
@breadcrumb(
    [
        'title' => 'Create New Customer',
        'items' => [
            'Dashboard' => route('index'),
            'View All Customers' => route('customer.index'),
            'Create New Customer' => route('customer.create'),
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
                

                @if($customer->id)
                    <form class="form-horizontal" method="POST" action="{{ route('customer.update',['id'=>$customer->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form class="form-horizontal" method="POST" action="{{ route('customer.store') }}">
                @endif
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">Code</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="code" name="code" required autofocus value="{{ $customer->code == null ? $customer_code: $customer->code }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required autofocus value="{{ $customer->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="type" class="col-sm-2 control-label">Address</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address" name="address" required value="{{ $customer->address }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_person_name" class="col-sm-2 control-label">Contact Person Name</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="contact_person_name" name="contact_person_name" required value="{{ $customer->contact_person_name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_person_email" class="col-sm-2 control-label">Contact Person E-mail</label>
            
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="contact_person_email" name="contact_person_email" required value="{{ $customer->contact_person_email }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_person_phone" class="col-sm-2 control-label">Contact Person Phone</label>
            
                            <div class="col-sm-10">
                                <input type="numeric" onkeypress="validate(event)" minlength="10" maxlength="13" class="form-control" id="contact_person_phone" name="contact_person_phone" required value="{{ $customer->contact_person_phone }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">Customer Status</label>
            
                            <div class="col-sm-10">
                                <select class="form-control" name="status" id="status" required>
                                    <option value="1">Active</option>
                                    <option value="0">Non Active</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        @if($customer->id)
                            <button type="submit" class="btn btn-primary pull-right">SAVE</button>
                        @else
                            <button type="submit" class="btn btn-primary pull-right">CREATE</button>
                        @endif
                    </div>
                    <!-- /.box-footer -->
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
        $('#status').val("{{$customer->status}}");
        if($('#status').val()==null){
            $('#status').val(1);
        }
        $('#status').select({
            minimumResultsForSearch: -1
        });
        $('div.overlay').remove();
        $('.alert').addClass('animated bounce');
    });
    document.getElementById("code").readOnly = true;
    
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
