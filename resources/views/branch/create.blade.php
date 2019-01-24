@extends('layouts.main')
@section('content-header')

@if($branch->id)
@breadcrumb(
    [
        'title' => 'Edit Branch',
        'subtitle' => 'Edit',
        'items' => [
            'Dashboard' => route('index'),
            'View All Branches' => route('branch.index'),
            $branch->name => route('branch.show',$branch->id),
            'Edit Branch' => route('branch.edit',$branch->id),
        ]
    ]
)
@endbreadcrumb
@else
@breadcrumb(
    [
        'title' => 'Create Branch',
        'items' => [
            'Dashboard' => route('index'),
            'View All Branches' => route('branch.index'),
            'Create Branch' => route('branch.create'),
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
                <!-- @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif -->

                @if($branch->id)
                    <form class="form-horizontal" method="POST" action="{{ route('branch.update',['id'=>$branch->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form class="form-horizontal" method="POST" action="{{ route('branch.store') }}">
                @endif
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">Code</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="code" name="code" required autofocus value="{{ $branch->code == null ? $branch_code: $branch->code }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required autofocus
                                @if($branch->name != null) value="{{ $branch->name }}"
                                @else value="{{ old('name') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">Address</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address" name="address" required
                                @if($branch->address != null) value="{{ $branch->address }}"
                                @else value="{{ old('address') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone_number" class="col-sm-2 control-label">Phone Number</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" onkeypress="validate(event)" minlength="10" maxlength="11" id="phone_number" name="phone_number" required
                                @if($branch->phone_number != null) value="{{ $branch->phone_number }}"
                                @else value="{{ old('phone_number') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fax" class="col-sm-2 control-label">Fax</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" onkeypress="validate(event)" minlength="10" maxlength="11" id="fax" name="fax"
                                @if($branch->fax != null) value="{{ $branch->fax }}"
                                @else value="{{ old('fax') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" name="email" required
                                @if($branch->email != null) value="{{ $branch->email }}"
                                @else value="{{ old('email') }}"
                                @endif>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company" class="col-sm-2 control-label">Company</label>
            
                            <div class="col-sm-10">
                                <select class="form-control" name="company" id="company" required>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{$company->name}}</option>
                                    @endforeach
                                </select>
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
                        @if($branch->id)
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
        $('#status').val("{{$branch->status}}");
        if($('#status').val()==null){
            $('#status').val(1);
        }
        $('#status').select({
            minimumResultsForSearch: -1
        });
        $('div.overlay').remove();
        $('.alert').addClass('animated bounce');
    

    
        $('#company').val("{{$branch->company_id}}");
        if($('#company').val()==null){
            $('#company').val(1);
        }
        $('#company').select({
            minimumResultsForSearch: -1
        });
        $('div.overlay').remove();
        $('.alert').addClass('animated bounce');

        $("#phone_number").inputmask();
        $("#fax").inputmask();

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
