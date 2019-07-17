@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage Daily Man Hour',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('daily_man_hour.selectProject'),
                'Manage Delivery Terms' => '',
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
                <form id="add-daily-man-hour" class="form-horizontal" method="POST" action="{{ route('daily_man_hour.store') }}">
                @csrf
                    @verbatim
                    <div id="dailyManHour">
                        <div class="box-body">
                            <div class="col-md-12 p-l-0 p-r-0">
                                <div class="box-group" id="accordion">
                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title pull-right">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#new_daily_man_hour">
                                                    INPUT DAILY MAN HOUR
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="new_daily_man_hour" class="panel-collapse collapse in">
                                            <div class="box-body">
                                                <div class="col-sm-6">
                                                    <label for="input_date">Input Date</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input autocomplete="off" v-model="input.input_date" class="form-control datepicker" type="text" id="input_date" placeholder="Please insert Input Date"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="description">Man Hour</label>
                                                    <input v-model="input.man_hour" type="text" class="form-control" placeholder="Please insert Man Hour">
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
                                                <a data-toggle="collapse" data-parent="#accordion" href="#current_daily_man_hour">
                                                    MANAGE CURRENT DATA
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="current_daily_man_hour" class="panel-collapse collapse">
                                            <div class="box-body">
                                                <div class="col-sm-6 p-l-0">
                                                    <div class="box-tools pull-left">
                                                        <span id="date-label-from" class="date-label">From: </span><input class="date_range_filter datepicker" type="text" id="datepicker_from" />
                                                        <span id="date-label-to" class="date-label">To: </span><input class="date_range_filter datepicker" type="text" id="datepicker_to" />
                                                        <button type="button" id="btn-reset" class="btn btn-primary btn-sm">RESET</button>
                                                    </div>
                                                </div> 
                                                <table id="dmh-table" class="table table-bordered tableFixed">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th width="30%">Input Date</th>
                                                            <th width="30%">Man Hour</th>
                                                            <th width="10%" ></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(daily_man_hour,index) in dailyManHour"> 
                                                            <td>{{ index+1 }}</td>
                                                            <td>
                                                                {{daily_man_hour.input_date}}
                                                            </td>
                                                            <td>
                                                                {{daily_man_hour.man_hour}}
                                                            </td>
                                                            <td class="p-l-0 p-r-0 p-b-0 textCenter" align="center">
                                                                <div class="col-sm-12 p-l-5 p-r-0 p-b-0">
                                                                    <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                                                        <a @click.prevent="openEditModal(daily_man_hour)" class="btn btn-primary btn-xs col-xs-12" data-toggle="modal" href="#edit_data">
                                                                            EDIT
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-sm-6 col-xs-12 no-padding p-r-5 p-b-5">
                                                                        <a class="btn btn-danger btn-xs col-xs-12" @click.prevent="deleteData(daily_man_hour)" data-toggle="modal">
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
                                            <div class="col-sm-6">
                                                <label for="edit_input_date" class="control-label">Input Date</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input v-model="edit_data.input_date" class="form-control datepicker" type="text" id="edit_input_date" placeholder="Please insert Input Date"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="edit_man_hour" class="control-label">Man Hour</label>
                                                <input id="edit_man_hour" v-model="edit_data.man_hour" type="text" class="form-control" placeholder="Please insert Man Hour">
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
    const form = document.querySelector('form#add-daily-man-hour');

    $(document).ready(function(){
        $('#dmh-table').DataTable({
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
        dailyManHour : [],
        input:{
            input_date : "",
            man_hour : "",
            project_id : @json($project_id),
        },
        edit_data:{
            id : "",
            input_date : "",
            man_hour : "",
            project_id : @json($project_id),
        },
    }

    var vm = new Vue({
        el : '#dailyManHour',
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
                    || this.input.man_hour == "")
                    {
                        isOk = true;
                    }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;
                if(this.edit_data.input_date == ""
                || this.edit_data.man_hour == "")
                    {
                        isOk = true;
                    }
                return isOk;
            },
        },
        methods: {
            getData(){
                window.axios.get('/api/getDailyManHour/'+this.input.project_id).then(({ data }) => {
                    $('div.overlay').show();
                    this.dailyManHour = data;
                    this.dailyManHour.forEach(data => {
                        var temp_date = data.input_date.split('-');
                        data.input_date = temp_date[2]+"-"+temp_date[1]+"-"+temp_date[0];
                        data.man_hour = (data.man_hour+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    });
                    $('#dmh-table').DataTable().destroy();
                    this.$nextTick(function() {
                        var dmh_table = $('#dmh-table').DataTable({
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
                            dmh_table.draw();
                        }).change(function() {
                            var temp = this.value.split("-");
                            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
                            dmh_table.draw();
                        });

                        $("#datepicker_to").datepicker({
                            autoclose : true,
                            format : "dd-mm-yyyy"
                        }).keyup(function() {
                            var temp = this.value.split("-");
                            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
                            dmh_table.draw();
                        }).change(function() {
                            var temp = this.value.split("-");
                            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
                            dmh_table.draw();
                        });

                        document.getElementById("btn-reset").addEventListener("click", reset);

                        function reset() {
                            $("#datepicker_from").val('');
                            $("#datepicker_to").val('');
                            maxDateFilter = "";
                            minDateFilter = "";
                            dmh_table.draw();
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
                this.edit_data.man_hour = data.man_hour;
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
                            var url = "/daily_man_hour/delete/"+data.id;
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
                this.input.man_hour = "";
            },
            add(){
                $('div.overlay').show();
                var input = JSON.stringify(this.input);
                input = JSON.parse(input);
                input.man_hour = input.man_hour.replace(/,/g , '');  
                var url = "{{ route('daily_man_hour.store') }}";

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
                            title: 'Success to Save Daily Man Hour Data',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        this.getData();
                    }
                    
                    this.clearData();
                    $('#current_daily_man_hour').collapse("show");
                    $('#new_daily_man_hour').collapse("hide");
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
                $('div.overlay').show();
                var edit_data = JSON.stringify(this.edit_data);
                edit_data = JSON.parse(edit_data);
                edit_data.man_hour = edit_data.man_hour.replace(/,/g , '');  
                var url = "{{ route('daily_man_hour.update') }}";

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
                            title: 'Success to Update Daily Man Hour Data',
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
            'input.man_hour': function(newValue){
                if(newValue != ""){
                    this.input.man_hour = ((newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                }
            },
            'edit_data.man_hour': function(newValue){
                if(newValue != ""){
                    this.edit_data.man_hour = ((newValue+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                }
            },
            dailyManHour:{
            handler: function(newValue) {
                newValue.forEach(data => {
                    data.man_hour = (data.man_hour+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
            },
            deep: true
        },
        },
        created : function(){
            this.getData();
        }
    });
</script>
@endpush
