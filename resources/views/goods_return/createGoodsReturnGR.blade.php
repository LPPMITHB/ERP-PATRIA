@extends('layouts.main')

@section('content-header')
@if($route == "/goods_return")
    @breadcrumb(
        [
            'title' => 'Create Goods Return',
            'items' => [
                'Dashboard' => route('index'),
                'Select Purchase Order' => route('goods_return.selectPO'),
                'Details' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/goods_return_repair")
    @breadcrumb(
        [
            'title' => 'Create Goods Return',
            'items' => [
                'Dashboard' => route('index'),
                'Select Purchase Order' => route('goods_return_repair.selectPO'),
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
                    <form id="create-gr" class="form-horizontal" method="POST" action="{{ route('goods_return.storeGR') }}">
                @elseif($route == "/goods_return_repair")
                    <form id="create-gr" class="form-horizontal" method="POST" action="{{ route('goods_return_repair.storeGR') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="pod">
                        <div class="col-sm-12 no-padding">
                            <div class="box-header">
                                <div class="col-xs-12 col-lg-6 col-md-12 no-padding">    
                                    <div class="box-body no-padding">
                                        <div class="col-md-4 col-xs-4 no-padding">GR Number</div>
                                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{ modelGR.number }}</b></div>

                                        <div class="col-md-4 col-xs-4 no-padding" v-if="is_pami">PO Number</div>
                                        <div class="col-md-8 col-xs-8 no-padding" v-if="is_pami"><b>: {{ Po_number }}</b></div>

                                        <div class="col-md-4 col-xs-4 no-padding" v-if="is_pami">PR Number</div>
                                        <div class="col-md-8 col-xs-8 no-padding" v-if="is_pami"><b>: {{ Pr_number }}</b></div>

                                        <div class="col-md-4 col-xs-4 no-padding">Vendor</div>
                                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{ vendor.name }}</b></div>
                
                                        <div class="col-md-4 col-xs-4 no-padding">Address</div>
                                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis"><b>: {{ vendor.address }}</b></div>

                                        <div class="col-md-4 col-xs-4 no-padding">Phone Number</div>
                                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{ vendor.phone_number }}</b></div>

                                        <div class="col-md-4 col-xs-4 no-padding">GR Description</div>
                                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toogle="tooltip" :title="tooltipText(modelGR.description)"><b>: {{ modelGR.description }}</b></div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-4 col-md-12 no-padding">    
                                    <div class="box-body no-padding">
                                        <div class="col-md-8 col-lg-7 col-xs-12 no-padding">Goods Return Description : <textarea class="form-control" rows="3" v-model="description" style="width:310px"></textarea>
                                        </div>
                                    </div>
                            </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <table class="table table-bordered tableFixed">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="20%">Material Number</th>
                                                <th width="30%">Material Description</th>
                                                <th width="15%">Quantity</th>
                                                <th width="15%">Return Qty</th>
                                                <th width="10%">Unit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(GRD,index) in modelGRD">
                                                <td>{{ index+1 }}</td>
                                                <td>{{ GRD.material.code }}</td>
                                                <td>{{ GRD.material.description }}</td>
                                                <td>{{ GRD.available }} </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control width100" v-model="GRD.returned_temp" placeholder="Please Input Returned Quantity">
                                                </td>
                                                <td>{{ GRD.material.uom.unit }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 p-t-10">
                                    <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
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
    const form = document.querySelector('form#create-gr');

    $(document).ready(function(){
        $('div.overlay').hide();

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
    });

    var data = {
        modelGRD : @json($modelGRD),
        modelGR :   @json($modelGR),
        Po_number : @json($Po_number),
        Pr_number : @json($Pr_number),
        is_pami : @json($is_pami),
        vendor : @json($vendor),
        description:"",
        submittedForm :{},
    }

    var vm = new Vue({
        el : '#pod',
        data : data,
        computed : {
            createOk: function(){
                let isOk = true;
                this.modelGRD.forEach(GRD => {
                    if((GRD.returned_temp+"").replace(/,/g , '') > 0){
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
            changeText(){
                if(document.getElementsByClassName('tooltip-inner')[0]!= undefined){
                    if(document.getElementsByClassName('tooltip-inner')[0].innerHTML != modelGR.vendor.address ){
                        document.getElementsByClassName('tooltip-inner')[0].innerHTML= modelGR.vendor.address;    
                    }
                }
            }, 
            
            submitForm(){
                $('div.overlay').show();
                var data = this.modelGRD;
                data = JSON.stringify(data)
                data = JSON.parse(data)

                data.forEach(GRD => {
                    GRD.returned_temp = GRD.returned_temp.replace(/,/g , '');   
                });
                this.submittedForm.GRD = data;
                this.submittedForm.purchase_order_id = this.modelGR.purchase_order_id;
                this.submittedForm.goods_receipt_id = this.modelGR.id;
                this.submittedForm.description = this.description;

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
                    this.modelGRD.forEach(GRD => {
                        if((parseFloat((GRD.quantity+"").replace(/,/g , '')) - parseFloat((GRD.returned+"").replace(/,/g , ''))) < parseFloat((GRD.returned_temp+"").replace(/,/g , ''))){
                            GRD.returned_temp = GRD.quantity;
                            iziToast.warning({
                                title: 'Cannot input more than available quantity..',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                        }
                        
                        var is_decimal = GRD.is_decimal;
                        if(is_decimal == 0){
                            GRD.returned_temp = (GRD.returned_temp+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
                        }else{
                            var decimal = (GRD.returned_temp+"").replace(/,/g, '').split('.');
                            if(decimal[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal[1]+"").length > maxDecimal){
                                    GRD.returned_temp = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    GRD.returned_temp = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                GRD.returned_temp = (GRD.returned_temp+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
