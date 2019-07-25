@extends('layouts.main')

@section('content-header')
@if($menu == "building")
    @breadcrumb(
        [
            'title' => 'Edit Reverse Transaction » '.$modelRT->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Reverse Transaction' => route('reverse_transaction.selectDocument'),
                'Create Reverse Transaction' => '',
            ]
        ]
    )
    @endbreadcrumb
{{-- @elseif($menu == "/reverse_transaction_repair")
    @breadcrumb(
        [
            'title' => 'View Goods Receipt » '.$modelRT->number,
            'items' => [
                'Dashboard' => route('index'),
                'View All Goods Receipts' => route('reverse_transaction_repair.index'),
                'View Goods Receipt' => '',
            ]
        ]
    )
    @endbreadcrumb --}}
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <div class="box">
            @verbatim
            <div id="edit_reverse_transaction">
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        <div class="box-header no-padding">
                            <div class="box-body" v:if="modelRT.type == 1">
                                <div class="col-md-4 col-xs-4 no-padding">GR Number</div>
                                <div class="col-md-6 no-padding">: <b> {{ old_gr_ref.number }} </b></div>
                                
                                <div class="col-md-4 col-xs-4 no-padding">PO Number</div>
                                <div class="col-md-6 no-padding">: <b> {{ old_gr_ref.purchase_order != null ? old_gr_ref.purchase_order.number : '-' }} </b></div>

                                <div class="col-md-4 col-xs-4 no-padding">Project Number</div>
                                <div class="col-md-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" :title="(old_gr_ref.purchase_order.project != null ? old_gr_ref.purchase_order.project.number : '-')">: <b> {{ old_gr_ref.purchase_order.project != null ? old_gr_ref.purchase_order.project.number : '-'}} </b></div>

                                <div class="col-md-4 col-xs-4 no-padding">Vendor Name</div>
                                <div class="col-md-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" :title="(old_gr_ref.purchase_order != null  ? old_gr_ref.purchase_order.vendor.name : '-')">: <b> {{ old_gr_ref.purchase_order != null  ? old_gr_ref.purchase_order.vendor.name : '-'}} </b></div>

                                <div class="col-md-4 col-xs-4 no-padding">Ship Date</div>
                                <div class="col-md-6 no-padding">: <b> {{ old_gr_ref.ship_date != null ? old_gr_ref.ship_date.split("-").reverse().join("-") : '-'}} </b></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="box-header no-padding">
                            <div class="box-body" v-if="modelRT.type == 1">
                                <div class="col-md-12 col-xs-12 no-padding">Goods Receipt Description :</div>
                                <div class="col-md-12 col-xs-12 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" :title="(old_gr_ref.description)"> <b> {{ old_gr_ref.description }} </b></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="box-header no-padding">
                            <div class="box-body">
                                <div class="col-md-12 col-xs-12 no-padding">Reverse Transaction Description</div>
                                <div class="col-sm-12 p-l-0">
                                    <textarea class="form-control" rows="3" v-model="description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="box-body p-t-0">
                    <div class="col-sm-12">
                        <div class="row">
                            <table id="data-table" class="table table-bordered tableFixed" v-show="modelRT.type == 1">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Material Number</th>
                                        <th width="20%">Material Description</th>
                                        <th width="5%">Unit</th>
                                        <th width="25%">Storage Location</th>
                                        <th width="10%">PO Qty</th>
                                        <th width="10%">Old Qty</th>
                                        <th width="10%">New Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data,index) in modelRTDetails">
                                        <td>{{ index + 1 }}</td>
                                        <td class="tdEllipsis">{{ data.material.code }}</td>
                                        <td class="tdEllipsis" data-container="body" data-toggle="tooltip" :title="(data.material.description)">{{ data.material.description }}</td>
                                        <td class="tdEllipsis">{{ data.material.uom.unit }}</td>
                                        <td class="tdEllipsis">{{ data.grd.storage_location.name }}</td>
                                        <td class="tdEllipsis">{{ data.po_detail.quantity }}</td>
                                        <td class="tdEllipsis">{{ data.old_quantity }}</td>
                                        <td class="no-padding"><input class="form-control width100" v-model="data.new_quantity" placeholder="New Qty"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="col-md-12 p-r-0 p-t-10">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="allOk">CREATE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endverbatim
        @if($menu == 'building')
            <form id="edit-rt" class="form-horizontal" method="POST" action="{{ route('reverse_transaction.update',$modelRT->id) }}">
                @csrf
                <input type="hidden" name="_method" value="PATCH">
            </form>
        {{-- @else       
            <form id="edit-rt" class="form-horizontal" method="POST" action="{{ route('material_requisition_repair.store') }}">
                @csrf
                <input type="hidden" name="_method" value="PATCH">
            </form> --}}
        @endif
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    const form = document.querySelector('form#edit-rt');

    $(document).ready(function(){
        var data_table = $('#data-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'bFilter'     : true,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
        $('div.overlay').hide();
    });

    var data = {
        modelRTDetails : @json($modelRTDetails),
        modelRT : @json($modelRT),
        old_gr_ref : @json($old_gr_ref),
        status : @json($status),
        menu : @json($menu),
        description : @json($modelRT->description),
        submittedForm : {},
    }

    var vm = new Vue({
        el : '#edit_reverse_transaction',
        data : data,
        computed: {
            allOk: function(){
                let isOk = true;

                var max_i = this.modelRTDetails.length;
                var i = 0;
                while(isOk && i < max_i){
                    if(this.modelRTDetails[i].new_quantity > 0){
                        isOk = false;
                    }
                    i++;
                }

                return isOk;
            },
        },
        methods:{
            submitForm(){
                iziToast.question({
                    close: false,
                    overlay: true,
                    timeout : 0,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirm',
                    message: 'Any material with the new quantity left blank will be counted as 0 for its new quantity,</br>Are you sure you want to reverse this transaction??',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            $('div.overlay').show();
                            var submitted_data = [];
                            var temp_data = vm.modelRTDetails;
                            temp_data = JSON.stringify(temp_data);
                            temp_data = JSON.parse(temp_data);

                            temp_data.forEach(data => {
                                if(data.new_quantity != ""){
                                    data.new_quantity = parseFloat(data.new_quantity.replace(/,/g , ''));       
                                }else{
                                    data.new_quantity = 0;
                                }
                            });

                            vm.submittedForm.description = vm.description;
                            vm.submittedForm.modelRTDetails = temp_data;
                            
                            let struturesElem = document.createElement('input');
                            struturesElem.setAttribute('type', 'hidden');
                            struturesElem.setAttribute('name', 'datas');
                            struturesElem.setAttribute('value', JSON.stringify(vm.submittedForm));
                            form.appendChild(struturesElem);
                            form.submit();
                            $('div.overlay').hide();
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                
                        }],
                    ],
                });
            },
        },
        watch : {
            modelRTDetails:{
                handler: function(newValue) {
                    newValue.forEach(data => {
                        if(data.new_quantity != ""){
                            var temp = parseFloat((data.new_quantity+"").replace(",", ""));
                            if(temp>data.po_detail.quantity){
                                iziToast.warning({
                                    title: 'The new quantity cannot be more than PO quantity',
                                    position: 'topRight',
                                    displayMode: 'replace',
                                });
                                data.new_quantity = data.po_detail.quantity;
                            }
                            if(data.material.uom.is_decimal == 1){
                                var decimal = (data.new_quantity+"").replace(/,/g, '').split('.');
                                if(decimal[1] != undefined){
                                    var maxDecimal = 2;
                                    if((decimal[1]+"").length > maxDecimal){
                                        data.new_quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                    }else{
                                        data.new_quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                    }
                                }else{
                                    data.new_quantity = (data.new_quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                }
                            }else{
                                data.new_quantity = ((data.new_quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                            }
                        }
                    });
                },
                deep: true
            },
        },
        editd: function() {

        },
    });
</script>
@endpush
