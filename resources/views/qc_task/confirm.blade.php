@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Confirm Quality Control Task',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Confirm Quality Control Task' => '',
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
                    @verbatim
                        <div id="qc_task">
                            <div class="box-header no-padding">
                                <div class="col-xs-12 col-md-4">
                                    <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                                    
                                    <div class="col-md-4 no-padding">Number</div>
                                    <div class="col-md-8 no-padding"><b>: {{wbs.number}}</b></div>
            
                                    <div class="col-md-4 no-padding">Description</div>
                                    <div v-if="wbs.description != ''" class="col-md-8 no-padding"><b>: {{wbs.description}}</b></div>
                                    <div v-else class="col-md-8 no-padding"><b>: -</b></div>
            
                                    <div class="col-md-4 no-padding">Deliverable</div>
                                    <div class="col-md-8 no-padding "><b>: {{wbs.deliverables}}</b></div>

                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <div class="col-sm-12 no-padding"><b>Quality Control Task Information</b></div>
                                
                                    <div class="col-md-4 no-padding">Description</div>
                                    <div v-if="wbs.description != ''" class="col-md-8 no-padding"><b>: {{qc_task_ref.description}}</b></div>
                                    <div v-else class="col-md-8 no-padding"><b>: -</b></div>
                                
                                </div>

                                <div class="col-md-2 col-xs-12 pull-right">
                                    <a v-if="qc_task_ref.status == 1" class="btn btn-sm btn-primary pull-right btn-block" @click="confirmFinish">CONFIRM FINISHED</a>
                                    <a v-else-if="qc_task_ref.status == 0" class="btn btn-sm btn-primary pull-right btn-block" @click="cancelFinish">CANCEL FINISH</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                    <table id="qc_task_detail_table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th style="width: 30%">QC Task Name</th>
                                                <th style="width: 45%">Description</th>
                                                <th style="width: 10%">Status</th>
                                                <th style="width: 10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(data,index) in qc_task_details">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{ data.name }}</td>
                                                <td class="tdEllipsis">{{ data.description }}</td>
                                                <td class="tdEllipsis" v-if="data.status == null">NOT DONE</td>
                                                <td class="tdEllipsis" v-else>{{data.status}}</td>
                                                <td class="p-l-0 textCenter">
                                                    <a v-if="qc_task_ref.status == 1" class="btn btn-primary btn-xs" @click="openConfirmModal(index)">
                                                        CONFIRM
                                                    </a>
                                                    <a v-else-if="qc_task_ref.status == 0" class="btn btn-primary btn-xs" @click="openConfirmModal(index)">
                                                        DETAILS
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="modal fade" id="confirm_qc_task_detail">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title">Confirm Quality Control Task Detail</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="quantity" class="control-label">Name</label>
                                                    <p>{{confirm_qc_task.name}}</p>
                                                </div>

                                                <div class="col-sm-12">
                                                    <label for="quantity" class="control-label">Description</label>
                                                    <p>{{confirm_qc_task.description}}</p>
                                                </div>

                                                <div class="col-sm-12">
                                                    <label for="quantity" class="control-label">Status</label>
                                                    <div v-if="qc_task_ref.status == 1" class="row">
                                                        <div class="col-sm-12">
                                                            <input class="checkbox_icheck" :disabled="finishedOk" type="checkbox" id="OK" value="OK">
                                                            <label class="text-success">OK</label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input class="checkbox_icheck" :disabled="finishedOk" type="checkbox" id="NOT_OK"value="NOT OK">
                                                            <label class="text-danger">NOT OK</label>
                                                        </div>
                                                    </div>
                                                    <div v-else-if="qc_task_ref.status == 0" class="row">
                                                        <div class="col-sm-12">
                                                            <p>
                                                                <b v-if="confirm_qc_task.status == 'OK'" class="text-success">{{confirm_qc_task.status}}</b>
                                                                <b v-else-if="confirm_qc_task.status == 'NOT OK'" class="text-danger">{{confirm_qc_task.status}}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <label for="quantity" class="control-label">Notes</label>
                                                    <textarea class="form-control" rows="5" :disabled="finishedOk" v-model="confirm_qc_task.notes"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" data-dismiss="modal" :disabled="confirmOk"
                                                @click.prevent="updateQcTaskDetail">SAVE</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endverbatim
                    @if($route == '/qc_task')
                        <form id="confirm-finish-qc-task" class="form-horizontal" method="POST" action="{{ route('qc_task.confirmFinish',['id'=>$qcTask->id]) }}">
                            <input type="hidden" name="_method" value="PATCH">
                            @csrf
                        </form>
                        <form id="cancel-finish-qc-task" class="form-horizontal" method="POST" action="{{ route('qc_task.cancelFinish',['id'=>$qcTask->id]) }}">
                            <input type="hidden" name="_method" value="PATCH">
                            @csrf
                        </form>
                    @else
                        {{-- <form id="edit-qc-task" class="form-horizontal" method="POST" action="{{ route('qc_task_repair.store') }}">
                        --}}
                    @endif
                </div>
            </div>
        </div>   
@endsection


