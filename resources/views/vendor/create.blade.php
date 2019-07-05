@extends('layouts.main')
@section('content-header')

@if($vendor->id)
@breadcrumb(
    [
        'title' => 'Edit Vendor',
        'items' => [
            'Dashboard' => route('index'),
            'View All Vendors' => route('vendor.index'),
            $vendor->name => route('vendor.show',$vendor->id),
            'Edit Vendor' => route('vendor.edit',$vendor->id),
        ]
    ]
)
@endbreadcrumb
@else
@breadcrumb(
    [
        'title' => 'Create Vendor',
        'items' => [
            'Dashboard' => route('index'),
            'View All Vendors' => route('vendor.index'),
            'Create Vendor' => route('vendor.create'),
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

                @if($vendor->id)
                    <form class="form-horizontal" method="POST" action="{{ route('vendor.update',['id'=>$vendor->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form class="form-horizontal" method="POST" action="{{ route('vendor.store') }}">
                @endif
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">Code *</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="code" name="code" required autofocus value="{{ $vendor->code == null ? $vendor_code: $vendor->code }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name *</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required autofocus
                                @if($vendor->name != null) value="{{ $vendor->name }}"
                                @else value="{{ old('name') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="type" class="col-sm-2 control-label">Type *</label>
            
                            <div class="col-sm-10">
                                <select class="form-control" name="type" id="type" required>
                                    @foreach($vendor_categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">Address</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address" name="address" 
                                @if($vendor->address != null) value="{{ $vendor->address }}"
                                @else value="{{ old('address') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone_number_1" class="col-sm-2 control-label">Phone Number 1</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" onkeypress="validate(event)" minlength="10" maxlength="11" name="phone_number_1"
                                @if($vendor->phone_number_1 != null) value="{{ $vendor->phone_number_1 }}"
                                @else value="{{ old('phone_number_1') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone_number_2" class="col-sm-2 control-label">Phone Number 2</label>
            
                            <div class="col-sm-10">
                            <input type="text" class="form-control" onkeypress="validate(event)" minlength="10" maxlength="11" name="phone_number_2"
                            @if($vendor->phone_number_2 != null) value="{{ $vendor->phone_number_2 }}"
                            @else value="{{ old('phone_number_2') }}"
                            @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_name" class="col-sm-2 control-label">Contact Name</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="contact_name" name="contact_name"
                                @if($vendor->contact_name != null) value="{{ $vendor->contact_name }}"
                                @else value="{{ old('contact_name') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
            
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" name="email" 
                                @if($vendor->email != null) value="{{ $vendor->email }}"
                                @else value="{{ old('email') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="delivery_term" class="col-sm-2 control-label">Delivery Term</label>
            
                            <div class="col-sm-10">
                                <select class="form-control" name="delivery_term" id="delivery_term">
                                    <option value="" selected >Select Delivery Term</option>
                                    @foreach($delivery_terms as $delivery_term)
                                        <option value="{{$delivery_term->id}}">{{ $delivery_term->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="payment_term" class="col-sm-2 control-label">Payment Term</label>
            
                            <div class="col-sm-10">
                                <select class="form-control" name="payment_term" id="payment_term">
                                    <option value="" selected >Select Payment Term</option>
                                    @foreach($payment_terms as $payment_term)
                                        <option value="{{$payment_term->id}}">{{ $payment_term->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="description" name="description"
                                @if($vendor->description != null) value="{{ $vendor->description }}"
                                @else value="{{ old('description') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">Status *</label>
            
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
                        @if($vendor->id)
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
        $('#status').val("{{$vendor->status}}");
        if($('#status').val()==null){
            $('#status').val(1);
        }
        $('#type').val("{{$vendor->type}}");
        if($('#type').val()==null){
            $('#type').val(1);
        }
        $('#status').select({
            minimumResultsForSearch: -1
        });

        $('#delivery_term').val("{{$vendor->delivery_term}}");
        if($('#delivery_term').val()==null){
            $('#delivery_term').val("");
        }

        $('#payment_term').val("{{$vendor->payment_term}}");
        if($('#payment_term').val()==null){
            $('#payment_term').val("");
        }
        
        $('div.overlay').remove();
        $('.alert').addClass('animated bounce');

        $("#phone_number").inputmask();
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
