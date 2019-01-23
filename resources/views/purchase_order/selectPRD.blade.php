@extends('layouts.main')
@if($modelPR->type == 1)
    @php($type = 'Material')
@else  
    @php($type = 'Resource')
@endif
@section('content-header')
@if($route == "/purchase_order")
    @breadcrumb(
        [
            'title' => 'Create Purchase Order » Select '.$type,
            'items' => [
                'Dashboard' => route('index'),
                'Select Purchase Requisition' => route('purchase_order.selectPR'),
                'Select Material' => ''
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/purchase_order_repair")
    @breadcrumb(
        [
            'title' => 'Create Purchase Order » Select '.$type,
            'items' => [
                'Dashboard' => route('index'),
                'Select Purchase Requisition' => route('purchase_order_repair.selectPR'),
                'Select Material' => ''
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
                @if($route == "/purchase_order")
                    <form id="select-material" class="form-horizontal" action="{{ route('purchase_order.create') }}">
                @elseif($route == "/purchase_order_repair")
                    <form id="select-material" class="form-horizontal" action="{{ route('purchase_order_repair.create') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="prd">
                        <table class="table table-bordered tableFixed tablePagingVue">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th v-if="modelPR.type == 1" width="30%">Material</th>
                                    <th v-else width="30%">Resource</th>
                                    <th width="10%">Quantity</th>
                                    <th width="10%">Ordered</th>
                                    <th width="10%">Remaining</th>
                                    <th width="20%">WBS Name</th>
                                    <th width="10%">Alocation</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(PRD,index) in modelPRD">
                                    <td>{{ index+1 }}</td>
                                    <td v-if="PRD.material != null">{{ PRD.material.code }} - {{ PRD.material.name }}</td>
                                    <td v-else>{{ PRD.resource.code }} - {{ PRD.resource.name }}</td>
                                    <td>{{ PRD.quantity }}</td>
                                    <td>{{ PRD.reserved }}</td>
                                    <td>{{ PRD.remaining }}</td>
                                    <td v-if="PRD.wbs != null">{{ PRD.wbs.name }}</td>
                                    <td v-else>-</td>
                                    <td v-if="PRD.alocation != null">{{ PRD.alocation }}</td>
                                    <td v-else>-</td>
                                    <td class="no-padding p-t-2 p-b-2" align="center">
                                        <input type="checkbox" v-icheck="" v-model="checkedPRD" :value="PRD.id">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 p-t-10">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                            </div>
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
    const form = document.querySelector('form#select-material');

    $(document).ready(function(){
        $('.tablePagingVue thead tr').clone(true).appendTo( '.tablePagingVue thead' );
        $('.tablePagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == '' || title == 'No' || title == "Quantity" || title == "Ordered" || title == "Remaining"){
                $(this).html( '<input disabled class="form-control width100" type="text"/>' );
            }else{
                $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
            }

            $( 'input', this ).on( 'keyup change', function () {
                if ( tablePagingVue.column(i).search() !== this.value ) {
                    tablePagingVue
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            });
        });

        var tablePagingVue = $('.tablePagingVue').DataTable( {
            orderCellsTop   : true,
            fixedHeader     : true,
            paging          : true,
            autoWidth       : false,
            lengthChange    : false,
        });

        $('div.overlay').hide();
    });

    var data = {
        modelPRD : @json($modelPRD),
        modelPR : @json($modelPR),
        checkedPRD : [],
        submittedForm : {},
    }

    var app = new Vue({
        el : '#prd',
        data : data,
        computed:{
            createOk: function(){
                let isOk = false;
                if(this.checkedPRD.length == 0){
                    isOk = true;
                }
                return isOk;
            },
        },
        methods: {
            submitForm(){
                var prd = this.checkedPRD;
                var jsonPrd = JSON.stringify(prd);
                jsonPrd = JSON.parse(jsonPrd);

                this.submittedForm.type = this.modelPR.type;
                this.submittedForm.checkedPRD = jsonPrd;            
                this.submittedForm.id = this.modelPR.id;            

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        directives: {
            icheck: {
                inserted: function(el, b, vnode) {
                    var vdirective = vnode.data.directives,
                    vModel;
                    for (var i = 0, vDirLength = vdirective.length; i < vDirLength; i++) {
                        if (vdirective[i].name == "model") {
                            vModel = vdirective[i].expression;
                            break;
                        }
                    }
                    jQuery(el).iCheck({
                        checkboxClass: "icheckbox_square-blue",
                        radioClass: "iradio_square-blue",
                        increaseArea: "20%" // optional
                    });
                    jQuery(el).on("ifChanged", function(e) {
                        if ($(el).attr("type") == "radio") {
                            app.$data[vModel] = $(this).val();
                        }
                        if ($(el).attr("type") == "checkbox") {
                            let data = app.$data[vModel];

                            $(el).prop("checked")
                            ? app.$data[vModel].push($(this).val())
                            : data.splice(data.indexOf($(this).val()), 1);
                        }
                    });
                }
            }
        },
        created: function() {
            var data = this.modelPRD;
            data.forEach(PRD => {
                PRD.remaining = PRD.quantity - PRD.reserved;
                PRD.remaining = (PRD.remaining+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                PRD.quantity = (PRD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                PRD.reserved = (PRD.reserved+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        }
    });
</script>
@endpush