@extends('layouts.main')
@section('content-header')
@if($route == "/purchase_order")
    @breadcrumb(
        [
            'title' => 'Edit Purchase Order',
            'items' => [
                'Dashboard' => route('index'),
                'View All Purchase Order' => route('purchase_order.index'),
                'Edit Purchase Order' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/purchase_order_repair")
    @breadcrumb(
        [
            'title' => 'Edit Purchase Order',
            'items' => [
                'Dashboard' => route('index'),
                'View All Purchase Order' => route('purchase_order_repair.index'),
                'Edit Purchase Order' => '',
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
            @if($route == "/purchase_order")
                <form id="edit-po" class="form-horizontal" method="POST" action="{{ route('purchase_order.update') }}">
            @elseif($route == "/purchase_order_repair")
                <form id="edit-po" class="form-horizontal" method="POST" action="{{ route('purchase_order_repair.update') }}">
            @endif
            <input type="hidden" name="_method" value="PATCH">
            @csrf
                @verbatim
                    <div id="po">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-xs-12 col-md-4" v-if="modelProject != null">
                                    <div class="col-xs-5 no-padding">PO Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelPO.number}}</b></div>

                                    <div class="col-xs-5 no-padding">PR Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelPO.purchase_requisition.number}}</b></div>
            
                                    <div class="col-xs-5 no-padding">Project Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelProject.number}}</b></div>
                                    
                                    <div class="col-xs-5 no-padding">Ship Type</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelProject.ship.type}}</b></div>
            
                                    <div class="col-xs-5 no-padding">Customer</div>
                                    <div class="col-xs-7 no-padding tdEllipsis" v-tooltip:top="tooltip(modelProject.customer.name)"><b>: {{modelProject.customer.name}}</b></div>
                                    
                                    <div class="col-sm-3 no-padding p-t-15">
                                        <label for="">Currency</label>
                                    </div>
                                    <div class="col-sm-9 p-t-13 p-l-0">
                                        <selectize :disabled="currencyOk" v-model="modelPO.currency" :settings="currencySettings">
                                            <option v-for="(data, index) in currencies" :value="data.name">{{ data.name }} - {{ data.unit }}</option>
                                        </selectize>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4" v-else>
                                    <div class="col-xs-5 no-padding">PO Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelPO.number}}</b></div>

                                    <div class="col-xs-5 no-padding">PR Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelPO.purchase_requisition.number}}</b></div>
            
                                    <div class="col-xs-5 no-padding">Project Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: -</b></div>
                                    
                                    <div class="col-xs-5 no-padding">Ship Type</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: -</b></div>
            
                                    <div class="col-xs-5 no-padding">Customer</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: -</b></div>

                                    <div class="col-sm-3 no-padding p-t-15">
                                        <label for="">Currency</label>
                                    </div>
                                    <div class="col-sm-9 p-t-13 p-l-0">
                                        <selectize :disabled="currencyOk" v-model="modelPO.currency" :settings="currencySettings">
                                            <option v-for="(data, index) in currencies" :value="data.name">{{ data.name }} - {{ data.unit }}</option>
                                        </selectize>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="row">
                                        <div class="col-sm-5 p-t-7">
                                            <label for="">Vendor Name</label>
                                        </div>
                                        <div class="col-sm-7 p-l-0">
                                            <selectize v-model="modelPO.vendor_id" :settings="vendorSettings">
                                                <option v-for="(vendor, index) in modelVendor" :value="vendor.id">{{ vendor.code }} - {{ vendor.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5 p-t-10">
                                            <label for="delivery_date">Delivery Date</label>
                                        </div>
                                        <div class="col-sm-7 p-t-5 p-l-0">
                                            <input v-model="modelPO.delivery_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="delivery_date" id="delivery_date" placeholder="Delivery Date">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5 p-t-15">
                                            <label for="delivery_terms">Delivery Terms</label>
                                        </div>
                                        <div class="col-sm-7 p-t-13 p-l-0">
                                            <input class="form-control" v-model="modelPO.delivery_terms" placeholder="Delivery Terms">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5 p-t-15">
                                            <label for="payment_terms">Payment Terms</label>
                                        </div>
                                        <div class="col-sm-7 p-t-13 p-l-0">
                                            <input class="form-control" v-model="modelPO.payment_terms" placeholder="Payment Terms">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="">PO Description</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <textarea class="form-control" rows="2" v-model="modelPO.description"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-5 p-t-15">
                                                <label for="estimated_freight">Estimated Freight ({{selectedCurrency}})</label>
                                            </div>
                                            <div class="col-sm-7 p-t-13 p-l-0">
                                                <input class="form-control" v-model="modelPO.estimated_freight" placeholder="Estimated Freight">
                                            </div>
                                        </div>
    
                                        <div class="row">
                                            <div class="col-sm-5 p-t-15">
                                                <label for="">Tax (%)</label>
                                            </div>
                                            <div class="col-sm-7 p-t-13 p-l-0">
                                                <input class="form-control" v-model="modelPO.tax" placeholder="Tax">
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col sm-12 p-l-15 p-r-15 p-t-0">
                                    <table class="table table-bordered tableFixed p-t-10" style="border-collapse:collapse;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th v-if="type == 1" style="width: 30%">Material Name</th>
                                                <th v-else style="width: 30%">Resource Name</th>
                                                <th style="width: 10%">Quantity</th>
                                                <th style="width: 10%">Order</th>
                                                <th style="width: 15%">Price / pcs ({{selectedCurrency}})</th>
                                                <th style="width: 30%">WBS Name</th>
                                                <th style="width: 15%">Alocation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(POD,index) in PODetail">
                                                <td>{{ index + 1 }}</td>
                                                <td v-if="type == 1" class="tdEllipsis">{{ POD.material.code }} - {{ POD.material.name }}</td>
                                                <td v-else class="tdEllipsis">{{ POD.resource.code }} - {{ POD.resource.name }}</td>
                                                <td class="tdEllipsis">{{ POD.purchase_requisition_detail.quantity }}</td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control" v-model="POD.quantity" placeholder="Please Input Quantity">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control" v-model="POD.total_price" placeholder="Please Input Price / pcs">
                                                </td>
                                                <td v-if="POD.wbs != null" class="tdEllipsis">{{ POD.wbs.name }}</td>
                                                <td v-else class="tdEllipsis">-</td>
                                                <td class="tdEllipsis">{{ POD.purchase_requisition_detail.alocation }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 p-r-0">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="dataOk">SAVE</button>
                            </div>
                        </div>
                    </div>
                @endverbatim
            </form>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    const form = document.querySelector('form#edit-po');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        modelPO : @json($modelPO),
        PODetail : @json($modelPOD),
        modelProject : @json($modelProject),
        currencies : @json($currencies),
        modelVendor : [],
        vendorSettings: {
            placeholder: 'Please Select Vendor'
        },
        currencySettings: {
            placeholder: 'Please Select Currency'
        },
        selectedCurrency: "",
        submittedForm : {},
    }

    var vm = new Vue({
        el : '#po',
        data : data,
        mounted(){
            $('.datepicker').datepicker({
                autoclose : true,
                format: 'dd-mm-yyyy',
            });
            $("#delivery_date").datepicker().on(
                "changeDate", () => {
                    this.delivery_date = $('#delivery_date').val();
                }
            );
        },
        computed : {
            dataOk: function(){
                let isOk = false;
                if(this.vendor_id == ""){
                    isOk = true;
                }
                return isOk;
            },
            currencyOk : function(){
                let isOk = false;
                var currency_value = 1;
                this.currencies.forEach(data => {
                    if(this.modelPO.currency == data.name && this.modelPO.currency != "Rupiah"){
                        currency_value = data.value;
                    }
                });

                this.PODetail.forEach(POD => {
                    var ref = 0;
                    var decimal = ((POD.old_price / currency_value)+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            ref = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            ref = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        ref = (decimal[0]+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                    if(parseFloat(POD.total_price.replace(/,/g , '')) != ref.replace(/,/g, '')){
                        isOk = true;
                    }   
                });
                return isOk;
            }
        },
        methods : {
            tooltip(text){
                Vue.directive('tooltip', function(el, binding){
                    $(el).tooltip('destroy');
                    $(el).tooltip({
                        title: text,
                        placement: binding.arg,
                        trigger: 'hover'             
                    })
                })
                return text
            },
            getVendor(){
                $('div.overlay').show();
                window.axios.get('/api/getVendor').then(({ data }) => {
                    this.modelVendor = data;
                    $('div.overlay').hide();
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    $('div.overlay').hide();
                })
            },
            submitForm(){
                var data = this.PODetail;
                data = JSON.stringify(data);
                data = JSON.parse(data);

                this.modelPO.estimated_freight = this.modelPO.estimated_freight.replace(/,/g , '');
                data.forEach(POD => {
                    POD.quantity = POD.quantity.replace(/,/g , '');      
                    POD.total_price = POD.total_price.replace(/,/g , '');      
                });

                this.submittedForm.modelPO = this.modelPO;
                this.submittedForm.PODetail = data;
                this.submittedForm.type = this.type;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        watch : {
            PODetail:{
                handler: function(newValue) {
                    var data = newValue;
                    data.forEach(POD => {
                        var decimal = (POD.total_price+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                POD.total_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                POD.total_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            POD.total_price = (POD.total_price+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                        POD.quantity = (POD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");     
                    });
                },
                deep: true
            },
            'modelPO.tax' : function (newValue){
                var tax = parseInt((newValue+"").replace(/,/g, ''));
                if(newValue > 100){
                    iziToast.warning({
                        title: 'Tax cannot exceed 100% !',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    this.tax = 100;
                }
                var decimal = (newValue+"").replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.tax = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.tax = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.tax = (this.tax+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'modelPO.estimated_freight': function (newValue){
                var decimal = (newValue+"").replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.modelPO.estimated_freight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.modelPO.estimated_freight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.modelPO.estimated_freight = (this.modelPO.estimated_freight+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'modelPO.currency':function (newValue) {
                if(newValue == ''){
                    this.modelPO.currency = this.currencies[0].name;
                }
                this.currencies.forEach(data => {
                    if(newValue == data.name){
                        this.selectedCurrency = data.unit;
                        this.PODetail.forEach(pod => {
                            pod.total_price = parseFloat((pod.price+"").replace(/,/g , '')) / data.value;
                        });
                    }
                });
            },
        },
        created: function() {
            this.modelPO.delivery_date = this.modelPO.delivery_date.split("-").reverse().join("-");
            this.getVendor();
            var decimal = (this.modelPO.estimated_freight+"").replace(/,/g, '').split('.');
            if(decimal[1] != undefined){
                var maxDecimal = 2;
                if((decimal[1]+"").length > maxDecimal){
                    this.modelPO.estimated_freight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                }else{
                    this.modelPO.estimated_freight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                }
            }else{
                this.modelPO.estimated_freight = (this.modelPO.estimated_freight+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            this.type = this.modelPO.purchase_requisition.type;

            var data = this.PODetail;
            data.forEach(POD => {
                POD.price = parseFloat((POD.total_price / POD.quantity+"").replace(/,/g , ''));
                POD.total_price = (POD.total_price / this.modelPO.value) / POD.quantity;        
                POD.quantity = (POD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");   
                var decimal = (POD.total_price+"").replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        POD.total_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        POD.total_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    POD.total_price = (POD.total_price+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                } 
            });

            this.currencies.forEach(data => {
                if(this.modelPO.currency == data.name){
                    this.selectedCurrency = data.unit;
                }
            });
        },
    });
</script>
@endpush
