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
                                <label for="brand" class="control-label">Brand*</label>
                                <input type="text" id="brand" v-model="dataInput.brand" class="form-control" placeholder="Please Input Brand">
                            </div>
                            <div class="col-sm-12">
                                <label for="description" class="control-label">Description</label>
                                <input type="text" id="description" v-model="dataInput.description" class="form-control" placeholder="Please Input Description">
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
        depreciation_methods : @json($depreciation_methods),
        uom : @json($uom),
        resource : @json($resource),
        dataInput : {
            code : "",
            resource_id : @json($resource->id),
            brand : "",
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
                this.dataInput.purchasing_price = (this.dataInput.purchasing_price+"").replace(/,/g , '');
                this.dataInput.cost_per_hour = (this.dataInput.cost_per_hour+"").replace(/,/g , '');
                this.dataInput.performance = (this.dataInput.performance+"").replace(/,/g , '');
                this.dataInput.lifetime = (this.dataInput.lifetime+"").replace(/,/g , '');

                $('div.overlay').show();
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.dataInput));
                form.appendChild(struturesElem);
                document.body.appendChild(form);
                form.submit();
            }
        },
        watch : {
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
        }
    });
</script>
@endpush
