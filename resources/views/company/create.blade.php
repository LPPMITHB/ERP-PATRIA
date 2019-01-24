@extends('layouts.main')
@section('content-header')

@if($company->id)
@breadcrumb(
    [
        'title' => 'Edit Company',
        'items' => [
            'Dashboard' => route('index'),
            'Companies' => route('company.index'),
            $company->name => route('company.show',$company->id),
            'Edit' => route('company.edit',$company->id),
        ]
    ]
)
@endbreadcrumb
@else
@breadcrumb(
    [
        'title' => 'Create New Company',
        'items' => [
            'Dashboard' => route('index'),
            'View All Companies' => route('company.index'),
            'Create New Company' => route('company.create'),
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
                {{-- @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}

                @if($company->id)
                    <form class="form-horizontal" method="POST" action="{{ route('company.update',['id'=>$company->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form class="form-horizontal" method="POST" action="{{ route('company.store') }}">
                @endif
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">Code</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="code" name="code" required autofocus value="{{ $company->code == null ? $company_code: $company->code }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required autofocus 
                                @if($company->name != null)value="{{ $company->name }}"
                                @else value = "{{ old('name') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">Address</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="adress" name="address" required 
                                @if($company->address != null) value="{{ $company->address }}"
                                @else value = "{{ old('address')}}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone_number" class="col-sm-2 control-label">Phone Number</label>
            
                            <div class="col-sm-10">
                                <input type="text" onkeypress="validate(event)" minlength="10" maxlength="12" class="form-control" id="phone_number" name="phone_number"  required 
                                @if($company->phone_number != null) value="{{ $company->phone_number }}"
                                @else value = "{{ old('phone_number')}}"
                                @endif>
                            </div>
                        </div>
                        
                        <div class="form-group">
                                <label for="fax" class="col-sm-2 control-label">Fax</label>

                                <div class="col-sm-10">
                                    <input type="text" onkeypress="validate(event)" minlength="10" maxlength="12" class="form-control" id="fax" name="fax" 
                                    @if($company->fax != null) value="{{ $company->fax }}"
                                    @else value = "{{ old('fax')}}"
                                    @endif>
                                </div>
                            </div>

                        <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Email</label>
                    
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" required 
                                    @if($company->email != null) value="{{ $company->email }}"
                                    @else value = "{{ old('email')}}"
                                    @endif>
                                </div>
                            </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">Status</label>
            
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
                        @if($company->id)
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
        $('#status').val("{{$company->status}}");
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
