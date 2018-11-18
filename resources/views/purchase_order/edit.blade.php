@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Edit Purchase Order',
        'items' => [
            'Dashboard' => route('index'),
            'Edit Purchase Order' => route('purchase_order.edit',$modelPO->id),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <form id="edit-po" class="form-horizontal" method="POST" action="{{ route('purchase_order.update') }}">
            <input type="hidden" name="_method" value="PATCH">
            @csrf
                @verbatim
                    <div id="po">
                        <div class="box_header">
                            <div class="row">
                                <div class="col-sm-4 col-md-4 p-l-25">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="type" class="control-label m-b-10">Vendor Name</label>
                                            <selectize v-model="modelPO.vendor_id" :settings="vendorSettings">
                                                <option v-for="(vendor, index) in modelVendor" :value="vendor.id">{{ vendor.code }} - {{ vendor.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 m-t-10">
                                    <div class="col-sm-12">
                                        <label for="">PO Description</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" rows="3" v-model="modelPO.description"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 m-t-10">
                                    <div class="row">
                                        <div class="col-md-4">
                                            PO Number
                                        </div>
                                        <div class="col-md-8">
                                            : <b> {{ modelPO.number }} </b>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            PR Number
                                        </div>
                                        <div class="col-md-8">
                                            : <b> {{ modelPO.purchase_requisition.number }} </b>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Project Code
                                        </div>
                                        <div class="col-md-8">
                                            : <b> {{ modelProject.code }} </b>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Ship
                                        </div>
                                        <div class="col-md-8">
                                            : <b> {{ modelProject.ship.name }} </b>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            Customer
                                        </div>
                                        <div class="col-md-8">
                                            : <b> {{ modelProject.customer.name }} </b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col sm-12 p-l-15 p-r-15 p-t-10">
                                    <table class="table table-bordered tableFixed p-t-10" style="border-collapse:collapse;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th style="width: 30%">Material Name</th>
                                                <th style="width: 15%">Quantity</th>
                                                <th style="width: 15%">Order</th>
                                                <th style="width: 15%">Price / pcs</th>
                                                <th style="width: 35%">Work Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(POD,index) in PODetail">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{ POD.material.code }} - {{ POD.material.name }}</td>
                                                <td class="tdEllipsis">{{ POD.purchase_requisition_detail.quantity }}</td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control" v-model="POD.quantity" placeholder="Please Input Quantity">
                                                </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control" v-model="POD.total_price" placeholder="Please Input Price / pcs">
                                                </td>
                                                <td class="tdEllipsis">{{ POD.work.name }}</td>
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

                data.forEach(POD => {
                    POD.quantity = POD.quantity.replace(/,/g , '');      
                    POD.total_price = POD.total_price.replace(/,/g , '');      
                });

                this.submittedForm.modelPO = this.modelPO;
                this.submittedForm.PODetail = data;

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
                        POD.quantity = (POD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");     
                        POD.total_price = (POD.total_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
                    });
                },
                deep: true
            },
        },
        created: function() {
            this.getVendor();
            var data = this.PODetail;
            data.forEach(POD => {
                POD.total_price = POD.total_price / POD.quantity;        
                POD.quantity = (POD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");    
                POD.total_price = (POD.total_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        },
    });
</script>
@endpush
