@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Edit Material',
        'items' => [
            'Dashboard' => route('index'),
            'View All Materials' => route('material.index'),
            $material->name => route('material.show',$material->id),
            'Edit Material' => route('material.edit',$material->id),
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
                <form id="edit-material" class="form-horizontal" method="POST" action="{{ route('material.update',['id'=>$material->id]) }}">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="box-body">

                        @verbatim
                        <div id="material">
                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">Code</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="code" name="code" required autofocus disabled v-model="submittedForm.code">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" required autofocus v-model="submittedForm.name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description</label>
            
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="description" v-model="submittedForm.description">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cost_standard_price" class="col-sm-2 control-label">Cost Standard Price</label>
            
                            <div class="col-sm-10">
                                <input type="text" onkeypress="validate(event)" class="form-control" id="cost_standard_price" required v-model="submittedForm.cost_standard_price">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="weight" class="col-sm-2 control-label">Weight</label>
            
                            <div class="col-sm-10">
                                <input type="text" onkeypress="validate(event)" class="form-control" id="weight" v-model="submittedForm.weight">
                            </div>
                        </div>
                        
                            <div class="form-group">
                                <label for="height" class="col-sm-2 control-label">Height</label>
                
                                <div class="col-sm-10">
                                    <input type="text" onkeypress="validate(event)" class="form-control" id="height" v-model="submittedForm.height" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="length" class="col-sm-2 control-label">Length</label>
                
                                <div class="col-sm-10">
                                    <input type="text" onkeypress="validate(event)" class="form-control" id="lengths" v-model="submittedForm.lengths" >
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="width" class="col-sm-2 control-label">Width</label>
                
                                <div class="col-sm-10">
                                    <input type="text" onkeypress="validate(event)" class="form-control" id="width" v-model="submittedForm.width"  >
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="volume" class="col-sm-2 control-label">Volume</label>
                
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="volume" v-model="submittedForm.volume" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-sm-2 control-label">Type</label>
                
                                <div class="col-sm-10">
                                    <select v-model="submittedForm.type" class="form-control" name="type" id="type" required>
                                        <option value="3">Bulk part</option>
                                        <option value="2">Component</option>
                                        <option value="1">Consumable</option>
                                        <option value="0">Raw</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">Status</label>
                
                                <div class="col-sm-10">
                                    <select v-model="submittedForm.status" class="form-control" name="status" id="status" required>
                                        <option value="1">Active</option>
                                        <option value="0">Non Active</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button @click.prevent="submitForm" type="submit" class="btn btn-primary pull-right">SAVE</button>
                            </div>
                        </div>
                        @endverbatim
                    <!-- /.box-footer -->
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
    const form = document.querySelector('form#edit-material');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        
        submittedForm :{
            code : @json($material->code),
            name : @json($material->name),
            description : @json($material->description),
            cost_standard_price : @json($material->cost_standard_price),
            weight : @json($material->weight),
            height :@json($material->height),
            lengths :@json($material->length),
            width :@json($material->width),
            volume :@json($material->volume),
            status : @json($material->status),
            type : @json($material->type),
        }
    }

    var vm = new Vue({
        el : '#material',
        data: data,
        methods : {
            submitForm(){
                this.submittedForm.cost_standard_price = this.submittedForm.cost_standard_price.replace(/,/g , '');
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        watch:{
            submittedForm: {
                handler: function(newValue){
                    if(this.submittedForm.height == "" || this.submittedForm.lengths == "" || this.submittedForm.width == ""){
                        this.submittedForm.volume = 0;
                    }else{
                        this.submittedForm.volume = this.submittedForm.height * this.submittedForm.lengths * this.submittedForm.width;
                    }
                },
                deep: true
            },
            'submittedForm.cost_standard_price': function(newValue) {
                this.submittedForm.cost_standard_price = (this.submittedForm.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");      
            },
        
        },
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
