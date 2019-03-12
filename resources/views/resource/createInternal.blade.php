@extends('layouts.main')
@section('content-header')

@if($route == "/resource")
    @breadcrumb(
        [
            'title' => 'Create Internal Resource',
            'items' => [
                'Dashboard' => route('index'),
                'View All Resources' => route('resource.index'),
                $resource->name => route('resource.show',$resource->id),
                'Create Internal Resource' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/resource_repair")
    @breadcrumb(
        [
            'title' => 'Create Internal Resource',
            'items' => [
                'Dashboard' => route('index'),
                'View All Resources' => route('resource_repair.index'),
                $resource->name => route('resource_repair.show',$resource->id),
                'Create Internal Resource' => '',
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
                @if($route == "/resource")
                    <form id="resource" class="form-horizontal" method="POST" action="{{ route('resource.storeInternal') }}">
                @elseif($route == "/resource_repair")
                    <form id="resource" class="form-horizontal" method="POST" action="{{ route('resource_repair.storeInternal') }}">
                @endif
                @csrf
                @verbatim
                    <div id="resource">
                        <div class="box-body">
                            <div class="col-sm-12">
                                <label for="code" class="control-label">Code*</label>
                                <input type="text" id="code" v-model="dataInput.code" class="form-control" placeholder="Please Input Code">
                            </div>
                            <div class="col-sm-12">
                                <label for="serial_number" class="control-label">Serial Number</label>
                                <input type="text" id="serial_number" v-model="dataInput.serial_number" class="form-control" placeholder="Please Input Serial Number">
                            </div>
                            <div class="col-sm-12">
                                <label for="brand" class="control-label">Brand*</label>
                                <input type="text" id="brand" v-model="dataInput.brand" class="form-control" placeholder="Please Input Brand">
                            </div>
                            <div class="col-sm-12">
                                <label for="quantity" class="control-label">Quantity</label>
                                <input type="text" id="quantity" v-model="dataInput.quantity" class="form-control" placeholder="Please Input Quantity">
                            </div>
                            <div class="col-sm-12">
                                <label for="description" class="control-label">Description</label>
                                <input type="text" id="description" v-model="dataInput.description" class="form-control" placeholder="Please Input Description">
                            </div>
                            <div class="col-sm-12">
                                <label for="kva" class="control-label">Kva</label>
                                <input type="text" id="kva" v-model="dataInput.kva" class="form-control" placeholder="Please Input Kva">
                            </div>
                            <div class="col-sm-12">
                                <label for="amp" class="control-label">Amp</label>
                                <input type="text" id="amp" v-model="dataInput.amp" class="form-control" placeholder="Please Input Amp">
                            </div>
                            <div class="col-sm-12">
                                <label for="volt" class="control-label">Volt</label>
                                <input type="text" id="volt" v-model="dataInput.volt" class="form-control" placeholder="Please Input Volt">
                            </div>
                            <div class="col-sm-12">
                                <label for="phase" class="control-label">Phase</label>
                                <input type="text" id="phase" v-model="dataInput.phase" class="form-control" placeholder="Please Input Phase">
                            </div>
                            <div class="col-sm-12">
                                <label for="length" class="control-label">Length</label>
                                <input type="text" id="length" v-model="dataInput.length" class="form-control" placeholder="Please Input Length">
                            </div>
                            <div class="col-sm-12">
                                <label for="width" class="control-label">Width</label>
                                <input type="text" id="width" v-model="dataInput.width" class="form-control" placeholder="Please Input Width">
                            </div>
                            <div class="col-sm-12">
                                <label for="height" class="control-label">Height</label>
                                <input type="text" id="height" v-model="dataInput.height" class="form-control" placeholder="Please Input Height">
                            </div>
                            <div class="col-sm-12">
                                <label for="manufactured_in" class="control-label">Manufactured In</label>
                                <input type="text" id="manufactured_in" v-model="dataInput.manufactured_in" class="form-control" placeholder="Please Input Manufactured In">
                            </div>
                            <div class="col-sm-12 p-t-7">
                                <label for="manufactured_date">Manufactured Date</label>
                                <input required autocomplete="off" type="text" class="form-control datepicker width100" name="manufactured_date" id="manufactured_date" placeholder="Manufactured Date">  
                            </div>
                            <div class="col-sm-12 p-t-7">
                                <label for="purchasing_date">Purchasing Date</label>
                                <input required autocomplete="off" type="text" class="form-control datepicker width100" name="purchasing_date" id="purchasing_date" placeholder="Purchasing Date" >  
                            </div>
                            <div class="col-sm-12">
                                <label for="purchasing_price" class="control-label">Purchasing Price</label>
                                <input type="text" id="purchasing_price" v-model="dataInput.purchasing_price" class="form-control" placeholder="Please Input Purchasing Price">
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-12 no-padding">
                                    <label for="lifetime" class="control-label">Life Time</label>
                                </div>
                                <div class="col-sm-3 no-padding p-r-10">
                                    <input type="text" id="lifetime" v-model="dataInput.lifetime" class="form-control" placeholder="Life Time">
                                </div>
                                <div class="col-sm-3 no-padding">
                                    <selectize v-model="dataInput.lifetime_uom_id" :settings="timeSettings">
                                        <option value="1">Day(s)</option>
                                        <option value="2">Month(s)</option>
                                        <option value="3">Year(s)</option>
                                    </selectize>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label for="cost_per_hour" class="control-label">Cost Per Hour (Rp.)</label>
                                <input type="text" id="cost_per_hour" v-model="dataInput.cost_per_hour" class="form-control" placeholder="Please Input Cost Per Hour">
                            </div>
                            <div class="col-sm-12">
                                <label for="type" class="control-label">Depreciation Method</label>
                                <selectize v-model="dataInput.depreciation_method" :settings="depreciationSettings">
                                    <option v-for="(depreciation_method, index) in depreciation_methods" :value="depreciation_method.id">{{ depreciation_method.name }} </option>
                                </selectize>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-12 no-padding">
                                    <label for="performance" class="control-label">Performance</label>
                                </div>
                                <div class="col-sm-3 no-padding p-r-10">
                                    <input type="text" id="performance" v-model="dataInput.performance" class="form-control" placeholder="Performance">
                                </div>
                                <div class="col-sm-3 no-padding">
                                    <selectize v-model="dataInput.performance_uom_id" :settings="uomSettings">
                                        <option v-for="(data, index) in uom" :value="data.id">{{ data.unit }} </option>
                                    </selectize>
                                </div>
                                <div class="col-sm-6 p-t-8">
                                    Per Hour
                                </div>
                            </div>
                        </div>
                        
                        <div class="box-footer">
                            <button @click.prevent="submitForm" :disabled="dataOk" type="submit" class="btn btn-primary pull-right">CREATE</button>
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
        oldData : {
            code : @json(Request::old('code')),
            serial_number : @json(Request::old('serial_number')),
            brand : @json(Request::old('brand')),
            quantity : @json(Request::old('quantity')),
            kva : @json(Request::old('kva')),
            amp :@json(Request::old('amp')),
            volt : @json(Request::old('volt')),
            phase : @json(Request::old('phase')),
            length : @json(Request::old('length')),
            width : @json(Request::old('width')),
            height : @json(Request::old('height')),
            manufactured_in : @json(Request::old('manufactured_in')),
            manufactured_date : @json(Request::old('manufactured_date')),
            purchasing_date : @json(Request::old('purchasing_date')),
            purchasing_price : @json(Request::old('purchasing_price')),
            lifetime : @json(Request::old('lifetime')),
            lifetime_uom_id : @json(Request::old('lifetime_uom_id')),
            cost_per_hour : @json(Request::old('cost_per_hour')),
            description : @json(Request::old('description')),
            depreciation_method : @json(Request::old('depreciation_method')),
            performance : @json(Request::old('performance')),
            performance_uom_id : @json(Request::old('performance_uom_id')),
        },
        depreciation_methods : @json($depreciation_methods),
        uom : @json($uom),
        resource : @json($resource),
        dataInput : {
            code : "",
            resource_id : @json($resource->id),
            serial_number : "",
            brand : "",
            quantity: "",
            kva: "",
            amp: "",
            volt: "",
            phase: "",
            length: "",
            width: "",
            height: "",
            manufactured_in : "",
            manufactured_date : "",
            purchasing_date : "",
            purchasing_price : "",
            lifetime : "",
            lifetime_uom_id : "",
            cost_per_hour : "",
            description : "",
            depreciation_method : 0,
            performance : "",
            performance_uom_id : "",
        },
        uomSettings: {
            placeholder: 'Please Select UOM'
        },
        timeSettings: {
            placeholder: 'Please Select Time'
        },
        depreciationSettings: {
            placeholder: 'Please Select Depreciation Method'
        },
    }

    var vm = new Vue({
        el : '#resource',
        data : data,
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
        computed : {
            dataOk: function(){
                let isOk = false;
                
                if(this.dataInput.brand == "" || this.dataInput.code == ""){
                    isOk = true;
                }
                return isOk;
            },
        },
        methods: {
            submitForm(){
                window.axios.get('/api/getCodeRSCD').then(({ data }) => {
                    const array = data;
                    var statsCode = '';
                    
                    for (let i = 0;i < array.length; i++){
                        if(array[i].code == this.dataInput.code){
                            statsCode = 'yes';
                            iziToast.error({
                                title: 'Code has been taken !',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            break;
                            $('div.overlay').hide();
                        }
                    }

                    if(statsCode != 'yes'){
                        $('div.overlay').show();
                        this.dataInput.purchasing_price = (this.dataInput.purchasing_price+"").replace(/,/g , '');
                        this.dataInput.cost_per_hour = (this.dataInput.cost_per_hour+"").replace(/,/g , '');
                        this.dataInput.performance = (this.dataInput.performance+"").replace(/,/g , '');
                        this.dataInput.lifetime = (this.dataInput.lifetime+"").replace(/,/g , '');
                        this.dataInput.quantity = (this.dataInput.quantity+"").replace(/,/g , '');
                        this.dataInput.kva = (this.dataInput.kva+"").replace(/,/g , '');
                        this.dataInput.amp = (this.dataInput.amp+"").replace(/,/g , '');
                        this.dataInput.volt = (this.dataInput.volt+"").replace(/,/g , '');
                        this.dataInput.phase = (this.dataInput.phase+"").replace(/,/g , '');
                        this.dataInput.length = (this.dataInput.length+"").replace(/,/g , '');
                        this.dataInput.width = (this.dataInput.width+"").replace(/,/g , '');
                        this.dataInput.height = (this.dataInput.height+"").replace(/,/g , '');

                        let struturesElem = document.createElement('input');
                        struturesElem.setAttribute('type', 'hidden');
                        struturesElem.setAttribute('name', 'datas');
                        struturesElem.setAttribute('value', JSON.stringify(this.dataInput));
                        form.appendChild(struturesElem);
                        document.body.appendChild(form);
                        form.submit();
                        $('div.overlay').hide();
                    }
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                })
            }
        },
        watch : {
            created: function() {
                if(this.oldData.code !=null) {
                    this.dataInput.code=this.oldData.code;
                }
                if(this.oldData.serial_number !=null) {
                    this.dataInput.serial_number=this.oldData.serial_number;
                }
                if(this.oldData.brand !=null) {
                    this.dataInput.brand=this.oldData.brand;
                }
                if(this.oldData.quantity !=null) {
                    this.dataInput.quantity=this.oldData.quantity;
                }
                if(this.oldData.kva !=null) {
                    this.dataInput.kva=this.oldData.kva;
                }
                if(this.oldData.amp !=null) {
                    this.dataInput.amp=this.oldData.amp;
                }
                if(this.oldData.volt !=null) {
                    this.dataInput.volt=this.oldData.volt;
                }
                if(this.oldData.phase !=null) {
                    this.dataInput.phase=this.oldData.phase;
                }
                if(this.oldData.length !=null) {
                    this.dataInput.length=this.oldData.length;
                }
                if(this.oldData.width !=null) {
                    this.dataInput.width=this.oldData.width;
                }
                if(this.oldData.height !=null) {
                    this.dataInput.height=this.oldData.height;
                }
                if(this.oldData.manufactured_in !=null) {
                    this.dataInput.manufactured_in=this.oldData.manufactured_in;
                }
                if(this.oldData.manufactured_date !=null) {
                    this.dataInput.manufactured_date=this.oldData.manufactured_date;
                }
                if(this.oldData.purchasing_date !=null) {
                    this.dataInput.purchasing_date=this.oldData.purchasing_date;
                }
                if(this.oldData.purchasing_price !=null) {
                    this.dataInput.purchasing_price=this.oldData.purchasing_price;
                }
                if(this.oldData.lifetime !=null) {
                    this.dataInput.lifetime=this.oldData.lifetime;
                }
                if(this.oldData.lifetime_uom_id !=null) {
                    this.dataInput.lifetime_uom_id=this.oldData.lifetime_uom_id;
                }
                if(this.oldData.cost_per_hour !=null) {
                    this.dataInput.cost_per_hour=this.oldData.cost_per_hour;
                }
                if(this.oldData.description !=null) {
                    this.dataInput.description=this.oldData.description;
                }
                if(this.oldData.depreciation_method !=null) {
                    this.dataInput.depreciation_method=this.oldData.depreciation_method;
                }
                if(this.oldData.performance !=null) {
                    this.dataInput.performance=this.oldData.performance;
                }
                if(this.oldData.performance_uom_id !=null) {
                    this.dataInput.performance_uom_id=this.oldData.performance_uom_id;
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
            'dataInput.cost_per_hour': function(newValue) {
                var decimal = newValue.replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.dataInput.cost_per_hour = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.dataInput.cost_per_hour = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.dataInput.cost_per_hour = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'dataInput.performance': function(newValue) {
                var decimal = newValue.replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.dataInput.performance = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.dataInput.performance = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.dataInput.performance = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'dataInput.lifetime': function(newValue) {
                var decimal = newValue.replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.dataInput.lifetime = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.dataInput.lifetime = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.dataInput.lifetime = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'dataInput.quantity': function(newValue) {
                if(newValue != ""){
                    this.dataInput.quantity = (this.dataInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'dataInput.kva': function(newValue) {
                if(newValue != ""){
                    this.dataInput.kva = (this.dataInput.kva+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'dataInput.amp': function(newValue) {
                if(newValue != ""){
                    this.dataInput.amp = (this.dataInput.amp+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'dataInput.volt': function(newValue) {
                if(newValue != ""){
                    this.dataInput.volt = (this.dataInput.volt+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'dataInput.phase': function(newValue) {
                if(newValue != ""){
                    this.dataInput.phase = (this.dataInput.phase+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'dataInput.length': function(newValue) {
                if(newValue != ""){
                    this.dataInput.length = (this.dataInput.length+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'dataInput.width': function(newValue) {
                if(newValue != ""){
                    this.dataInput.width = (this.dataInput.width+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'dataInput.height': function(newValue) {
                if(newValue != ""){
                    this.dataInput.height = (this.dataInput.height+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
        }
    });
</script>
@endpush
