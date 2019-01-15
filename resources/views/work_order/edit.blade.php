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
            @if($menu == "building")
                <form id="edit-po" class="form-horizontal" method="POST" action="{{ route('work_order.update') }}">
            @else
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
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="type">Vendor Name</label>
                                            <selectize v-model="modelWO.vendor_id" :settings="vendorSettings">
                                                <option v-for="(vendor, index) in modelVendor" :value="vendor.id">{{ vendor.code }} - {{ vendor.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="col-sm-12">
                                        <label for="">WO Description</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" rows="3" v-model="modelWO.description"></textarea>
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
                                                <th style="width: 30%">Material Name</th>
                                                <th style="width: 10%">Quantity</th>
                                                <th style="width: 10%">Order</th>
                                                <th style="width: 15%">Price / pcs (Rp.)</th>
                                                <th style="width: 30%">WBS Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(WOD,index) in WODetail">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{ WOD.material.code }} - {{ WOD.material.name }}</td>
                                                <td class="tdEllipsis">{{ WOD.work_request_detail.quantity }}</td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control" v-model="WOD.quantity" placeholder="Please Input Quantity">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control" v-model="WOD.total_price" placeholder="Please Input Price / pcs">
                                                </td>
                                                <td v-if="WOD.wbs != null" class="tdEllipsis">{{ WOD.wbs.name }}</td>
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
        modelVendor : [],
        vendorSettings: {
            placeholder: 'Please Select Vendor'
        },
        submittedForm : {},
    }

    var vm = new Vue({
        el : '#po',
        data : data,
        computed : {
            dataOk: function(){
                let isOk = false;
                if(this.vendor_id == ""){
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
                        WOD.quantity = (WOD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");     
                        WOD.total_price = (WOD.total_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
                    });
                },
                deep: true
            },
        },
        created: function() {
            this.getVendor();
            var data = this.WODetail;
            data.forEach(WOD => {
                WOD.total_price = WOD.total_price / WOD.quantity;        
                WOD.quantity = (WOD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");    
                WOD.total_price = (WOD.total_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        },
    });
</script>
@endpush
