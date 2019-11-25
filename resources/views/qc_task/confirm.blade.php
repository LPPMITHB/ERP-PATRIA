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
                                    <div class="row">
                                        <a v-if="qc_task_ref.status == 1" class="btn btn-sm btn-primary pull-right btn-block" @click="confirmFinish">CONFIRM FINISHED</a>
                                        <a v-else-if="qc_task_ref.status == 0" class="btn btn-sm btn-primary pull-right btn-block" @click="cancelFinish">CANCEL FINISH</a>
                                    </div>
                                    <div class="row">
                                        <a class="btn btn-primary btn-sm pull-right btn-block m-t-10" data-toggle="modal" href="#show_modal_wbs_images">VIEW WBS IMAGES</a>
                                    </div>
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
                                                <td class="tdEllipsis" v-if="data.status_first == null">NOT DONE</td>
                                                <td class="tdEllipsis" v-else-if="data.status_second != null">{{data.status_second}}</td>
                                                <td class="tdEllipsis" v-else-if="data.status_second == null && data.status_first != null">{{data.status_first}}</td>
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

                            <div class="modal fade" id="show_modal_wbs_images">
                                <div class="modal-dialog modalPredecessor modalFull">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title">View WBS Images</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table id="qctd-table" class="table table-bordered showTable">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 5%">No</th>
                                                                <th style="width: 35%">File Name</th>
                                                                <th style="width: 45%">Description</th>
                                                                <th style="width: 4%"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(data,index) in wbsImages">
                                                                <td>{{ index + 1 }}</td>
                                                                <td class="tdEllipsis" data-container="body"
                                                                    v-tooltip:top="tooltipText(data.drawing)">{{ data.drawing }}</td>
                                                                <td class="tdEllipsis" data-container="body"
                                                                    v-tooltip:top="tooltipText(data.description)">{{ data.description }}</td>
                                                                <td>
                                                                    <a class="btn btn-primary btn-sm" :href="view(data.drawing)">VIEW</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">CLOSE</button>
                                        </div>
                                    </div>
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

                                                <div class="col-sm-3">
                                                    <label for="quantity" class="control-label">Status</label>
                                                    <div v-if="qc_task_ref.status == 1" class="row">
                                                        <div v-show="confirm_qc_task.status_first_ref == null" class="col-sm-12">
                                                            <input class="checkbox_icheck_first" :disabled="finishedOk" type="checkbox" id="OK_first" value="OK">
                                                            <label class="text-success">OK</label>
                                                        </div>
                                                        <div v-show="confirm_qc_task.status_first_ref == null" class="col-sm-12">
                                                            <input class="checkbox_icheck_first" :disabled="finishedOk" type="checkbox" id="NOT_OK_first"value="NOT OK">
                                                            <label class="text-danger">NOT OK</label>
                                                        </div>
                                                        <div v-show="confirm_qc_task.status_first_ref != null" class="col-sm-12">
                                                            <p>
                                                                <b v-if="confirm_qc_task.status_first_ref == 'OK'" class="text-success">{{confirm_qc_task.status_first_ref}}</b>
                                                                <b v-else-if="confirm_qc_task.status_first_ref == 'NOT OK'" class="text-danger">{{confirm_qc_task.status_first_ref}}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div v-else-if="qc_task_ref.status == 0" class="row">
                                                        <div class="col-sm-12">
                                                            <p>
                                                                <b v-if="confirm_qc_task.status_first == 'OK'" class="text-success">{{confirm_qc_task.status_first}}</b>
                                                                <b v-else-if="confirm_qc_task.status_first == 'NOT OK'" class="text-danger">{{confirm_qc_task.status_first}}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" v-show="confirm_qc_task.status_first_ref != '' && confirm_qc_task.status_first_ref != null && confirm_qc_task.status_first_ref != 'OK'">
                                                    <label for="quantity" class="control-label">Status Reinspect</label>
                                                    <div v-if="qc_task_ref.status == 1" class="row">
                                                        <div class="col-sm-12">
                                                            <input class="checkbox_icheck_second" :disabled="finishedOk" type="checkbox" id="OK_second" value="OK">
                                                            <label class="text-success">OK</label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input class="checkbox_icheck_second" :disabled="finishedOk" type="checkbox" id="NOT_OK_second" value="NOT OK">
                                                            <label class="text-danger">NOT OK</label>
                                                        </div>
                                                    </div>
                                                    <div v-else-if="qc_task_ref.status == 0" class="row">
                                                        <div class="col-sm-12">
                                                            <p>
                                                                <b v-if="confirm_qc_task.status_second == 'OK'" class="text-success">{{confirm_qc_task.status_second}}</b>
                                                                <b v-else-if="confirm_qc_task.status_second == 'NOT OK'" class="text-danger">{{confirm_qc_task.status_second}}</b>
                                                                <b v-else>-</b>
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
                                            <button v-if="qc_task_ref.status == 1" class="btn btn-primary" data-dismiss="modal" :disabled="confirmOk"
                                                @click.prevent="updateQcTaskDetail">SAVE</button>
                                            <button v-else-if="qc_task_ref.status == 0" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
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
                    @elseif($route == "/qc_task_repair")
                        <form id="confirm-finish-qc-task" class="form-horizontal" method="POST" action="{{ route('qc_task_repair.confirmFinish',['id'=>$qcTask->id]) }}">
                            <input type="hidden" name="_method" value="PATCH">
                            @csrf
                        </form>
                        <form id="cancel-finish-qc-task" class="form-horizontal" method="POST" action="{{ route('qc_task_repair.cancelFinish',['id'=>$qcTask->id]) }}">
                            <input type="hidden" name="_method" value="PATCH">
                            @csrf
                        </form>
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
            status_first : "",
            status_first_ref : "",
            status_second : "",
            notes : "",
            name : "",
            description : "",
        },
        wbsImages : @json($wbs_images),

    }

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    var vm = new Vue({
        el : '#qc_task',
        data : data,
        mounted: function(){
            
        },
        computed : {
            confirmOk: function(){
                let isOk = false;

                if(this.confirm_qc_task.status_first_ref == null){
                    if(this.confirm_qc_task.status_first == "" || this.confirm_qc_task.status_first == null){
                        isOk = true;
                    }
                }else{
                    if(this.confirm_qc_task.status_second == "" || this.confirm_qc_task.status_second == null){
                        isOk = true;
                    }
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
            tooltipText: function(text) {
                return text
            },
            view(drawing){
                let path = '../../app/documents/wbs_images/'+drawing;
                
                return path;
            },
            clearData(){
                this.confirm_qc_task.index = "";
                this.confirm_qc_task.id = "";
                this.confirm_qc_task.name = "";
                this.confirm_qc_task.description = "";
                this.confirm_qc_task.status_first = "";
                this.confirm_qc_task.status_first_ref= "";
                this.confirm_qc_task.status_second = "";
                this.confirm_qc_task.notes = "";
                $('#NOT_OK_first').iCheck('uncheck');
                $('#OK_first').iCheck('uncheck');
                $('#NOT_OK_second').iCheck('uncheck');
                $('#OK_second').iCheck('uncheck');
            },
            openConfirmModal(index){
                this.clearData();
                var qc_task_detail = this.qc_task_details[index];
                this.confirm_qc_task.index = index;
                this.confirm_qc_task.id = qc_task_detail.id;
                this.confirm_qc_task.name = qc_task_detail.name;
                this.confirm_qc_task.description = qc_task_detail.description;
                this.confirm_qc_task.status_first = qc_task_detail.status_first;
                this.confirm_qc_task.status_second = qc_task_detail.status_second;
                this.confirm_qc_task.status_first_ref = qc_task_detail.status_first;
                this.confirm_qc_task.notes = qc_task_detail.notes;
                if(qc_task_detail.status_second == "OK"){
                    $('#OK_second').iCheck('check');
                }else if(qc_task_detail.status_second == "NOT OK"){
                    $('#NOT_OK_second').iCheck('check');
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
                }else if(this.route == "/qc_task_repair"){
                    url = "{{ route('qc_task_repair.storeConfirm') }}";
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
        updated : function(){
            jQuery('.checkbox_icheck_first').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

            jQuery('.checkbox_icheck_first').on('ifChecked', function(e){
                var value = $(this).val().split('-')[0];
                var index = $(this).val().split('-')[1];

                if(value == "OK"){
                    $('#NOT_OK_first').iCheck('uncheck');
                }else if(value == "NOT OK"){
                    $('#OK_first').iCheck('uncheck');
                }
                vm.confirm_qc_task.status_first = value;
            });
            jQuery('.checkbox_icheck_first').on('ifUnchecked', function(e){
                var value = $(this).val().split('-')[0];
                var index = $(this).val().split('-')[1];
                vm.confirm_qc_task.status_first = null;
            });
            
            jQuery('.checkbox_icheck_second').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
            jQuery('.checkbox_icheck_second').on('ifChecked', function(e){
                var value = $(this).val().split('-')[0];
                var index = $(this).val().split('-')[1];

                if(value == "OK"){
                    $('#NOT_OK_second').iCheck('uncheck');
                }else if(value == "NOT OK"){
                    $('#OK_second').iCheck('uncheck');
                }
                vm.confirm_qc_task.status_second = value;
            });
            jQuery('.checkbox_icheck_second').on('ifUnchecked', function(e){
                var value = $(this).val().split('-')[0];
                var index = $(this).val().split('-')[1];
                vm.confirm_qc_task.status_second = null;
            });
        }
    })

</script>
@endpush