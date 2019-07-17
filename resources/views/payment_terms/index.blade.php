@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage Payment Terms',
            'items' => [
                'Dashboard' => route('index'),
                'Manage Payment Terms' => '',
            ]
        ]
    )
    @endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <form id="add-payment-term" class="form-horizontal" method="POST" action="{{ route('payment_terms.add') }}">
                @csrf
                    @verbatim
                    <div id="payment_terms">
                        <div class="box-body">
                            <div class="col-md-12 p-l-0 p-r-0">
                                <div class="box-group" id="accordion">
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title pull-right">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#new_payment_term">
                                                    ADD NEW PAYMENT TERM
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="new_payment_term" class="panel-collapse collapse">
                                            <div class="box-body">
                                                <div class="col-sm-4">
                                                    <label for="name">Payment Term Name</label>
                                                    <input v-model="input.name" type="text" class="form-control" placeholder="Please insert Payment Term name">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="description">Payment Term Description</label>
                                                    <input v-model="input.description" type="text" class="form-control" placeholder="Please insert Payment Term description">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="value">Status</label>
                                                    <select v-model="input.status" class="form-control">
                                                        <option value="0">Non Active</option>
                                                        <option value="1">Active</option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-12 p-t-10">
                                                    <button type="submit" class="btn btn-primary pull-right" @click.prevent="add()">CREATE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title pull-right">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#current_payment_term">
                                                    MANAGE CURRENT PAYMENT TERMS
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="current_payment_term" class="panel-collapse collapse in">
                                            <div class="box-body">
                                                <table class="table table-bordered tableFixed">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th width="30%">Payment Term Name</th>
                                                            <th width="30%">Payment Term Description</th>
                                                            <th width="10%">Status</th>
                                                            <th width="10%" ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(payment_term,index) in payment_terms"> 
                                                            <td>{{ index+1 }}</td>
                                                            <td class="no-padding"><input v-model="payment_term.name" type="text" class="form-control"></td>
                                                            <td class="no-padding"><input v-model="payment_term.description" type="text" class="form-control"></td>
                                                            <td class="no-padding">
                                                                <select v-model="payment_term.status" class="form-control">
                                                                    <option value="0">Non Active</option>
                                                                    <option value="1">Active</option>
                                                                </select>
                                                            </td>
                                                            <td class="p-l-0" align="center">
                                                                <a @click.prevent="save()" class="btn btn-primary btn-xs" href="#">
                                                                    <div class="btn-group">
                                                                        SAVE
                                                                    </div>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    const form = document.querySelector('form#add-payment-term');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        payment_terms : @json($payment_terms),
        input:{
            name : "",
            unit : "",
            value : "",
            status : 1,
        },
        max_id : 1,
    }

    var vm = new Vue({
        el : '#payment_terms',
        data : data,
        methods: {
            clearData(){
                this.input.name = "";
                this.input.description = "";
                this.input.status = 1;
            },
            add(){
                $('div.overlay').show();
                this.input.id = this.max_id + 1;
                var input = JSON.stringify(this.input);
                input = JSON.parse(input);

                this.payment_terms.push(input);
                var payment_terms = this.payment_terms;
                payment_terms = JSON.stringify(payment_terms);
                var url = "{{ route('payment_terms.add') }}";

                window.axios.put(url,payment_terms).then((response) => {
                    iziToast.success({
                        title: 'Success Save Payment Terms',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    this.clearData();
                    $('#current_payment_term').collapse("show");
                    $('#new_payment_term').collapse("hide");
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    console.log(error);
                })
                $('div.overlay').hide();
            },
            save(){
                $('div.overlay').show();
                var payment_terms = this.payment_terms;
                payment_terms = JSON.stringify(payment_terms);
                var url = "{{ route('payment_terms.add') }}";

                window.axios.put(url,payment_terms).then((response) => {
                    iziToast.success({
                        title: 'Success Save Payment Terms',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    console.log(error);
                })
                $('div.overlay').hide();
            }
        },
        watch: {
            
        },
        created : function(){
            var modelPaymentTerms = this.payment_terms;
            modelPaymentTerms.forEach(data => {
                if(data.id > this.max_id){
                    this.max_id = data.id;
                }
            });
        }
    });
</script>
@endpush
