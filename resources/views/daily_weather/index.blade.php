@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage Daily Weather',
            'items' => [
                'Dashboard' => route('index'),
                'Manage Daily Weather' => '',
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
                <form id="add-daily-weather" class="form-horizontal" method="POST" action="{{ route('daily_weather.store') }}">
                @csrf
                    @verbatim
                    <div id="dailyWeather">
                        <div class="box-body">
                            <div class="col-md-12 p-l-0 p-r-0">
                                <div class="box-group" id="accordion">
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title pull-right">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#new_daily_weather">
                                                    INPUT DAILY WEATHER
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="new_daily_weather" class="panel-collapse collapse in">
                                            <div class="box-body">
                                                <div class="col-sm-4">
                                                    <label for="input_date">Input Date</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input autocomplete="off" v-model="input.input_date" class="form-control datepicker" type="text" id="input_date" placeholder="Please insert Input Date"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="weather_config">Weather Category</label>
                                                    <selectize id="weather_config" v-model="input.weather_configuration_id" :settings="weatherConfigSettings">
                                                        <option v-for="(weather_config, index) in weather_configs" :value="weather_config.id">{{ weather_config.name }}</option>
                                                    </selectize>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="description">Weather Description</label>
                                                    <input id="description" v-model="input.description" type="text" class="form-control" placeholder="Please insert Weather Description">
                                                </div>
                                                <div class="col-xs-12 p-t-10">
                                                    <button :disabled="createOk" type="submit" class="btn btn-primary pull-right" @click.prevent="add()">CREATE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title pull-right">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#current_daily_weather">
                                                    MANAGE CURRENT DATA
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="current_daily_weather" class="panel-collapse collapse">
                                            <div class="box-body">
                                                <div class="col-sm-6 p-l-0">
                                                    <div class="box-tools pull-left">
                                                        <span id="date-label-from" class="date-label">From: </span><input class="date_range_filter datepicker" type="text" id="datepicker_from" />
                                                        <span id="date-label-to" class="date-label">To: </span><input class="date_range_filter datepicker" type="text" id="datepicker_to" />
                                                        <button type="button" id="btn-reset" class="btn btn-primary btn-sm">RESET</button>
                                                    </div>
                                                </div> 
                                                <table id="dw-table" class="table table-bordered tableFixed">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th width="30%">Input Date</th>
                                                            <th width="30%">Weather Category</th>
                                                            <th width="30%">Weather Description</th>
                                                            <th width="15%" ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(daily_weather,index) in dailyWeather"> 
                                                            <td>{{ index+1 }}</td>
                                                            <td>
                                                                {{daily_weather.input_date}}
                                                            </td>
                                                            <td>
                                                                {{daily_weather.weather_configuration_name}}
                                                            </td>
                                                            <td>
                                                                {{daily_weather.description}}
                                                            </td>
                                                            <td class="p-l-0 p-r-0 p-b-0 textCenter" align="center">
                                                                <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                                                    <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                                                        <a @click.prevent="openEditModal(daily_weather)" class="btn btn-primary btn-xs col-xs-12" data-toggle="modal" href="#edit_data">
                                                                            EDIT
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                                                        <a class="btn btn-danger btn-xs col-xs-12" @click.prevent="deleteData(daily_weather)" data-toggle="modal">
                                                                            DELETE
                                                                        </a>
                                                                    </div>
                                                                </div>
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
                        <div class="modal fade" id="edit_data">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Edit Data</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="edit_input_date" class="control-label">Input Date</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input v-model="edit_data.input_date" class="form-control datepicker" type="text" id="edit_input_date" placeholder="Please insert Input Date"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="edit_weather_config" class="control-label">Weather Category</label>
                                                <selectize id="edit_weather_config" v-model="edit_data.weather_configuration_id" :settings="weatherConfigSettings">
                                                    <option v-for="(weather_config, index) in weather_configs" :value="weather_config.id">{{ weather_config.name }}</option>
                                                </selectize>                                            
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="edit_weather" class="control-label">Weather Description</label>
                                                <input id="edit_weather" v-model="edit_data.description" type="text" class="form-control" placeholder="Please insert Weather Description">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update">SAVE</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
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
    const form = document.querySelector('form#add-daily-weather');

    $(document).ready(function(){
        $('#dw-table').DataTable({
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
    });

    var data = {
        dailyWeather : [],
        weather_configs : @json($weather_config),
        input:{
            input_date : "",
            weather_configuration_id : "",
            weather_configuration_name : "",
            description : "",
        },
        edit_data:{
            id : "",
            input_date : "",
            description : "",
        },
        weatherConfigSettings: {
            placeholder: 'Weather Configuration',
        },
    }

    var vm = new Vue({
        el : '#dailyWeather',
        data : data,
        mounted(){
            $('.datepicker').datepicker({
                autoclose : true,
                format : "dd-mm-yyyy"
            });
            $("#input_date").datepicker().on(
                "changeDate", () => {
                    this.input.input_date = $('#input_date').val();
                }
            );
        },
        computed: {
            createOk: function(){
                let isOk = false;
                    if(this.input.input_date == ""
                    || this.input.weather_configuration_id == "")
                    {
                        isOk = true;
                    }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;
                if(this.edit_data.input_date == ""
                || this.edit_data.weather_configuration_id == "")
                    {
                        isOk = true;
                    }
                return isOk;
            },
        },
        methods: {
            getData(){
                window.axios.get('/api/getDailyWeather').then(({ data }) => {
                    $('div.overlay').show();
                    this.dailyWeather = data;
                    this.dailyWeather.forEach(data => {
                        var temp_date = data.input_date.split('-');
                        data.input_date = temp_date[2]+"-"+temp_date[1]+"-"+temp_date[0];
                        data.weather = (data.weather+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                        this.weather_configs.forEach(data_config => {
                            if(data_config.id == data.weather_configuration_id ){
                                data.weather_configuration_name = data_config.name; 
                            }
                        });
                    });
                    $('#dw-table').DataTable().destroy();
                    this.$nextTick(function() {
                        var dw_table = $('#dw-table').DataTable({
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

                        $("#datepicker_from").datepicker({
                            autoclose : true,
                            format : "dd-mm-yyyy"
                        }).keyup(function() {
                            var temp = this.value.split("-");
                            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
                            dw_table.draw();
                        }).change(function() {
                            var temp = this.value.split("-");
                            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
                            dw_table.draw();
                        });

                        $("#datepicker_to").datepicker({
                            autoclose : true,
                            format : "dd-mm-yyyy"
                        }).keyup(function() {
                            var temp = this.value.split("-");
                            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
                            dw_table.draw();
                        }).change(function() {
                            var temp = this.value.split("-");
                            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
                            dw_table.draw();
                        });

                        document.getElementById("btn-reset").addEventListener("click", reset);

                        function reset() {
                            $("#datepicker_from").val('');
                            $("#datepicker_to").val('');
                            maxDateFilter = "";
                            minDateFilter = "";
                            dw_table.draw();
                        }
                        
                        // Date range filter
                        minDateFilter = "";
                        maxDateFilter = "";
                        $.fn.dataTableExt.afnFiltering.push(
                            function(oSettings, aData, iDataIndex) {
                                if (typeof aData._date == 'undefined') {
                                    var temp = aData[1].split("-"); 
                                    aData._date = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
                                }

                                if (minDateFilter && !isNaN(minDateFilter)) {
                                    if (aData._date < minDateFilter) {
                                        return false;
                                    }
                                }

                                if (maxDateFilter && !isNaN(maxDateFilter)) {
                                    if (aData._date > maxDateFilter) {
                                        return false;
                                    }
                                }

                                return true;
                            }
                        );
                    })
                });
            },
            openEditModal(data){
                this.edit_data.id = data.id;
                this.edit_data.input_date = data.input_date;
                this.edit_data.weather_configuration_id = data.weather_configuration_id;
                this.edit_data.description = data.description;
                $('#edit_input_date').datepicker('setDate', new Date(data.input_date.split("-").reverse().join("-")));
            },
            deleteData(data){
                iziToast.question({
                    close: false,
                    overlay: true,
                    timeout : 0,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirm',
                    message: 'Are you sure you want to delete this Data?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            var url = "/daily_weather/delete/"+data.id;
                            $('div.overlay').show();            
                            window.axios.delete(url)
                            .then((response) => {
                                if(response.data.error != undefined){
                                    response.data.error.forEach(error => {
                                        iziToast.warning({
                                            displayMode: 'replace',
                                            title: error,
                                            position: 'topRight',
                                        });
                                    });
                                    $('div.overlay').hide();
                                }else{
                                    iziToast.success({
                                        displayMode: 'replace',
                                        title: response.data.response,
                                        position: 'topRight',
                                    });
                                    vm.getData();
                                }
                            })
                            .catch((error) => {
                                iziToast.warning({
                                    displayMode: 'replace',
                                    title: "Please try again.. ",
                                    position: 'topRight',
                                });
                                console.log(error);
                                $('div.overlay').hide();            
                            })

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                
                        }],
                    ],
                });
            },
            clearData(){
                this.input.input_date = "";
                this.input.description = "";
                this.input.weather_configuration_id = "";
                this.input.weather_configuration_name = "";
            },
            add(){
                var input = JSON.stringify(this.input);
                input = JSON.parse(input);
                var url = "{{ route('daily_weather.store') }}";

                window.axios.put(url,input).then((response) => {
                    if(response.data.error != undefined){
                        iziToast.warning({
                            displayMode: 'replace',
                            title: response.data.error,
                            position: 'topRight',
                        });
                        $('div.overlay').hide();            
                    }else{
                        iziToast.success({
                            title: 'Success to Save Daily Weather Data',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        this.getData();
                    }
                    
                    this.clearData();
                    $('#current_daily_weather').collapse("show");
                    $('#new_daily_weather').collapse("hide");
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
            update(){
                var edit_data = JSON.stringify(this.edit_data);
                edit_data = JSON.parse(edit_data);
                var url = "{{ route('daily_weather.update') }}";

                window.axios.put(url,edit_data).then((response) => {
                    if(response.data.error != undefined){
                        iziToast.warning({
                            displayMode: 'replace',
                            title: response.data.error,
                            position: 'topRight',
                        });
                        $('div.overlay').hide();            
                    }else{
                        iziToast.success({
                            title: 'Success to Update Daily Weather Data',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        this.getData();
                    }
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
            'input.weather': function(newValue){
                if(newValue != ""){
                    this.input.weather = ((newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                }
            },
            'edit_data.weather': function(newValue){
                if(newValue != ""){
                    this.edit_data.weather = ((newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                }
            },
            dailyWeather:{
                handler: function(newValue) {
                    newValue.forEach(data => {
                        data.weather = (data.weather+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    });
                },
                deep: true
            },
            'input.weather_configuration_id': function(newValue){
                this.weather_configs.forEach(data => {
                    if(data.id == newValue){
                        this.input.description = data.description;
                    }
                });
            },
            'edit_data.weather_configuration_id': function(newValue){
                this.weather_configs.forEach(data => {
                    if(data.id == newValue){
                        this.edit_data.description = data.description;
                    }
                });
            },
        },
        created : function(){
            this.getData();
        }
    });
</script>
@endpush
