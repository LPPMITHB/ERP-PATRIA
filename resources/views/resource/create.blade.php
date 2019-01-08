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
                                <label for="brand" class="col-sm-2 control-label">Brand</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="brand" name="brand" required autofocus v-model="dataInput.brand">
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
                                    <selectize v-model="dataInput.machine_type" :settings="typeSettings">
                                        <option value="2">{{'Material'}}</option>
                                        <option value="1">{{'Resource'}}</option>
                                        <option value="0">{{'Subcon'}}</option>
                                    </selectize>
                                </div>
                            </div>
                            
                            <div class="form-group" v-if="dataInput.machine_type == null || dataInput.machine_type == ''">
                                <label for="category" class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="category" name="category" v-model="dataInput.category" disabled>
                                </div>
                            </div>

                            <div class="form-group" v-else-if="dataInput.machine_type == 0">
                                <label for="category" class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="category" name="category" v-model="dataInput.category" disabled placeholder="Subcon">
                                </div>
                            </div>

                            <div class="form-group" v-else-if="dataInput.machine_type == 2 || dataInput.machine_type == 1">
                                <label for="type" class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-10">
                                    <selectize v-model="dataInput.category" :settings="categorySettings">
                                        <option value="3">{{'Internal Equipment'}}</option>
                                        <option value="2">{{'External Equipment'}}</option>
                                        <option value="0">{{'Others'}}</option>
                                    </selectize>
                                </div>
                            </div>

                            <div class="form-group" v-if="dataInput.machine_type == null || dataInput.machine_type == '' || dataInput.machine_type == '0'">
                                <label for="quantity" class="col-sm-2 control-label">Quantity</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="quantity" name="quantity" v-model="dataInput.quantity" disabled>
                                </div>
                            </div>

                            <div class="form-group" v-else-if="dataInput.machine_type == 2 || dataInput.machine_type == 1">
                                <label for="quantity" class="col-sm-2 control-label">Quantity</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="quantity" name="quantity" v-model="dataInput.quantity">
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
                                <label for="cost_standard_price" class="col-sm-2 control-label">Cost Standard Price</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="cost_standard_price" name="cost_standard_price" v-model="dataInput.cost_standard_price">
                                </div>
                            </div>
                            
                            <div class="form-group" v-if="dataInput.machine_type == 2 || dataInput.machine_type == 1 " >
                                <label for="manufactured_date" class="col-sm-2 control-label">Manufactured Date</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="manufactured_date" name="manufactured_date" v-model="dataInput.manufactured_date">
                                </div>
                            </div>
                                
                            <div class="form-group" v-else-if="dataInput.machine_type == 0">
                                <label for="manufactured_date" class="col-sm-2 control-label">Manufactured Date</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="manufactured_date" name="manufactured_date" v-model="dataInput.manufactured_date" disabled>
                                </div>
                            </div>
    
                            <div class="form-group" v-if="dataInput.machine_type == 2 || dataInput.machineType == 1">
                                <label for="purchasing_date" class="col-sm-2 control-label">Purchasing Date</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="purchasing_date" name="purchasing_date" v-model="dataInput.purchasing_date">
                                </div>
                            </div>

                            <div class="form-group" v-if="dataInput.machine_type == 0">
                                <label for="purchasing_date" class="col-sm-2 control-label">Purchasing Date</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="purchasing_date" name="purchasing_date" v-model="dataInput.purchasing_date" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="purchasing_date" class="col-sm-2 control-label">Purchasing Price</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="purchasing_price" name="purchasing_price" v-model="dataInput.purchasing_price">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="lifetime" class="col-sm-2 control-label">Lifetime</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="lifetime" name="lifetime" v-model="dataInput.lifetime">
                                </div>
                            </div>
        
                            <div class="form-group">
                                <label for="depreciation_method" class="col-sm-2 control-label">Depreciation Method</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="depreciation_method" name="depreciation_method" v-model="dataInput.depreciation_method">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="accumulated_depreciation" class="col-sm-2 control-label">Accumulated Depreciation</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="accumulated_depreciation" name="accumulated_depreciation" v-model="dataInput.accumulated_depreciation">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cost_per_hour" class="col-sm-2 control-label">Cost per Hour</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="cost_per_hour" name="cost_per_hour" v-model="dataInput.cost_per_hour">
                                </div>
                            </div>
                                
                            <div class="form-group">
                                <label for="vendor" class="col-sm-2 control-label">Vendor</label>
                                <div class="col-sm-10">
                                    <selectize v-model="dataInput.vendor" :settings="vendorSettings">
                                        <option v-for="(vendor, index) in vendors" :value="vendor.id">{{ vendor.name }}</option>
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
                            <button @click.prevent="submitForm"  :disabled="dataOk" v-else type="submit" class="btn btn-primary pull-right">CREATE</button>
                        </div>
                    </div>
                @endverbatim
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
    const form = document.querySelector('form#resource');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        resource : @json($resource),
        resource_code : @json($resource_code),
        uoms : @json($uoms),
        vendors : @json($vendors),
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
        vendorSettings: {
            placeholder: 'Please Select Vendor'
        },
        categorySettings: {
            placeholder: 'Please Select Category'
        },
        dataInput : {
            code : @json($resource_code),
            name : "",
            brand : "",
            quantity : "",
            description : "",
            machine_type : "",
            category : "",
            cost_standard_price : "",
            manufactured_date : "",
            purchasing_date : "",
            purchasing_price : "",
            lifetime : "",
            depreciation_method : "",
            accumulated_depreciation : "",
            // running_hours : "",
            cost_per_hour : "",
            status : "",
            vendor : "",
            uom : "",
        }
    }

    var vm = new Vue({
        el : '#resource',
        data : data,
        computed : {
            dataOk: function(){
                let isOk = false;
                
                if(this.dataInput.name == "" || this.dataInput.type == "" || this.dataInput.uom == "" ||this.dataInput.status == "" ){
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
                console.log(this.submittedForm);
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                document.body.appendChild(form);
                // form.submit();
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
                this.dataInput.brand = this.resource.brand;
                this.dataInput.quantity = this.resource.quantity;
                this.dataInput.description = this.resource.description;
                this.dataInput.machine_type = this.resource.machine_type;
                this.dataInput.cost_standard_price = this.resource.cost_standard_price;
                this.dataInput.manufactured_date = this.resource.manufactured_date;
                this.dataInput.purchasing_date = this.resource.purchasing_date;
                this.dataInput.purchasing_price = this.resource.purchasing_price;
                this.dataInput.lifetime = this.resource.lifetime;
                this.dataInput.depreciation_method = this.resource.depreciation_method;
                this.dataInput.accumulated_depreciation = this.resource.accumulated_depreciation;
                this.dataInput.running_hours = this.resource.running_hours;
                this.dataInput.cost_per_hour = this.resource.cost_per_hour;
                this.dataInput.status = this.resource.status;
                this.dataInput.vendor = this.resource.vendor_id;
                this.dataInput.uom = this.resource.uom_id;
        }

    });
    
</script>
@endpush
