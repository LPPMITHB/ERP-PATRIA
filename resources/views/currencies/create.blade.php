@extends('layouts.main')
@section('content-header')

@if($currencies->id)
@breadcrumb(
    [
        'title' => 'Edit Currency',
        'subtitle' => 'Edit',
        'items' => [
            'Dashboard' => route('index'),
            'View All Currencies' => route('currencies.index'),
            'Edit Currency' => route('currencies.edit',$currencies->id),
        ]
    ]
)
@endbreadcrumb
@else
@breadcrumb(
    [
        'title' => 'Create Currency',
        'items' => [
            'Dashboard' => route('index'),
            'View All Currencies' => route('currencies.index'),
            'Create Currency' => route('currencies.create'),
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

                @if($currencies->id)
                    <form class="form-horizontal" method="POST" action="{{ route('currencies.update',['id'=>$currencies->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form class="form-horizontal" method="POST" action="{{ route('currencies.store') }}">
                @endif
                    @csrf
                    <div class="box-body">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
            
                            <div class="col-sm-10">
                                <select class="form-control" name="name" id="name" required>
                                    <option value="USD">USD</option>
                                    <option value="Euro">Euro</option>
                                    <option value="SGD">SGD</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="value" class="col-sm-2 control-label">Value(Rupiah)</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control"  onkeypress="validate(event)" id="value" name="value" required value="{{ $currencies->value }}">
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        @if($currencies->id)
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
        $('#name').val("{{$currencies->name}}");
        if($('#name').val()==null){
            $('#name').val(1);
        }
        $('#name').select({
            minimumResultsForSearch: -1
        });
        $('div.overlay').remove();
        $('.alert').addClass('animated bounce');
        

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
