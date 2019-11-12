@extends('layouts.main')
@section('content-header')
@breadcrumb(
[
'title' => 'Create Quality Control Task',
'subtitle' => '',
'items' => [
'Dashboard' => route('index'),
'Create Quality Control Task' => '',
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
                @if($route == '/qc_task')
                <form id="create-qc-task" class="form-horizontal" method="POST" action="{{ route('qc_task.store') }}">
                    @else
                    {{-- <form id="create-qc-task" class="form-horizontal" method="POST" action="{{ route('qc_task_repair.store') }}">
                    --}}
                    @endif
                    @csrf
                    @verbatim
                    <div id="qc_task">
                        <div class="box-header no-padding">
                            <div class="col-xs-12 col-md-4" v-show="qc_type_id != ''">
                                <div class="col-sm-12 no-padding"><b>WBS Information</b></div>

                                <div class="col-md-4 no-padding">Number</div>
                                <div class="col-md-8 no-padding"><b>: {{wbs.number}}</b></div>

                                <div class="col-md-4 no-padding">Description</div>
                                <div v-if="wbs.description != ''" class="col-md-8 no-padding"><b>:
                                        {{wbs.description}}</b></div>
                                <div v-else class="col-md-8 no-padding"><b>: -</b></div>

                                <div class="col-md-4 no-padding">Deliverable</div>
                                <div class="col-md-8 no-padding "><b>: {{wbs.deliverables}}</b></div>

                                <div class="col-sm-12 no-padding"><b>QC Type Information</b></div>

                                <div class="col-md-4 no-padding">QC Type Name</div>
                                <div class="col-md-8 no-padding"><b>: {{selectedQcType.name}}</b></div>

                                <div class="col-md-4 no-padding">QC Type Description</div>
                                <div class="col-md-8 no-padding"><b>: {{selectedQcType.description}}</b></div>

                            </div>
                            <div class="col-xs-12 col-md-4">
                                <label for="">QC Type</label>
                                <selectize v-model="qc_type_id" :settings="qcTypeSettings">
                                    <option v-for="(qc_type, index) in qc_types" :value="qc_type.id">{{ qc_type.name }}
                                    </option>
                                </selectize>

                                <div v-show="qc_type_id != ''">
                                    <div class="col-sm-12 col-lg-4 p-l-0 p-t-20 ">
                                        <label for="">Start Date</label>
                                    </div>
                                    <div class="col-sm-12 col-lg-8 p-l-0 p-t-15 p-r-0">
                                        <input v-model="start_date" required autocomplete="off" type="text"
                                            class="form-control datepicker width100" name="start_date" id="start_date"
                                            placeholder="Set Start Date">
                                    </div>

                                    <div class="col-sm-12 col-lg-4 p-l-0 p-t-20">
                                        <label for="">End Date</label>
                                    </div>
                                    <div class="col-sm-12 col-lg-8 p-l-0 p-t-15 p-r-0">
                                        <input v-model="end_date" required autocomplete="off" type="text"
                                            class="form-control datepicker width100" name="end_date" id="end_date"
                                            placeholder="Set End Date">
                                    </div>

                                    <div class="col-sm-12 col-lg-4 p-l-0 p-t-20 ">
                                        <label for="">Duration</label>
                                    </div>
                                    <div class="col-sm-12 col-lg-8 p-l-0 p-t-15 p-r-0">
                                        <input @keyup="setEndDateNew" @change="setEndDateNew" v-model="duration"
                                            type="number" class="form-control" id="duration" placeholder="Duration"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4 " v-show="qc_type_id != ''">
                                <div class="row">
                                    <div class="col-xs-12 no-padding"><b>Quality Control Task Description</b></div>
                                    <div class="col-xs-12 no-padding">
                                        <textarea class="form-control"
                                            placeholder="Please Input Quality Control Task Description" rows="3"
                                            v-model="description"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-md-12 p-l-0 p-t-20">
                                        <div class="col-xs-1 no-padding">
                                            <input type="checkbox" v-icheck="" v-model="checkedExternal">
                                        </div>
                                        <div class="col-xs-11 no-padding"><b>Check if need external join</b></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" v-show="qc_type_id != ''">
                            <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                <table class="table table-bordered tableFixed showTable" style="border-collapse:collapse;" id="qc-task">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">No</th>
                                            <th style="width: 43%">QC Task Name</th>
                                            <th style="width: 40%">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(qc_task,index) in dataQcTask">
                                            <td>{{ index + 1 }}</td>
                                            <td class="tdEllipsis">{{ qc_task.name }}</td>
                                            <td class="tdEllipsis">{{ qc_task.task_description }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 p-r-0 p-t-10">
                            <button @click.prevent="submitForm" v-show="qc_type_id != ''" class="btn btn-primary pull-right">CREATE</button>
                        </div>
                    </div>
                    @endverbatim
                </form>
            </div>
        </div>
    </div>
    @endsection


    @push('script')
    <script>
        const form = document.querySelector('form#create-qc-task');

    $(document).ready(function() {
        $('div.overlay').hide();
    });

    var data = {
        qc_types : @json($modelQcType),
        selectedQcType :"",
        dataQcTask : [],
        qc_type_id : "",
        wbs : @json($modelWbs),
        newIndex : "",
        start_date : @json($modelWbs->planned_end_date),
        end_date : "",
        duration : "",
        checkedExternal : false,
        description : "",

        qcTypeSettings: {
            placeholder: 'Please Select QC Type'
        },

        submittedForm : {},

        dataInput : {
            name :"",
            description : "",
        },
        editQcTask : {
            index :"",
            name :"",
            description : "",
        },
    }

    var vm = new Vue({
        el : '#qc_task',
        data : data,
        mounted() {
            $('.datepicker').datepicker({
                autoclose : true,
                format: 'dd-mm-yyyy',
            });
            $("#start_date").datepicker().on(
                "changeDate", () => {
                    this.start_date = $('#start_date').val();
                    if(this.end_date != ""){
                        this.duration = datediff(parseDate(this.start_date), parseDate(this.end_date));
                    }
                    this.setEndDateNew();
                }
            );
            $("#end_date").datepicker().on(
                "changeDate", () => {
                    this.end_date = $('#end_date').val();
                    if(this.start_date != ""){
                        this.duration = datediff(parseDate(this.start_date), parseDate(this.end_date));
                    }
                }
            );
        },
        computed : {
            dataOk: function(){
                let isOk = false;

                if(this.submittedForm.dataQcTask.length > 0){
                    isOk = true;
                }

                return isOk;
            },

            updateOk: function(){
                let isOk = false;

                if(this.editQcTask.name == ""){
                    isOk = true;
                }

                return isOk;
            },
        },
        methods : {
            getQcTypeDetails(){
                window.axios.get('/api/getQcTypeDetails/'+this.qc_type_id).then(({ data }) => {
                    $('div.overlay').show();
                    this.dataQcTask = data;
                    this.newIndex = Object.keys(this.dataQcTask).length+1;
                    $('#qc-task').DataTable().destroy();
                    this.$nextTick(function() {
                        $('#qc-task').DataTable({
                            'paging'      : true,
                            'lengthChange': false,
                            'searching'   : true,
                            'ordering'    : false,
                            'info'        : true,
                            'autoWidth'   : false,
                        });
                        $('.parent-container').magnificPopup({
                            delegate: 'a', // child items selector, by clicking on it popup will open
                            type: 'iframe'
                            // other options
                        });
                        $('div.overlay').hide();
                    })
                });
            },
            clearData(){
                this.editQcTask.index = "";
                this.editQcTask.name = "";
                this.editQcTask.description = "";
                this.dataInput.name = "";
                this.dataInput.description = "";
            },
            removeRow: function(positions) {
                this.newIndex = this.submittedForm.dataQcTask.length;
                this.$delete(this.submittedForm.dataQcTask, positions);
            },
            add: function() {
                data = {
                    name: this.dataInput.name,
                    description: this.dataInput.description
                };
                this.submittedForm.dataQcTask.push(data);
                this.newIndex = this.submittedForm.dataQcTask.length + 1;
                this.clearData();
            },
            submitForm() {
                $('div.overlay').show();
                this.submittedForm.qc_type_id = this.qc_type_id;
                this.submittedForm.start_date = this.start_date;
                this.submittedForm.end_date = this.end_date;
                this.submittedForm.duration = this.duration;
                this.submittedForm.description = this.description;
                this.submittedForm.checkedExternal = this.checkedExternal;
                this.submittedForm.wbs_id = this.wbs.id;
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            setEndDateNew(){
                if(this.duration != "" && this.start_date != ""){
                    var planned_duration = parseInt(this.duration);
                    var planned_start_date = this.start_date;
                    var planned_end_date = new Date(planned_start_date.split("-").reverse().join("-"));

                    planned_end_date.setDate(planned_end_date.getDate() + planned_duration-1);
                    $('#end_date').datepicker('setDate', planned_end_date);
                }else{
                    this.end_date = "";
                }
            },
        },


        watch : {
            'qc_type_id' : function(newValue){
                // this.dataInput.wbs_id = "";
                this.selectedQcType = [];
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getQcType/'+newValue).then(({ data }) => {
                        this.selectedQcType = data;
                        this.submittedForm.dataQcTask = data.quality_control_type_details;
                        this.newIndex = this.submittedForm.dataQcTask.length + 1;
                        $('div.overlay').hide();
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again..',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        $('div.overlay').hide();
                    })

                    this.getQcTypeDetails();

                }else{
                    this.selectedQcType = "";
                }
            },
            'duration' : function(newValue){
                if(newValue < 1){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: 'End Date cannot be ahead Start Date',
                        position: 'topRight',
                    });
                    this.duration = "";
                    this.end_date = "";
                }
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
                            vm.$data[vModel] = $(this).val();
                        }
                        if ($(el).attr("type") == "checkbox") {
                            let data = vm.$data[vModel];

                            $(el).prop("checked")
                            ? vm.$data[vModel] = true
                            : vm.$data[vModel] = false;
                        }
                    });
                }
            }
        },
        created:function(){
            // this.getQcTypeDetails();
        },
    });

    function parseDate(str) {
        var mdy = str.split('-');
        var date = new Date(mdy[2], mdy[1]-1, mdy[0]);
        return date;
    }

    //Additional Function
    function datediff(first, second) {
        // Take the difference between the dates and divide by milliseconds per day.
        // Round to nearest whole number to deal with DST.
        return Math.round(((second-first)/(1000*60*60*24))+1);
    }

    </script>
    @endpush