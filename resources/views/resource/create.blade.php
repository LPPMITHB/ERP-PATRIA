@extends('layouts.main')
@section('content-header')

@if($resource->id)
@breadcrumb(
    [
        'title' => 'Edit Resource',
        'subtitle' => 'Edit',
        'items' => [
            'Dashboard' => route('index'),
            'View All Resources' => route('resource.index'),
            $resource->name => route('resource.show',$resource->id),
            'Edit Resource' => route('resource.edit',$resource->id),
        ]
    ]
)
@endbreadcrumb
@else
@breadcrumb(
    [
        'title' => 'Create Resource',
        'items' => [
            'Dashboard' => route('index'),
            'View All Resources' => route('resource.index'),
            'Create Resource' => route('resource.create'),
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
                @if($resource->id)
                    <form id="resource" class="form-horizontal" method="POST" action="{{ route('resource.update',['id'=>$resource->id]) }}">
                    <input type="hidden" name="_method" value="PATCH">
                @else
                    <form id="resource" class="form-horizontal" method="POST" action="{{ route('resource.store') }}">
                @endif
                @csrf
                @verbatim
                    <div id="resource">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="code" class="col-sm-2 control-label">Code</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"  required v-model="resource_code" disabled>
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" required autofocus v-model="dataInput.name">
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Description</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="description" name="description" v-model="dataInput.description">
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label for="type" class="col-sm-2 control-label">Type</label>
                                <div class="col-sm-10">
                                    <selectize v-model="dataInput.type" :settings="typeSettings">
                                        <option value="1">{{'Internal'}}</option>
                                        <option value="0">{{'External'}}</option>
                                    </selectize>
                                </div>
                            </div>

                            <div class="form-group" v-if="dataInput.type == 1">
                                <label for="quantity" class="col-sm-2 control-label">Quantity</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="quantity" name="quantity" v-model="dataInput.quantity">
                                </div>
                            </div>

                            <div class="form-group" v-if="dataInput.type == null || dataInput.type == ''">
                                <label for="quantity" class="col-sm-2 control-label">Quantity</label>
                
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="quantity" name="quantity" v-model="dataInput.quantity" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="uom" class="col-sm-2 control-label">Category</label>
                
                                <div class="col-sm-10">
                                    <selectize v-model="dataInput.category" :settings="categorySettings">
                                        <option v-for="(category, index) in categories" :value="category.id">{{ category.name }}</option>
                                    </selectize>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="uom" class="col-sm-2 control-label">Unit Of Measurement</label>
                
                                <div class="col-sm-10">
                                    <selectize v-model="dataInput.uom" :settings="uomSettings">
                                        <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.name }} - {{ uom.unit }}</option>
                                    </selectize>
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-10">
                                    <selectize v-model="dataInput.status" :settings="statusSettings">
                                        <option value="1">{{'Active'}}</option>
                                        <option value="0">{{'Non Active'}}</option>
                                    </selectize>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button @click.prevent="submitForm" :disabled="dataOk" v-if="resource.branch_id > 0" type="submit" class="btn btn-primary pull-right">SAVE</button>
                            <button @click.prevent="submitForm()"  :disabled="dataOk" v-else type="submit" class="btn btn-primary pull-right">CREATE</button>
                        </div>
                    </div>
                @endverbatim
                </form>
            </div> 
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    const form = document.querySelector('form#resource');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        resource : @json($resource),
        resource_code : @json($resource_code),
        uoms : @json($uoms),
        categories : @json($categories),
        submittedForm:{},
        statusSettings: {
            placeholder: 'Please Select Status'
        },
        uomSettings: {
            placeholder: 'Please Select UOM'
        },
        typeSettings: {
            placeholder: 'Please Select Type'
        },
        categorySettings: {
            placeholder: 'Please Select Category'
        },
        dataInput : {
            code : @json($resource_code),
            name : "",
            description : "",
            type : "",
            quantity : "",
            category : "",
            uom : "",
            status : "",
        }
    }

    var vm = new Vue({
        el : '#resource',
        data : data,
        computed : {
            dataOk: function(){
                let isOk = false;
                
                if(this.dataInput.name == "" || this.dataInput.type == "" || this.dataInput.category_id == "" || this.dataInput.uom_id == "" ||this.dataInput.status == "" ){
                    isOk = true;
                }else{
                    if(this.dataInput.quantity < 1){
                        isOk = true;
                    }
                }
                return isOk;
            },
        },
        methods: {
            submitForm(){
                this.submittedForm.dataInput = this.dataInput;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                document.body.appendChild(form);
                form.submit();
            }
        },
        watch : {
            'resource.type' : function(newValue){
                if(newValue == ""){
                    this.resource.quantity = "";
                }
            }
        },
        created: function(){
                this.dataInput.name = this.resource.name;
                this.dataInput.description = this.resource.description;
                this.dataInput.type = this.resource.type;
                this.dataInput.quantity = this.resource.quantity;
                this.dataInput.category = this.resource.category_id;
                this.dataInput.uom = this.resource.uom_id;
                this.dataInput.status = this.resource.status;
        }

    });
    
</script>
@endpush
