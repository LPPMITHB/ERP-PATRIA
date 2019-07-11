@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage Density',
            'items' => [
                'Dashboard' => route('index'),
                'Manage Density' => '',
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
                <form id="add-currency" class="form-horizontal" method="POST" action="{{ route('density.add') }}">
                @csrf
                    @verbatim
                    <div id="density">
                        <div class="box-body">
                            <div class="col-md-12 p-l-0 p-r-0">
                                <div class="box-group" id="accordion">
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title pull-right">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#new_density">
                                                    ADD NEW DENSITY
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="new_density" class="panel-collapse collapse">
                                            <div class="box-body">
                                                <div class="col-sm-4">
                                                    <input v-model="input.id" type="hidden" class="form-control">
                                                    <label for="name">Density Name</label>
                                                    <input v-model="input.name" type="text" class="form-control" placeholder="Please insert density name">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="value">Density Value</label>
                                                    <input v-model="input.value" type="text" class="form-control" placeholder="Please insert density value">
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
                                                <a data-toggle="collapse" data-parent="#accordion" href="#current_density">
                                                    MANAGE CURRENT DENSITY
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="current_density" class="panel-collapse collapse in">
                                            <div class="box-body">
                                                <table class="table table-bordered tableFixed">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th width="40%">Density Name</th>
                                                            <th width="40%">Density Value</th>
                                                            <th width="10%">Status</th>
                                                            <th width="10%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(data,index) in density"> 
                                                            <td>{{ index+1 }}</td>
                                                            <td class="no-padding"><input v-model="data.name" type="text" class="form-control"></td>
                                                            <td class="no-padding"><input v-model="data.value" type="text" class="form-control"></td>
                                                            <td class="no-padding">
                                                                <select v-model="data.status" class="form-control">
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
        density : @json($density),
        input:{
            id : @json($id),
            name : "",
            value: "",
            status : 1,
        },
        max_id : 1,
    }

    var vm = new Vue({
        el : '#density',
        data : data,
        methods: {
            clearData(){
                this.input.id = "";
                this.input.name = "";
                this.input.value = "";
                this.input.status = 1;
            },
            add(){
                $('div.overlay').show();
                this.input.id = this.max_id + 1;
                var input = JSON.stringify(this.input);
                input = JSON.parse(input);

                this.density.push(input);

                var density = this.density;
                density = JSON.stringify(density);
                var url = "{{ route('density.add') }}";

                window.axios.put(url,density).then((response) => {
                    iziToast.success({
                        title: 'Success Save Density',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    this.clearData();
                    $('#current_density').collapse("show");
                    $('#new_density').collapse("hide");
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
                var density = this.density;
                density = JSON.stringify(density);
                var url = "{{ route('density.add') }}";

                window.axios.put(url,density).then((response) => {
                    iziToast.success({
                        title: 'Success Save Density',
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
        watch:{
            density:{
                handler: function(newValue){
                    var dataDensity = newValue;
                    dataDensity.forEach(data => {
                        var decimal = (data.value+"").replace(/,/g, '').split('.');
                        if(decimal[1] != undefined){
                            var maxDecimal = 2;
                            if((decimal[1]+"").length > maxDecimal){
                                data.value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                            }else{
                                data.value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                            }
                        }else{
                            data.value = (data.value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    });
                },
                deep: true
            },
            'input.value': function(newValue) {
                var decimal = newValue.replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.input.value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.input.value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.input.value = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
        },
        created:function(){
            var modelDensity = this.density;
            modelDensity.forEach(data => {
                if(data.id > this.max_id){
                    this.max_id = data.id;
                }
                var decimal = (data.value+"").replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        data.value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        data.value = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    data.value = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

            });
        }
    });
</script>
@endpush
