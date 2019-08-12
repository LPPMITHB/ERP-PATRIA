@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage Currencies',
            'items' => [
                'Dashboard' => route('index'),
                'Manage Currencies' => '',
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
                <form id="add-currency" class="form-horizontal" method="POST" action="{{ route('currencies.add') }}">
                @csrf
                    @verbatim
                    <div id="currencies">
                        <div class="box-body">
                            <div class="col-md-12 p-l-0 p-r-0">
                                <div class="box-group" id="accordion">
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title pull-right">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#new_currency">
                                                    ADD NEW CURRENCY
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="new_currency" class="panel-collapse collapse">
                                            <div class="box-body">
                                                <div class="col-sm-3">
                                                    <label for="name">Currency Name</label>
                                                    <input v-model="input.name" type="text" class="form-control" placeholder="Please insert currency name">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="unit">Currency Unit</label>
                                                    <input v-model="input.unit" type="text" class="form-control" placeholder="Please insert currency unit">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="value">Currency Value</label>
                                                    <input v-model="input.value" type="text" class="form-control" placeholder="Please insert currency value">
                                                </div>
                                                <div class="col-sm-3">
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
                                                <a data-toggle="collapse" data-parent="#accordion" href="#current_currency">
                                                    MANAGE CURRENT CURRENCY
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="current_currency" class="panel-collapse collapse in">
                                            <div class="box-body">
                                                <table class="table table-bordered tableFixed">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th width="30%">Currency Name</th>
                                                            <th width="30%">Currency Unit</th>
                                                            <th width="25%">Currency Value</th>
                                                            <th width="25%">Status</th>
                                                            <th width="10%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(currency,index) in currencies"> 
                                                            <td>{{ index+1 }}</td>
                                                            <td class="no-padding"><input v-model="currency.name" type="text" class="form-control"></td>
                                                            <td class="no-padding"><input v-model="currency.unit" type="text" class="form-control"></td>
                                                            <td class="no-padding"><input v-model="currency.value" type="text" class="form-control"></td>
                                                            <td class="no-padding">
                                                                <select v-model="currency.status" class="form-control">
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
    const form = document.querySelector('form#add-currency');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        currencies : @json($currencies),
        input:{
            name : "",
            unit : "",
            value : "",
            status : 1,
            id : "",
        },
        max_id : 1,
    }

    var vm = new Vue({
        el : '#currencies',
        data : data,
        methods: {
            clearData(){
                this.input.name = "";
                this.input.unit = "";
                this.input.value = "";
                this.input.status = 1;
            },
            getNewId(){
                this.currencies.forEach(currency => {
                    if(currency.id > this.max_id){
                        this.max_id = currency.id;
                    }
                });
            },
            add(){
                $('div.overlay').show();
                this.input.id = this.max_id + 1;
                var input = JSON.stringify(this.input);
                input = JSON.parse(input);

                this.currencies.push(input);
                this.currencies.forEach(currency => {
                    currency.value = parseInt((currency.value+"").replace(/,/g , ''));
                });

                var currencies = this.currencies;
                currencies = JSON.stringify(currencies);
                var url = "{{ route('currencies.add') }}";

                window.axios.put(url,currencies).then((response) => {
                    iziToast.success({
                        title: 'Success Save Currencies',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    this.clearData();
                    this.getNewId();
                    $('#new_currency').collapse("hide");
                    $('#current_currency').collapse("show");
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
                this.currencies.forEach(currency => {
                    currency.value = parseInt((currency.value+"").replace(/,/g , ''));
                });

                var currencies = this.currencies;
                currencies = JSON.stringify(currencies);
                var url = "{{ route('currencies.add') }}";

                window.axios.put(url,currencies).then((response) => {
                    iziToast.success({
                        title: 'Success Save Currencies',
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
            'input.value': function(newValue){
                this.input.value = (newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            currencies:{
                handler: function(newValue) {
                    newValue.forEach(currency => {
                        currency.value = (currency.value+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    });
                },
                deep: true
            },
        },
        created : function(){
            this.currencies.forEach(currency => {
                if(currency.id > this.max_id){
                    this.max_id = currency.id;
                }
                currency.value = (currency.value+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        }
    });
</script>
@endpush
