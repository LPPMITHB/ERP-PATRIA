@extends('layouts.main')
@section('content-header')

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
@endsection


@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                    <form id="resource" class="form-horizontal" method="POST" action="{{ route('resource.update',['id'=>$resource->id]) }}">
                @csrf
                <input type="hidden" name="_method" value="PATCH"> 
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
                                    <label for="category" class="col-sm-2 control-label">Category</label>
                                    <div class="col-sm-10">
                                        <selectize v-model="dataInput.category_id" :settings="categorySettings">
                                            <option v-for="(resource_category, index) in resource_category" :value="resource_category.id">{{ resource_category.name }} </option>
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
                                <label for="cost_standard_price" class="col-sm-2 control-label">Cost Standard Price</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="cost_standard_price" name="cost_standard_price" v-model="dataInput.cost_standard_price">
                                </div>
                            </div>
                            
                            <div class="form-group" v-show="dataInput.category_id == 3 || dataInput.category_id == 2 || dataInput.category_id == 1 " >
                                    <label for="manufactured_date" class="col-sm-2 control-label">Manufactured Date</label>
                                    <div class="col-sm-5">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input required autocomplete="off" type="text" class="form-control datepicker" name="manufactured_date" v-model="dataInput.manufactured_date" id="manufactured_date" placeholder="Manufactured Date">                                             
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="form-group" v-show="dataInput.category_id == 0">
                                    <label for="manufactured_date" class="col-sm-2 control-label">Manufactured Date</label>
                                    <div class="col-sm-5">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input required autocomplete="off" type="text" class="form-control datepicker" name="manufactured_date" v-model="dataInput.manufactured_date" placeholder="Manufactured Date" disabled>                                             
                                        </div>
                                    </div>
                                </div>
        
                                <div class="form-group" v-show="dataInput.category_id == 3 || dataInput.category_id == 2 || dataInput.category_id == 1">
                                    <label for="purchasing_date" class="col-sm-2 control-label">Purchasing Date</label>
                                    <div class="col-sm-5">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input required autocomplete="off" type="text" class="form-control datepicker" name="purchasing_date" v-model="dataInput.purchasing_date" id="purchasing_date" placeholder="Purchasing Date" >                                             
                                        </div>
                                    </div>
                                </div>
    
                                <div class="form-group" v-show="dataInput.category_id == 0">
                                    <label for="purchasing_date" class="col-sm-2 control-label">Purchasing Date</label>
                                    <div class="col-sm-5">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input required autocomplete="off" type="text" class="form-control datepicker" name="purchasing_date" v-model="dataInput.purchasing_date" placeholder="Purchasing Date" disabled>                                             
                                        </div>
                                    </div>
                                </div>

                            <div class="form-group">
                                <label for="purchasing_date" class="col-sm-2 control-label">Purchasing Price</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="purchasing_price" name="purchasing_price" v-model="dataInput.purchasing_price">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="lifetime" class="col-sm-2 control-label">Lifetime (days)</label>
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
                            <button @click.prevent="submitForm" :disabled="dataOk" type="submit" class="btn btn-primary pull-right">SAVE</button>
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
        resource_category : @json($resource_category),
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
            name : @json($resource->name),
            brand : @json($resource->brand),
            quantity : @json($resource->quantity),
            description : @json($resource->description),
            // machine_type : @json($resource->machine_type),
            category_id : @json($resource->category_id),
            cost_standard_price : @json($resource->cost_standard_price),
            manufactured_date : @json($resource->manufactured_date),
            purchasing_date : @json($resource->purchasing_date),
            purchasing_price : @json($resource->purchasing_price),
            lifetime : @json($resource->lifetime),
            depreciation_method : @json($resource->depreciation_method),
            accumulated_depreciation : @json($resource->accumulated_depreciation),
            // running_hours : "",
            cost_per_hour : @json($resource->cost_per_hour),
            status : @json($resource->status),
            vendor : @json($resource->vendor_id),
            uom : @json($resource->uom_id),
        }
    }

    var vm = new Vue({
        el : '#resource',
        data : data,
        computed : {
            mounted() {
            $('.datepicker').datepicker({
                autoclose : true,
            });
            $("#manufactured_date").datepicker().on(
                "changeDate", () => {
                    this.dataInput.manufactured_date = $('#manufactured_date').val();
                }
            );
            $("#purchasing_date").datepicker().on(
                "changeDate", () => {
                    this.dataInput.purchasing_date = $('#purchasing_date' ).val();
                }
            );
        },
            dataOk: function(){
                let isOk = false;
                
                if(this.dataInput.name == "" || this.dataInput.category_id == "" ||this.dataInput.status == "" ){
                    isOk = true;
                }
                return isOk;
            },
        },
        methods: {
            submitForm(){
                $('div.overlay').show();
                this.submittedForm = this.dataInput;
                this.submittedForm.cost_standard_price = this.submittedForm.cost_standard_price.replace(/,/g , '');
                this.submittedForm.purchasing_price = this.submittedForm.purchasing_price.replace(/,/g , '');
                //this.submittedForm.quantity = this.submittedForm.quantity.replace(/,/g , '');
                
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
            'resource.category_id' : function(newValue){
                if(newValue == ""){
                    this.resource.quantity = "";
                }
            },
            'dataInput.cost_standard_price': function(newValue) {
                var decimal = newValue.replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.dataInput.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.dataInput.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.dataInput.cost_standard_price = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'dataInput.purchasing_price': function(newValue) {
                var decimal = newValue.replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.dataInput.purchasing_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.dataInput.purchasing_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.dataInput.purchasing_price = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            // 'dataInput.quantity': function(newValue) {
            //     var decimal = newValue.replace(/,/g, '').split('.');
            //     if(decimal[1] != undefined){
            //         var maxDecimal = 2;
            //         if((decimal[1]+"").length > maxDecimal){
            //             this.dataInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
            //         }else{
            //             this.dataInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
            //         }
            //     }else{
            //         this.dataInput.quantity = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            //     }
            // },
            // 'dataInput.category_id': function(newValue) {
            //     if(this.dataInput.category_id == 0){
            //         this.dataInput.quantity = 1
            //     }
            // }
        },

        created: function(){
            var decimal = (this.dataInput.cost_standard_price+"").replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                var maxDecimal = 2;
                if((decimal[1]+"").length > maxDecimal){
                    this.dataInput.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                }else{
                    this.dataInput.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.dataInput.cost_standard_price = (this.dataInput.cost_standard_price+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            var decimal = (this.dataInput.purchasing_price+"").replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                var maxDecimal = 2;
                if((decimal[1]+"").length > maxDecimal){
                    this.dataInput.purchasing_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                }else{
                    this.dataInput.purchasing_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.dataInput.purchasing_price = (this.dataInput.purchasing_price+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            var decimal = (this.dataInput.quantity+"").replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                var maxDecimal = 2;
                if((decimal[1]+"").length > maxDecimal){
                    this.dataInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                }else{
                    this.dataInput.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.dataInput.quantity = (this.dataInput.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        }

    });
    
    
</script>
@endpush
