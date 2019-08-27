@extends('layouts.main')
@section('content-header')
@if($route == "/invoice")
    @breadcrumb(
        [
            'title' => 'Create Invoice',
            'items' => [
                'Dashboard' => route('index'),
                'Create Invoice' => '',
            ]
        ]
    )@endbreadcrumb
@elseif($route == "/invoice_repair")
    @breadcrumb(
        [
            'title' => 'Create Invoice',
            'items' => [
                'Dashboard' => route('index'),
                'Create Invoice' => '',
            ]
        ]
    )@endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body no-padding">
                @if($route == "/invoice")
                    <form id="invoice" class="form-horizontal" method="POST" action="{{ route('invoice.store') }}">
                @elseif($route == "/invoice_repair")
                    <form id="invoice" class="form-horizontal" method="POST" action="{{ route('invoice_repair.store') }}">
                @endif
                @csrf
                    <div class="box-body">
                        @verbatim
                        <div id="invoice">
                            <div class="box-header no-padding">
                                <div class="col-xs-12">
                                    <b>Project Information</b>
                                </div>
                                <div class="col-sm-5 no-padding">
                                    <div class="col-xs-12 col-md-5 p-t-3">
                                        Project Number
                                    </div>
                                    <div class="col-xs-12 col-md-7 p-t-3">
                                        : <b>{{ project.number }}</b>
                                    </div>
                                    <div class="col-xs-12 col-md-5 p-t-3">
                                        Recent Project Progress
                                    </div>
                                    <div class="col-xs-12 col-md-7 p-t-3">
                                        : <b>{{ project.progress }}%</b>
                                    </div>
                                    <div class="col-xs-12 col-md-5 p-t-3">
                                        Sales Order
                                    </div>
                                    <div class="col-xs-12 col-md-7 p-t-3">
                                        : <b>{{ project.sales_order.number }}</b>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="col-xs-12 col-md-4 p-t-3">
                                        Customer Name
                                    </div>
                                    <div class="col-xs-12 col-md-8 p-t-3">
                                        : <b>{{ project.customer.name }}</b>
                                    </div>
                                    <div class="col-xs-12 col-md-4 p-t-3">
                                        Ship Type
                                    </div>
                                    <div class="col-xs-12 col-md-8 p-t-3">
                                        : <b>{{ project.ship.type }}</b>
                                    </div>
                                    <div class="col-xs-12 col-md-4 p-t-3">
                                        Total Price
                                    </div>
                                    <div class="col-xs-12 col-md-8 p-t-3">
                                        : <b> Rp.{{ project.sales_order.total_price }}</b>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 p-t-10 p-l-0 p-r-0">
                                <table class="table table-bordered tableFixed m-b-0">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="25%">Project Progress</th>
                                            <th width="25%">Payment Percentage</th>
                                            <th width="25%">Payment Value</th>
                                            <th width="20%"></th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="(top, index) in dataTop">
                                        <tr>
                                            <td>{{ index+1 }}</td>
                                            <td>{{ top.project_progress }} %</td>
                                            <td>{{ top.payment_percentage }} %</td>
                                            <td>Rp.{{ paymentValue(index) }}</td>
                                            <template v-if="check(index) == true">
                                                <td class="p-l-0" align="center"><a @click.prevent="confirmation(top,index)" class="btn btn-primary btn-xs" href="#" :disabled="checkProgress(index)">
                                                    <div class="btn-group">
                                                        CREATE INVOICE
                                                    </div></a>
                                                </td>
                                            </template>
                                            <template v-else>
                                                <td class="p-l-0" align="center"><a @click.prevent="viewInvoice(index)" class="btn btn-primary btn-xs" target="_blank">
                                                    <div class="btn-group">
                                                        VIEW INVOICE
                                                    </div></a>
                                                </td>
                                            </template>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endverbatim
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const form = document.querySelector('form#invoice');

    $(document).ready(function(){
        $('div.overlay').hide();
    })

    var data = {
        project : [],
        submittedForm : {},
        dataTop : [],
        invoices : @json($invoices),
        route : @json($route)
    }

    var vm = new Vue({
        el : '#invoice',
        data : data,
        methods: {
            viewInvoice(index){
                var id = null;
                this.invoices.forEach(invoice =>{
                    if(invoice.top_index == index){
                        id = invoice.id;
                    }
                })
                if(this.route == "/invoice"){
                    window.open("/invoice/"+id , '_blank');
                }else if(this.route == "/invoice_repair"){
                    window.open("/invoice_repair/"+id , '_blank');
                }
            },
            check(index){
                var result = true;
                this.invoices.forEach(invoice =>{
                    if(invoice.top_index == index){
                        result = false;
                    }
                })
                return result;
            },
            confirmation(top,index){
                var menuTemp = this.menu;
                iziToast.question({
                    close: false,
                    overlay: true,
                    timeout : 0,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirm',
                    message: 'Are you sure you want to create this invoice?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            vm.createInvoice(top,index);

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }],
                    ],
                });
            },
            createInvoice(top,index){
                $('div.overlay').show();
                document.body.appendChild(form);

                var top = JSON.stringify(top);
                top = JSON.parse(top);

                this.submittedForm.total_price = parseInt((this.project.sales_order.total_price+"").replace(/,/g , ''));
                this.submittedForm.top_index = index;
                this.submittedForm.project_id = this.project.id;
                this.submittedForm.current_progress = this.project.progress;
                this.submittedForm.sales_order_id = this.project.sales_order_id;
                this.submittedForm.top = top;
                
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            paymentValue(index){
                var result = (this.dataTop[index].payment_percentage / 100) * (this.project.sales_order.total_price+"").replace(/,/g , '');
                result = (result+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                return result;  
            },
            checkProgress(index){
                var result = false;

                if(this.dataTop[index].project_progress > this.project.progress){
                    result = true;
                }

                return result;  
            }
        },
        watch: {
            
        },
        created : function(){
            this.project = @json($project);
            this.project.sales_order.total_price = (this.project.sales_order.total_price+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            this.dataTop = @json(json_decode($project->salesOrder->terms_of_payment))
        }
    });

</script>
@endpush