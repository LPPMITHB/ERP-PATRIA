@extends('layouts.main')
@section('content-header')
@if($menu == "building")
    @breadcrumb(
        [
            'title' => 'Create Work Order » Select Material',
            'items' => [
                'Dashboard' => route('index'),
                'Select Work Requisition' => route('work_order.selectWR'),
                'Select Material' => route('work_order.selectWRD',$modelWR->id),
                'Create Work Order' => "",
            ]
        ]
    )
    @endbreadcrumb
@else
    @breadcrumb(
        [
            'title' => 'Create Work Order » Select Material',
            'items' => [
                'Dashboard' => route('index'),
                'Select Work Requisition' => route('work_order_repair.selectWR'),
                'Select Material' => route('work_order_repair.selectWRD',$modelWR->id),
                'Create Work Order' => "",
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
            @if($menu == "building")
                <form id="create-po" class="form-horizontal" method="POST" action="{{ route('work_order.store') }}">
            @else
                <form id="create-po" class="form-horizontal" method="POST" action="{{ route('work_order_repair.store') }}">
            @endif        
            @csrf
                @verbatim
                    <div id="po">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-xs-12 col-md-4" v-if="modelProject != null">
                                    <div class="col-xs-5 no-padding">WR Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelWR.number}}</b></div>
            
                                    <div class="col-xs-5 no-padding">Project Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelProject.number}}</b></div>
                                    
                                    <div class="col-xs-5 no-padding">Ship Type</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelProject.ship.type}}</b></div>
            
                                    <div class="col-xs-5 no-padding">Customer</div>
                                    <div class="col-xs-7 no-padding tdEllipsis" v-tooltip:top="modelProject.customer.name"><b>: {{modelProject.customer.name}}</b></div>

                                    <div class="col-xs-5 no-padding">Start Date</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelProject.planned_start_date}}</b></div>

                                    <div class="col-xs-5 no-padding">End Date</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelProject.planned_end_date}}</b></div>
                                </div>
                                <div class="col-xs-12 col-md-4" v-else>
                                    <div class="col-xs-5 no-padding">WR Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: {{modelWR.number}}</b></div>

                                    <div class="col-xs-5 no-padding">Project Number</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: -</b></div>
                                    
                                    <div class="col-xs-5 no-padding">Ship Type</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: -</b></div>
            
                                    <div class="col-xs-5 no-padding">Customer</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: -</b></div>

                                    <div class="col-xs-5 no-padding">Start Date</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: -</b></div>

                                    <div class="col-xs-5 no-padding">End Date</div>
                                    <div class="col-xs-7 no-padding tdEllipsis"><b>: -</b></div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="type">Vendor Name</label>
                                            <selectize v-model="vendor_id" :settings="vendorSettings">
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
                                        <textarea class="form-control" rows="3" v-model="description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body p-t-0">
                            <div class="row">
                                <div class="col sm-12 p-l-15 p-r-15 p-t-0">
                                    <table class="table table-bordered tableFixed p-t-10 tableNonPagingVue" style="border-collapse:collapse;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th style="width: 30%">Material Name</th>
                                                <th style="width: 10%">Quantity</th>
                                                <th style="width: 10%">Order</th>
                                                <th style="width: 15%">Price / pcs (Rp.)</th>
                                                <th style="width: 10%">Discount (%)</th>
                                                <th style="width: 30%">WBS Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(WRD,index) in WRDetail">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{ WRD.material.code }} - {{ WRD.material.name }}</td>
                                                <td class="tdEllipsis">{{ WRD.sugQuantity }}</td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control" v-model="WRD.quantity" placeholder="Please Input Quantity">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control" v-model="WRD.cost" placeholder="Please Input Price / pcs">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control" v-model="WRD.discount" placeholder="Discount">
                                                </td>
                                                <td class="tdEllipsis" v-if="WRD.wbs != null">{{ WRD.wbs.name }}</td>
                                                <td class="tdEllipsis" v-else>-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 p-r-0">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="dataOk">CREATE</button>
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
    const form = document.querySelector('form#create-po');

    $(document).ready(function(){
        $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == "Quantity" || title == "Order" || title == "Price / pcs (Rp.)" || title == "Discount (%)"){
                $(this).html( '<input disabled class="form-control width100" type="text"/>' );
            }else{
                $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
            }

            $( 'input', this ).on( 'keyup change', function () {
                if ( tableNonPagingVue.column(i).search() !== this.value ) {
                    tableNonPagingVue
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            });
        });

        var tableNonPagingVue = $('.tableNonPagingVue').DataTable( {
            orderCellsTop   : true,
            paging          : false,
            autoWidth       : false,
            lengthChange    : false,
            info            : false,
            ordering        : false,
        });

        $('div.overlay').hide();
    });

    var data = {
        modelWR : @json($modelWR),
        WRDetail : @json($modelWRD),
        modelProject : @json($modelProject),
        modelVendor : [],
        vendorSettings: {
            placeholder: 'Please Select Vendor'
        },
        vendor_id : "",
        description : "",
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
                this.WRDetail.forEach(wrd => {
                    if(wrd.cost == 0 || wrd.cost == ""){
                        isOk = true;
                    }
                });
                return isOk;
            },
        },
        methods : {
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
                var data = this.WRDetail;
                data = JSON.stringify(data);
                data = JSON.parse(data);

                data.forEach(WRD => {
                    WRD.quantity = WRD.quantity.replace(/,/g , '');      
                    WRD.cost = (WRD.cost).replace(/,/g , '');      
                });

                this.submittedForm.WRD = data;
                this.submittedForm.vendor_id = this.vendor_id;
                this.submittedForm.description = this.description;
                this.submittedForm.wr_id = this.modelWR.id;
                this.submittedForm.project_id = this.modelWR.project_id;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        watch : {
            WRDetail:{
                handler: function(newValue) {
                    var data = newValue;
                    data.forEach(WRD => {
                        WRD.quantity = (WRD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                        var decimal = (WRD.cost+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                WRD.cost = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                WRD.cost = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            WRD.cost = (WRD.cost+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        } 

                        var discount = parseInt((WRD.discount+"").replace(/,/g, ''));
                        if(discount > 100){
                            iziToast.warning({
                                title: 'Discount cannot exceed 100% !',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                            WRD.discount = 100;
                        }
                        var decimal = (WRD.discount+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                WRD.discount = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                WRD.discount = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            WRD.discount = (WRD.discount+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }  
                    });
                },
                deep: true
            },
        },
        created: function() {
            this.getVendor();
            var data = this.WRDetail;
            data.forEach(WRD => {
                WRD.quantity = WRD.quantity - WRD.reserved;
                WRD.sugQuantity = WRD.quantity;
                WRD.quantity = (WRD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                WRD.sugQuantity = (WRD.sugQuantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
            Vue.directive('tooltip', function(el, binding){
                $(el).tooltip({
                    title: binding.value,
                    placement: binding.arg,
                    trigger: 'hover'             
                })
            })
        },
    });
</script>
@endpush
