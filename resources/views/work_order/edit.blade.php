@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Edit Work Order',
        'items' => [
            'Dashboard' => route('index'),
            'Edit Work Order' => '',
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            @if($route == "/work_order")
                <form id="edit-po" class="form-horizontal" method="POST" action="{{ route('work_order.update') }}">
            @elseif($route == "/work_order_repair")
                <form id="edit-po" class="form-horizontal" method="POST" action="{{ route('work_order_repair.update') }}">
            @endif
            <input type="hidden" name="_method" value="PATCH">
            @csrf
                @verbatim
                    <div id="po">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-xs-12 col-md-4" v-if="modelProject != null">
                                    <div class="col-xs-5 no-padding">PO Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelWO.number}}</b></div>

                                    <div class="col-xs-5 no-padding">WR Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelWO.work_request.number}}</b></div>
            
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
                                        <selectize v-model="currency" :settings="currencySettings">
                                            <option v-for="(data, index) in currencies" :value="data.name">{{ data.name }} - {{ data.unit }}</option>
                                        </selectize>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4" v-else>
                                    <div class="col-xs-5 no-padding">WO Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelWO.number}}</b></div>

                                    <div class="col-xs-5 no-padding">WR Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelWO.work_request.number}}</b></div>
            
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
                                        <selectize :disabled="currencyOk" v-model="currency" :settings="currencySettings">
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
                                            <selectize v-model="modelWO.vendor_id" :settings="vendorSettings">
                                                <option v-for="(vendor, index) in modelVendor" :value="vendor.id">{{ vendor.code }} - {{ vendor.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5 p-t-10">
                                            <label for="delivery_date">Delivery Date</label>
                                        </div>
                                        <div class="col-sm-7 p-t-5 p-l-0">
                                            <input v-model="modelWO.delivery_date" required autocomplete="off" type="text" class="form-control datepicker width100" name="delivery_date" id="delivery_date" placeholder="Delivery Date">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5 p-t-15">
                                            <label for="payment_terms">Payment Terms</label>
                                        </div>
                                        <div class="col-sm-7 p-t-13 p-l-0">
                                            <input class="form-control" v-model="modelWO.payment_terms" placeholder="Payment Terms">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-5 p-t-15">
                                            <label for="estimated_freight">Estimated Freight ({{selectedCurrency}})</label>
                                        </div>
                                        <div class="col-sm-7 p-t-13 p-l-0">
                                            <input class="form-control" v-model="modelWO.estimated_freight" placeholder="Estimated Freight">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="">WO Description</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" rows="3" v-model="modelWO.description"></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3 p-t-15">
                                            <label for="">Tax (%)</label>
                                        </div>
                                        <div class="col-sm-9 p-t-13 p-l-0">
                                            <input class="form-control" v-model="modelWO.tax" placeholder="Tax">
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
                                                <th style="width: 25%">Material Number</th>
                                                <th style="width: 25%">Material Description</th>
                                                <th style="width: 10%">Quantity</th>
                                                <th style="width: 10%">Order</th>
                                                <th style="width: 15%">Price / pcs (Rp.)</th>
                                                <th style="width: 10%">Discount (%)</th>
                                                <th style="width: 20%">WBS Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(WOD,index) in WODetail">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{ WOD.material.code }} </td>
                                                <td class="tdEllipsis">{{ WOD.material.description }}</td>
                                                <td class="tdEllipsis">{{ WOD.work_request_detail.quantity }}</td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control" v-model="WOD.quantity" placeholder="Please Input Quantity">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control" v-model="WOD.total_price" placeholder="Please Input Price / pcs">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control" v-model="WOD.discount" placeholder="Discount">
                                                </td>
                                                <td v-if="WOD.wbs != null" class="tdEllipsis">{{ WOD.wbs.number }}</td>
                                                <td v-else class="tdEllipsis">-</td>
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
        modelWO : @json($modelWO),
        WODetail : @json($modelWOD),
        modelProject : @json($modelProject),
        currencies : @json($currencies),
        modelVendor : [],
        vendorSettings: {
            placeholder: 'Please Select Vendor'
        },
        currencySettings: {
            placeholder: 'Please Select Currency'
        },
        currency : "",
        selectedCurrency : "",
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
                    this.modelWO.delivery_date = $('#delivery_date').val();
                }
            );
        },
        computed : {
            dataOk: function(){
                let isOk = false;
                if(this.vendor_id == "" || this.delivery_date == ""){
                    isOk = true;
                }
                return isOk;
            },
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
                var data = this.WODetail;
                data = JSON.stringify(data);
                data = JSON.parse(data);

                data.forEach(WOD => {
                    WOD.quantity = WOD.quantity.replace(/,/g , '');      
                    WOD.total_price = WOD.total_price.replace(/,/g , '');      
                });

                this.modelWO.estimated_freight = (this.modelWO.estimated_freight+"").replace(/,/g , '');   
                this.submittedForm.modelWO = this.modelWO;
                this.submittedForm.WODetail = data;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        watch : {
            WODetail:{
                handler: function(newValue) {
                    var data = newValue;
                    data.forEach(WOD => {
                        var is_decimal = WOD.material.uom.is_decimal;
                        if(is_decimal == 0){
                            WOD.quantity = (WOD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                        }else{
                            var decimal = WOD.quantity.replace(/,/g, '').split('.');
                            if(decimal[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal[1]+"").length > maxDecimal){
                                    WOD.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    WOD.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                WOD.quantity = (WOD.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                        } 

                        var decimal = (WOD.total_price+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                WOD.total_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                WOD.total_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            WOD.total_price = (WOD.total_price+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        } 

                        var discount = parseInt((WOD.discount+"").replace(/,/g, ''));
                        if(discount > 100){
                            iziToast.warning({
                                title: 'Discount cannot exceed 100% !',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            WOD.discount = 100;
                        }
                        var decimal = (WOD.discount+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                WOD.discount = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                WOD.discount = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            WOD.discount = (WOD.discount+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }            
                    });
                },
                deep: true
            },
            'modelWO.tax' : function (newValue){
                var tax = parseInt((newValue+"").replace(/,/g, ''));
                if(newValue > 100){
                    iziToast.warning({
                        title: 'Tax cannot exceed 100% !',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    this.modelWO.tax = 100;
                }
                var decimal = (newValue+"").replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.modelWO.tax = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.modelWO.tax = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.modelWO.tax = (this.modelWO.tax+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
            'modelWO.estimated_freight': function (newValue){
                var decimal = (newValue+"").replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.modelWO.estimated_freight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.modelWO.estimated_freight = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.modelWO.estimated_freight = (this.modelWO.estimated_freight+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
        },
        created: function() {
            this.getVendor();
            var data = this.WODetail;
            data.forEach(WOD => {
                WOD.total_price = WOD.total_price / WOD.quantity;
                var is_decimal = WOD.material.uom.is_decimal;
                if(is_decimal == 0){
                    WOD.quantity = (WOD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                }else{
                    var decimal = (WOD.quantity+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            WOD.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            WOD.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        WOD.quantity = (WOD.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }   
                WOD.total_price = (WOD.total_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        },
    });
</script>
@endpush