@push('script')
<script>
     const formConfirmFinish = document.querySelector('form#confirm-finish-qc-task');
     const formCancelFinish = document.querySelector('form#cancel-finish-qc-task');

    $(document).ready(function() {
        $('div.overlay').hide();
    });

    var data = {
        route : @json($route),
        qc_task_ref : @json($qcTask),
        wbs : @json($qcTask->wbs),
        qc_task_details : [],
        confirm_qc_task :{
            index : "",
            id : "",
            status : "",
            notes : "",
            name : "",
            description : "",
        },

        
    }

    var vm = new Vue({
        el : '#qc_task',
        data : data,
        mounted: function(){
            jQuery('.checkbox_icheck').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            jQuery('.checkbox_icheck').on('ifChecked', function(e){
                var value = $(this).val().split('-')[0];
                var index = $(this).val().split('-')[1];

                if(value == "OK"){
                    $('#NOT_OK').iCheck('uncheck');
                }else if(value == "NOT OK"){
                    $('#OK').iCheck('uncheck');
                }
                vm.confirm_qc_task.status = value;
            });
            jQuery('.checkbox_icheck').on('ifUnchecked', function(e){
                var value = $(this).val().split('-')[0];
                var index = $(this).val().split('-')[1];
                vm.confirm_qc_task.status = null;
            });
        },
        computed : {
            confirmOk: function(){
                let isOk = false;

                if(this.confirm_qc_task.status == "" || this.confirm_qc_task.status == null){
                    isOk = true;
                }

                return isOk;
            },
            finishedOk: function(){
                let isOk = false;
                if(this.qc_task_ref.status == 0){
                    isOk = true;
                }
                return isOk;
            }
        },
        methods : {
            clearData(){
                this.confirm_qc_task.index = "";
                this.confirm_qc_task.id = "";
                this.confirm_qc_task.name = "";
                this.confirm_qc_task.description = "";
                this.confirm_qc_task.status = "";
                this.confirm_qc_task.notes = "";
                $('#NOT_OK').iCheck('uncheck');
                $('#OK').iCheck('uncheck');
            },
            openConfirmModal(index){
                this.clearData();
                var qc_task_detail = this.qc_task_details[index];
                this.confirm_qc_task.index = index;
                this.confirm_qc_task.id = qc_task_detail.id;
                this.confirm_qc_task.name = qc_task_detail.name;
                this.confirm_qc_task.description = qc_task_detail.description;
                this.confirm_qc_task.status = qc_task_detail.status;
                this.confirm_qc_task.notes = qc_task_detail.notes;
                if(qc_task_detail.status == "OK"){
                    $('#OK').iCheck('check');
                }else if(qc_task_detail.status == "NOT OK"){
                    $('#NOT_OK').iCheck('check');
                }

                $('#confirm_qc_task_detail').modal();
            },
            getQcTaskDetails(){
                window.axios.get('/api/getQcTaskDetails/'+this.qc_task_ref.id).then(({ data }) => {
                    $('div.overlay').show();
                    this.qc_task_details = data;
                    $('#qc_task_detail_table').DataTable().destroy();
                    this.$nextTick(function() {
                        $('#qc_task_detail_table').DataTable({
                            'paging'      : true,
                            'lengthChange': false,
                            'searching'   : true,
                            'ordering'    : true,
                            'info'        : true,
                            'autoWidth'   : false,
                            'initComplete': function(){
                                $('div.overlay').hide();
                            },
                            "columnDefs": [
                                { "searchable": false, "targets": [3,4,0] },
                                { "orderable": false, "targets": [3,4] }
                            ]
                        });
                    })
                });
            },
            updateQcTaskDetail(){
                var confirm_qc_task = this.confirm_qc_task;
                confirm_qc_task = JSON.stringify(confirm_qc_task);
                var url = "";
                if(this.route == "/qc_task"){
                    url = "{{ route('qc_task.storeConfirm') }}";
                }else{
                    // url = "{{ route('wbs_repair.store') }}";              
                }
                $('div.overlay').show();            
                window.axios.put(url,confirm_qc_task)
                .then((response) => {
                    if(response.data.error != undefined){
                        iziToast.warning({
                            displayMode: 'replace',
                            title: response.data.error,
                            position: 'topRight',
                        });
                        $('div.overlay').hide();            
                    }else{
                        iziToast.success({
                            displayMode: 'replace',
                            title: response.data.response,
                            position: 'topRight',
                        });
                        
                        this.getQcTaskDetails();
                        this.clearData();
                    }
                                    
                })
                .catch((error) => {
                    console.log(error);
                    $('div.overlay').hide();            
                })

            },
            confirmFinish(){
                iziToast.question({
                    close: false,
                    overlay: true,
                    timeout : 0,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirm',
                    message: 'Are you sure you want to Confirm Finish this QC Task?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            $('div.overlay').show();
                            formConfirmFinish.submit();                        

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                
                        }],
                    ],
                });
            },
            cancelFinish(){
                iziToast.question({
                    close: false,
                    overlay: true,
                    timeout : 0,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirm',
                    message: 'Are you sure you want to Cancel Finish this QC Task?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast) {
                            $('div.overlay').show();
                            formCancelFinish.submit();                        

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                
                        }],
                    ],
                });
            },
        },


        watch : {
        },
        created : function(){ 
            this.getQcTaskDetails();
        },
    })

</script>
@endpush