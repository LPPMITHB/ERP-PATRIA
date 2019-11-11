@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Edit Quality Control Task',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Edit Quality Control Task' => '',
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
                        <form id="edit-qc-task" class="form-horizontal" method="POST" action="{{ route('qc_task.update') }}">
                    @else
                        {{-- <form id="edit-qc-task" class="form-horizontal" method="POST" action="{{ route('qc_task_repair.store') }}"> --}}
                    @endif
                    <input type="hidden" name="_method" value="PATCH">
                    @csrf
                        @verbatim
                        <div id="qc_task">
                            <div class="box-header no-padding">
                                <div class="col-xs-12 col-md-4" v-show="qc_type_id != ''">
                                    <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                                    
                                    <div class="col-md-4 no-padding">Number</div>
                                    <div class="col-md-8 no-padding"><b>: {{wbs.number}}</b></div>
            
                                    <div class="col-md-4 no-padding">Description</div>
                                    <div v-if="wbs.description != ''" class="col-md-8 no-padding"><b>: {{wbs.description}}</b></div>
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
                                    <label for="" >QC Type</label>
                                    <selectize :disabled="!editable" v-model="qc_type_id" :settings="qcTypeSettings" >
                                        <option v-for="(qc_type, index) in qc_types" :value="qc_type.id">{{ qc_type.name }}</option>
                                    </selectize>
                                </div>
                                <div class="col-xs-12 col-md-4 " v-show="qc_type_id != ''">
                                    <div class="row">
                                        <div class="col-xs-12 no-padding"><b>Quality Control Task Description</b></div>
                                        <div class="col-xs-12 no-padding">
                                            <textarea class="form-control" placeholder="Please Input Quality Control Task Description" rows="3"
                                                v-model="submittedForm.description"></textarea>
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
                                    <table class="table table-bordered tableFixed showTable" style="border-collapse:collapse;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th style="width: 43%">QC Task Name</th>
                                                <th style="width: 40%">Description</th>
                                                <th style="width: 13%">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(qc_task,index) in submittedForm.dataQcTask">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{ qc_task.name }}</td>
                                                <td class="tdEllipsis">{{ qc_task.task_description }}</td>
                                                <td class="tdEllipsis" v-if="qc_task.status == null">NOT DONE</td>
                                                <td class="tdEllipsis" v-else>{{qc_task.status}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 p-r-0 p-t-10">
                                <button @click.prevent="submitForm" v-show="qc_type_id != ''" class="btn btn-primary pull-right">SAVE</button>
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
     const form = document.querySelector('form#edit-qc-task');

    $(document).ready(function() {
        $('div.overlay').hide();
    });

    var data = {
        qc_types : @json($modelQcType),
        selectedQcType :"",
        qc_type_id : @json($qcTask->quality_control_type_id),
        wbs : @json($qcTask->wbs),
        newIndex : "",
        start_date : @json($qcTask->start_date);
        end_date : @json($qcTask->end_date);
        duration : @json($qcTask->duration);
        qcTypeSettings: {
            placeholder: 'Please Select QC Type'
        },

        submittedForm: {
            id:@json($qcTask->id),
            description: @json($qcTask->description),
            dataQcTask :@json($qcTask->qualityControlTaskDetails),
            deletedQcTaskDetail: [],
        },
        dataInput : {
            name :"",
            description : "",
        },
        editQcTask : {
            index :"",
            name :"",
            description : "",
        },
        checkedExternal : @json($qcTask->external_join),

        editable : @json($editable),
    }

    var vm = new Vue({
        el : '#qc_task',
        data : data,
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
            getQcType(newValue){
                window.axios.get('/api/getQcType/'+newValue).then(({ data }) => {
                    this.selectedQcType = data;
                    data.quality_control_type_details.forEach(qc_task_detail => {
                        delete qc_task_detail.id;
                    });
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
            },
            clearData(){
                this.editQcTask.index = "";
                this.editQcTask.name = "";
                this.editQcTask.description = "";
                this.dataInput.name = "";
                this.dataInput.description = "";
            },
            removeRow: function(index) {
                this.newIndex = this.submittedForm.dataQcTask.length;
                if(this.submittedForm.dataQcTask[index].id != undefined){
                    this.submittedForm.deletedQcTaskDetail.push(this.submittedForm.dataQcTask[index].id);
                }
                this.$delete(this.submittedForm.dataQcTask, index);
            },
            clearData(){
                this.dataInput.name = "";
                this.dataInput.description = "";
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
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            openEditModal(index){
                this.editQcTask.index = index;
                this.editQcTask.name = this.submittedForm.dataQcTask[index].name;
                this.editQcTask.description = this.submittedForm.dataQcTask[index].description;
                $('#edit_item').modal();
            },
            updateQcTaskDetail(){
                $('div.overlay').show();
                index_edit = this.editQcTask.index;
                this.submittedForm.dataQcTask[index_edit].name = this.editQcTask.name;
                this.submittedForm.dataQcTask[index_edit].description = this.editQcTask.description;
                this.clearData();
                $('div.overlay').hide();
            },
        },


        watch : {
            'qc_type_id' : function(newValue){
                // this.dataInput.wbs_id = "";
                this.selectedQcType = [];
                if(newValue != ""){
                    $('div.overlay').show();
                    this.getQcType(newValue);
                }else{
                    this.selectedQcType = "";
                }
            },
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
        created : function(){ 
            this.getQcType(this.qc_type_id);
            this.newIndex = this.submittedForm.dataQcTask.length + 1;            
        }
    })

</script>
@endpush