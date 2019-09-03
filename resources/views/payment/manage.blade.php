@extends('layouts.main')
@section('content-header')
@if($menu == "view_payment")
    @breadcrumb(
        [
            'title' => 'View Payment Receipt',
            'items' => [
                'Dashboard' => route('index'),
                'Manage Payment Receipt' => '',
            ]
        ]
    )@endbreadcrumb
@elseif($menu == "manage_payment")
    @breadcrumb(
        [
            'title' => 'Manage Payment Receipt',
            'items' => [
                'Dashboard' => route('index'),
                'Manage Payment Receipt' => '',
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
                @if($route == "/payment")
                    <form id="payment" class="form-horizontal" method="POST" action="{{ route('payment.store') }}">
                @elseif($route == "/payment_repair")
                    <form id="payment" class="form-horizontal" method="POST" action="{{ route('payment_repair.store') }}">
                @endif
                @csrf
                    <div class="box-body">
                        @verbatim
                        <div id="payment">
                            <div class="box-header no-padding">
                                <div class="col-sm-5 no-padding ">
                                    <div class="col-xs-12 col-md-5 p-t-3 p-l-0">
                                        Invoice Number
                                    </div>
                                    <div class="col-xs-12 col-md-7 p-t-3">
                                        : <b>{{ invoice.number }}</b>
                                    </div>
                                    <div class="col-xs-12 col-md-5 p-t-3 p-l-0">
                                        SO Number
                                    </div>
                                    <div class="col-xs-12 col-md-7 p-t-3">
                                        : <b>{{ invoice.sales_order.number }}</b>
                                    </div>
                                    <div class="col-xs-12 col-md-5 p-t-3 p-l-0">
                                        Project Number
                                    </div>
                                    <div class="col-xs-12 col-md-7 p-t-3">
                                        : <b>{{ invoice.project.number }}</b>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="col-xs-12 col-md-4 p-t-3">
                                        Ship
                                    </div>
                                    <div class="col-xs-12 col-md-8 p-t-3">
                                        : <b>{{ invoice.project.ship.type }}</b>
                                    </div>
                                    <div class="col-xs-12 col-md-4 p-t-3">
                                        Customer
                                    </div>
                                    <div class="col-xs-12 col-md-8 p-t-3">
                                        : <b>{{ invoice.project.customer.name }}</b>
                                    </div>
                                    <div class="col-xs-12 col-md-4 p-t-3">
                                        Status
                                    </div>
                                    <div class="col-xs-12 col-md-8 p-t-3">
                                        <template v-if="invoice.status == 1">
                                            : <b>BILLED</b>
                                        </template>
                                        <template v-else-if="invoice.status == 2">
                                            : <b>CANCELED</b>
                                        </template>
                                        <template v-else-if="invoice.status == 3">
                                            : <b>SEPARATELY PAID</b>
                                        </template>
                                        <template v-else-if="invoice.status == 0">
                                            : <b>PAID</b>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <template v-if="menu == 'manage_payment'">
                                <div class="col-md-12 panel panel-default m-t-10 p-t-10 p-b-10 m-b-0">
                                    <div class="col-md-4 p-l-0">
                                        <div class="col-sm-12">
                                            <label for=""><b>Billed (Rp.)</b></label>
                                        </div>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" v-model="invoice.payment_value" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-sm-12">
                                            <label for=""><b>Paid (Rp.)</b></label>
                                        </div>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" v-model="dataInput.paid" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-sm-12">
                                            <label for=""><b>Amount Receive (Rp.)</b></label>
                                        </div>
                                        <div class="col-sm-12 p-r-0">
                                            <input type="text" class="form-control" v-model="dataInput.amount" placeholder="Please Input Amount Receive">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 p-t-20">
                                        <button @click.prevent="confirmation" :disabled="createOk" class="btn btn-primary btn-sm pull-right" id="btnSubmit">SAVE</button>
                                    </div>
                                </div>
                            </template>

                            <div class="col-md-12 p-l-0">
                                <h4><b>History</b></h4>
                                <table class="table table-bordered tableFixed m-b-0 showTable">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="25%">Amount</th>
                                            <th width="25%">Payment Date</th>
                                            <th width="25%">Input By</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="(payment, index) in payments">
                                        <tr>
                                            <td>{{ index+1 }}</td>
                                            <td>Rp.{{ payment.amount }}</td>
                                            <td>{{ payment.created_at }}</td>
                                            <td>{{ payment.user.name }}</td>
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
    const form = document.querySelector('form#payment');

    $(document).ready(function(){
        $('div.overlay').hide();
    })

    var data = {
        menu : @json($menu),
        invoice : [],
        payments : [],
        submittedForm : {},
        dataInput : {
            paid : "",
            amount : "",
        }
    }

    var vm = new Vue({
        el : '#payment',
        data : data,
        computed: {
            createOk(){
                let isOk = false;
                
                if(this.dataInput.amount == ""){
                    isOk = true;
                }

                return isOk;
            }
        },
        methods: {
            checkStatus(){
                if(this.invoice.status == 0){
                    this.menu = "view_payment";
                }
            },
            getInvoice(){
                $('div.overlay').show();
                window.axios.get('/api/getInvoicesPReceipt/'+this.invoice.id).then(({ data }) => {
                    this.invoice = data;
                    this.invoice.payment_value = (this.invoice.payment_value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    this.getPayment();
                    this.checkStatus();
                });
            },
            getPayment(){
                window.axios.get('/api/getPaymentsPReceipt/'+this.invoice.id).then(({ data }) => {
                    this.payments = data;
            
                    var billed = this.invoice.payment_value;
                    var paid = 0;

                    this.payments.forEach(data =>{
                        data.amount = (data.amount+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        paid += parseInt((data.amount+"").replace(/,/g , ''));
                        var date = new Date(data.created_at); 
                        data.created_at = date.toLocaleString("en-GB")
                    })

                    this.dataInput.paid = (paid+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    $('div.overlay').hide();
                });
            },
            confirmation(){
                var menuTemp = this.menu;
                iziToast.question({
                    close: false,
                    overlay: true,
                    timeout : 0,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirm',
                    message: 'Are you sure you want to add new payment receipt?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            vm.add();

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }],
                    ],
                });
            },
            add(){
                $('div.overlay').show();
                var amount = (this.dataInput.amount+"").replace(/,/g , '');

                this.submittedForm.amount = amount;
                this.submittedForm.invoice_id = this.invoice.id;

                var data = JSON.stringify(this.submittedForm);
                var url = "{{ route('payment.store') }}";
                window.axios.post(url,data).then((response) => {
                    iziToast.success({
                        title: 'Success Add New Payment Receipt!',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    this.dataInput.amount = "";
                    this.getInvoice();
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    console.log(error);
                    $('div.overlay').hide();
                })
            }
        },
        watch: {
            'dataInput.amount' : function(newValue){
                this.dataInput.amount = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                var remaining = (this.invoice.payment_value+"").replace(/,/g , '') - (this.dataInput.paid+"").replace(/,/g , '');

                if((this.dataInput.amount+"").replace(/,/g , '') > remaining){
                    this.dataInput.amount = (remaining+"").replace(/,/g , '');
                    iziToast.warning({
                        displayMode: 'replace',
                        title: "Cannot input amount receive greater than Rp."+(remaining+"").replace(/\B(?=(\d{3})+(?!\d))/g, ","),
                        position: 'topRight',
                    });
                }
            },
        },
        created : function(){
            this.invoice = @json($invoice);
            this.invoice.payment_value = (this.invoice.payment_value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            this.payments = @json($payment);
            
            var billed = this.invoice.payment_value;
            var paid = 0;

            this.payments.forEach(data =>{
                data.amount = (data.amount+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                paid += parseInt((data.amount+"").replace(/,/g , ''));
                var date = new Date(data.created_at); 
                data.created_at = date.toLocaleString("en-GB")
            })

            this.dataInput.paid = (paid+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    });

</script>
@endpush