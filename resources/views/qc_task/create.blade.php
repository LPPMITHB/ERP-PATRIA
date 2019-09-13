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
                        {{-- <form id="create-qc-task" class="form-horizontal" method="POST" action="{{ route('qc_task_repair.store') }}"> --}}
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
                                    <selectize v-model="qc_type_id" :settings="qcTypeSettings" >
                                        <option v-for="(qc_type, index) in qc_types" :value="qc_type.id">{{ qc_type.name }}</option>
                                    </selectize>
                                </div>
                                <div class="col-xs-12 col-md-4 " v-show="qc_type_id != ''">
                                    <div class="col-xs-12 no-padding"><b>Quality Control Task Description</b></div>
                                    <div class="col-xs-12 no-padding">
                                        <textarea class="form-control" placeholder="Please Input Quality Control Task Description" rows="3"
                                            v-model="submittedForm.description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-show="qc_type_id != ''">
                                <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                    <table class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th style="width: 43%">QC Task Name</th>
                                                <th style="width: 40%">Description</th>
                                                <th style="width: 13%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(qc_task,index) in submittedForm.dataQcTask">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{ qc_task.name }}</td>
                                                <td class="tdEllipsis">{{ qc_task.description }}</td>
                                                <td class="p-l-0 textCenter">
                                                    <a class="btn btn-primary btn-xs" @click="openEditModal(index)">
                                                        EDIT
                                                    </a>
                                                    <a href="#" @click="removeRow(index)" class="btn btn-danger btn-xs">
                                                        DELETE
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="p-l-10">{{newIndex}}</td>

                                                <td class="p-l-0">
                                                    <input class="form-control" v-model="dataInput.name" placeholder="Please Input Name">
                                                </td>
                                                <td class="p-l-0">
                                                    <input class="form-control" v-model="dataInput.description" placeholder="Please Input description">
                                                </td>
                                                <td class="p-l-0 textCenter">
                                                    <button @click.prevent="add" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 p-r-0 p-t-10">
                                <button @click.prevent="submitForm" v-show="qc_type_id != ''" class="btn btn-primary pull-right">CREATE</button>
                            </div>

                            <div class="modal fade" id="edit_item">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <h4 class="modal-title">Edit Quality Control Task Detail</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label for="type" class="control-label">Task Name</label>
                                                    <input class="form-control" type="text" v-model="editQcTask.name">
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="quantity" class="control-label">Task
                                                        Description</label>
                                                    <textarea class="form-control" rows="5" v-model="editQcTask.description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" data-dismiss="modal" :disabled="updateOk"
                                                @click.prevent="updateQcTaskDetail">SAVE</button>
                                        </div>
                                    </div>
                                </div>
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
        qc_type_id : "",
        wbs : @json($modelWbs),
        newIndex : "",
        qcTypeSettings: {
            placeholder: 'Please Select QC Type'
        },

        submittedForm: {
            wbs_id:@json($modelWbs->id),
            description: '',
            dataQcTask :[],
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
                    window.axios.get('/api/getQcType/'+newValue).then(({ data }) => {
                        console.log(data);
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
                }else{
                    this.selectedQcType = "";
                }
            },
        },
    })

</script>
@endpush