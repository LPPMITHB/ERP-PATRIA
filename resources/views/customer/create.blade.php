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
                                <input type="text" class="form-control" id="name" name="name" required autofocus 
                                @if($customer->name != null) value="{{ $customer->name }}"
                                @else value="{{ old('name') }}"
                                @endif
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="type" class="col-sm-2 control-label">Address 1</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address_1" name="address_1"  
                                @if($customer->address_1 != null) value="{{ $customer->address_1 }}"
                                @else value="{{ old('address_1') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                                <label for="type" class="col-sm-2 control-label">Address 2</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="address_2" name="address_2" 
                                    @if($customer->address_2 != null) value="{{ $customer->address_2 }}"
                                    @else value="{{ old('address_2') }}"
                                    @endif>
                                </div>
                            </div>

                        <div class="form-group">
                            <label for="phone_number_1" class="col-sm-2 control-label">Phone Number 1</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" onkeypress="validate(event)" minlength="10" maxlength="11" id="phone_number_1" name="phone_number_1"
                                @if($customer->phone_number_1 != null) value="{{ $customer->phone_number_1 }}"
                                @else value="{{ old('phone_number_1') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone_number_2" class="col-sm-2 control-label">Phone Number 2</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" onkeypress="validate(event)" minlength="10" maxlength="11" id="phone_number_2" name="phone_number_2"
                                @if($customer->phone_number_2 != null) value="{{ $customer->phone_number_2 }}"
                                @else value="{{ old('phone_number_2') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_name" class="col-sm-2 control-label">Contact Name</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="contact_name" name="contact_name" 
                                @if($customer->contact_name != null) value="{{ $customer->contact_name }}"
                                @else value="{{ old('contact_name') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
            
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" name="email"
                                @if($customer->email != null) value="{{ $customer->email }}"
                                @else value="{{ old('email') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tax_number" class="col-sm-2 control-label">Tax Number</label>
            
                            <div class="col-sm-10">
                                <input type="numeric" onkeypress="validate(event)" class="form-control" id="tax_number" name="tax_number"
                                @if($customer->tax_number != null) value="{{ $customer->tax_number }}"
                                @else value="{{ old('tax_number') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pkp_number" class="col-sm-2 control-label">Pkp Number</label>
            
                            <div class="col-sm-10">
                                <input type="numeric" onkeypress="validate(event)" class="form-control" id="pkp_number" name="pkp_number"
                                @if($customer->pkp_number != null) value="{{ $customer->pkp_number }}"
                                @else value="{{ old('pkp_number') }}"
                                @endif>
                        </div>
                    </div>

                        <div class="form-group">
                            <label for="province" class="col-sm-2 control-label">Province</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="province" name="province"
                                @if($customer->province != null) value="{{ $customer->province }}"
                                @else value="{{ old('province') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="zip_code" class="col-sm-2 control-label">Zip Code</label>
            
                            <div class="col-sm-10">
                                <input type="numeric" onkeypress="validate(event)" minlength="4" maxlength="5" class="form-control" id="zip_code" name="zip_code"
                                @if($customer->zip_code != null) value="{{ $customer->zip_code }}"
                                @else value="{{ old('zip_code') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="country" class="col-sm-2 control-label">Country</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="country" name="country"
                                @if($customer->country != null) value="{{ $customer->country }}"
                                @else value="{{ old('country') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="businessUnit" class="col-sm-2 control-label">Business Unit</label>
            
                            <div class="col-sm-10">
                                <select id="businessUnit" name="businessUnit" placeholder="Select Business Unit..">
                                    @foreach ($businessUnits as $businessUnit)
                                        <option value="{{$businessUnit->id}}">{{$businessUnit->name}}</option>
                                    @endforeach
                                </select>
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
        $('#businessUnit').selectize();
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
