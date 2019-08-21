@extends('layouts.main')

@section('content-header')
@if($route == "/goods_return")
    @breadcrumb(
        [
            'title' => 'Edit Goods Return',
            'items' => [
                'Dashboard' => route('index'),
                'View All Goods Returns' => route('goods_return.index'),
                'Details' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/goods_return_repair")
    @breadcrumb(
        [
            'title' => 'Edit Goods Return',
            'items' => [
                'Dashboard' => route('index'),
                'View All Goods Returns' => route('goods_return.index'),
                'Details' => '',
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">
                @if($route == "/goods_return")
                    <form id="update-gr" class="form-horizontal" method="POST" action="{{ route('goods_return.update',['id'=>$modelGR->id]) }}">
                @elseif($route == "/goods_return_repair")
                    <form id="update-gr" class="form-horizontal" method="POST" action="{{ route('goods_return_repair.update',['id'=>$modelGR->id]) }}">
                @endif
                <input type="hidden" name="_method" value="PATCH">
                @csrf
                    @verbatim
                    <div id="edit-grt">
                        <div class="col-sm-12 no-padding">
                            <div class="box-header p-t-0">
                                <div class="col-xs-12 col-lg-6 col-md-12 no-padding">
                                    <div class="box-body no-padding">
                                        <div class="col-md-4 col-xs-4 no-padding">GRT Number</div>
                                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{ modelGR.number }}</b></div>

                                        <div class="col-md-4 col-xs-4 no-padding" v-if="modelGR.purchase_order_id != null">PO Number</div>
                                        <div class="col-md-4 col-xs-4 no-padding" v-if="modelGR.goods_receipt_id != null">GR Number</div>
                                        <div class="col-md-8 col-xs-8 no-padding" v-if="modelGR.purchase_order_id != null"><b>: {{ modelGR.purchase_order.number }}</b></div>
                                        <div class="col-md-8 col-xs-8 no-padding" v-if="modelGR.goods_receipt_id != null"><b>: {{ modelGR.goods_receipt.number }}</b></div>

                                        <div class="col-md-4 col-xs-4 no-padding">Vendor</div>
                                        <div class="col-md-8 col-xs-8 no-padding" v-if="modelGR.purchase_order_id != null"><b>: {{ modelGR.purchase_order.vendor.name }}</b></div>
                                        <div class="col-md-8 col-xs-8 no-padding" v-if="modelGR.goods_receipt_id != null">
                                            <div v-if="modelGR.goods_receipt.purchase_order_id != null">
                                                <b>: {{ modelGR.goods_receipt.purchase_order.vendor.name }}</b>
                                            </div>
                                            <div v-else-if="modelGR.goods_receipt.work_order_id != null">
                                                <b>: {{ modelGR.goods_receipt.work_order.vendor.name }}</b>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-xs-4 no-padding">Address</div>
                                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" v-if="modelGR.purchase_order_id != null"><b>: {{ modelGR.purchase_order.vendor.address }}</b></div>
                                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" v-if="modelGR.goods_receipt_id != null">
                                            <div v-if="modelGR.goods_receipt.purchase_order_id != null">
                                                <b>: {{ modelGR.goods_receipt.purchase_order.vendor.address }}</b>
                                            </div>
                                            <div v-else-if="modelGR.goods_receipt.work_order_id != null">
                                                <b>: {{ modelGR.goods_receipt.work_order.vendor.address }}</b>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-xs-4 no-padding">Phone Number</div>
                                        <div class="col-md-8 col-xs-8 no-padding" v-if="modelGR.purchase_order_id != null"><b>: {{ modelGR.purchase_order.vendor.phone_number }}</b></div>
                                        <div class="col-md-8 col-xs-8 no-padding" v-if="modelGR.goods_receipt_id != null">
                                            <div v-if="modelGR.goods_receipt.purchase_order_id != null">
                                                <b>: {{ modelGR.goods_receipt.purchase_order.vendor.phone_number }}</b>
                                            </div>
                                            <div v-else-if="modelGR.goods_receipt.work_order_id != null">
                                                <b>: {{ modelGR.goods_receipt.work_order.vendor.phone_number }}</b>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-xs-4 no-padding" v-if="modelGR.purchase_order_id != null">PO Description</div>
                                        <div class="col-md-4 col-xs-4 no-padding" v-if="modelGR.goods_receipt_id != null">GR Description</div>
                                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toogle="tooltip" :title="tooltipText(modelGR.purchase_order.description)" v-if="modelGR.purchase_order_id != null"><b>: {{ modelGR.purchase_order.description }}</b></div>
                                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toogle="tooltip" :title="tooltipText(modelGR.goods_receipt.description)" v-if="modelGR.goods_receipt_id != null"><b>: {{ modelGR.goods_receipt.description }}</b></div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-4 col-md-12 no-padding">
                                    <div class="box-body no-padding">
                                        <div class="col-md-12 col-lg-12 col-xs-12 no-padding">Goods Return Description : <textarea class="form-control" rows="2" v-model="description" style="width:360px"></textarea>
                                        </div>
                                    </div>
                                    <div class="box-body no-padding">
                                        <div class="col-md-12 col-lg-12 col-xs-12 no-padding" v-if="modelGR.status == 3">
                                            Goods Return Revision Description : <textarea class="form-control" rows="2" v-model="revision_description" style="width:360px"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <table class="table table-bordered tableFixed" id="gr-table">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="30%">Material Name</th>
                                                <th width="30%">Material Description</th>
                                                <th width="5%">Unit</th>
                                                <th width="15%">Material Quantity</th>
                                                <th width="15%">Return Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(GRD,index) in modelGRD">
                                                <td>{{ index+1 }}</td>
                                                <td>{{ GRD.material_code }}</td>
                                                <td>{{ GRD.material_name }}</td>
                                                <td>{{ GRD.unit }}</td>
                                                <td>{{ GRD.available }} </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control width100" v-model="GRD.quantity" placeholder="Please Input Returned Quantity">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 p-t-10">
                                    <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">SAVE</button>
                                </div>
                            </div>
                        </div>
                    @endverbatim
                </form>
        </div><!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    const form = document.querySelector('form#update-gr');

    $(document).ready(function(){
        // $('div.overlay').hide();

        // $('.tablePagingVue thead tr').clone(true).appendTo( '.tablePagingVue thead' );
        // $('.tablePagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
        //     var title = $(this).text();
        //     if(title == 'Material Name' || title == 'Storage Location'){
        //         $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
        //     }else{
        //         $(this).html( '<input disabled class="form-control width100" type="text"/>' );
        //     }

        //     $( 'input', this ).on( 'keyup change', function () {
        //         if ( tablePagingVue.column(i).search() !== this.value ) {
        //             tablePagingVue
        //                 .column(i)
        //                 .search( this.value )
        //                 .draw();
        //         }
        //     });
        // });

        // var tablePagingVue = $('.tablePagingVue').DataTable( {
        //     orderCellsTop   : true,
        //     paging          : false,
        //     autoWidth       : false,
        //     lengthChange    : false,
        //     info            : false,
        // });
        $('#gr-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
    });

    var data = {
        modelGRD : @json($modelGRD),
        modelGR : @json($modelGR),
        description: "",
        revision_description: "",
        submittedForm :{},
    }

    var vm = new Vue({
        el : '#edit-grt',
        data : data,
        computed : {
            createOk: function(){
                let isOk = true;
                this.modelGRD.forEach(GRD => {
                    if((GRD.quantity+"").replace(/,/g , '') > 0){
                        isOk = false;
                    }
                });
                return isOk;
            }
        },
        methods : {
            tooltipText($text){
                return $text;
            },

            submitForm(){
                $('div.overlay').show();
                var data = this.modelGRD;
                data = JSON.stringify(data)
                data = JSON.parse(data)

                data.forEach(GRD => {
                    GRD.quantity = GRD.quantity.replace(/,/g , '');
                    GRD.quantity = parseFloat(GRD.quantity);
                });

                this.submittedForm.GRD = data;
                this.submittedForm.goods_return_id = this.modelGR.id;
                this.submittedForm.description = this.description;
                this.submittedForm.revision_description = this.revision_description;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        watch : {
            modelGRD:{
                handler: function(newValue) {
                    var data = newValue;
                    data.forEach(GRD => {
                        if((parseFloat((GRD.available+"").replace(/,/g , ''))) < parseFloat((GRD.quantity+"").replace(/,/g , ''))){
                            GRD.quantity = GRD.available;
                            iziToast.warning({
                                title: 'Cannot input more than received quantity..',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                        }
                        if(GRD.is_decimal == 0){
                            GRD.quantity = (GRD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                        }else if(GRD.is_decimal == 1){
                            var decimal = (GRD.quantity+"").replace(/,/g, '').split('.');
                            if(decimal[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal[1]+"").length > maxDecimal){
                                    GRD.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    GRD.quantity = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                GRD.quantity = (GRD.quantity+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                        }
                    });
                },
                deep: true
            },
        },
        created: function(){
            this.modelGRD.forEach(GRD => {
                var is_decimal = GRD.is_decimal;
                if(is_decimal == 0){
                    GRD.available = (GRD.available+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }else{
                    var decimal = (GRD.available+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            GRD.available = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            GRD.available = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        GRD.available = (GRD.available+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            });
        },
    });
</script>
@endpush
