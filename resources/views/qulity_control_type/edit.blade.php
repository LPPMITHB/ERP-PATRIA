@extends('layouts.main')
@section('content-header')
@breadcrumb(
[
'title' => 'Manage Quality Control Task',
'subtitle' => '',
'items' => [
'Dashboard' => route('index'),
'Quality Control' => route('qc_type.index'),
'Edit' => '',
]
]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 p-b-50">
        @verbatim
        <div id="qualityControl">
            <div class="box">
                <div class="box-body no-padding p-b-10">

                    <div class="box-header p-b-0">
                        <div class="col-xs-12 col-md-4">
                            <div class="col-xs-12 no-padding"><b>Quality Control Type Name</b></div>
                            <div class="col-xs-12 no-padding">
                                <input class="form-control" type="text" v-model="mstInput.name">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <div class="col-xs-12 no-padding"><b>Quality Control Description</b></div>
                            <div class="col-xs-12 no-padding">
                                <textarea class="form-control" rows="3" v-model="mstInput.description"></textarea>
                            </div>
                        </div>
                    </div> <!-- /.box-header -->
                    <div class="col-md-12 p-t-5">
                        <table class="table table-bordered tableFixed m-b-0 tablePagingVue">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="25%">Name</th>
                                    <th width="60%">Description</th>
                                    <th width="10%">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(qtc_tasks, index) in qtc_task">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ qtc_tasks.name }}</td>
                                    <td>{{ qtc_tasks.description }}</td>
                                    <td class="p-l-5" align="center">
                                        <a class="btn btn-primary btn-xs" href="#edit_item"
                                            @click="openEditModal(index)">
                                            EDIT
                                        </a>
                                        <a href="#" @click.prevent="deleteDetails(qtc_tasks.id, index)"
                                            class="btn btn-danger btn-xs">
                                            <div class="btn-group">DELETE</div>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>{{newIndex}}</td>
                                    <td class="no-padding"><input class="form-control" type="text" v-model="input.name">
                                    </td>
                                    <td class="no-padding">
                                        <textarea class="form-control" rows="1" v-model="input.description"></textarea>
                                    </td>
                                    <td class="p-l-0" align="center"><a @click.prevent="openAddModal()"
                                            class="btn btn-primary btn-xs" href="#">
                                            <div class="btn-group">
                                                ADD
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-md-12 p-t-5">
                        <button id="process" @click.prevent="mstUpdate()" class="btn btn-primary pull-right"
                            :disabled="createOk">SAVE</button>
                    </div>

                </div>
                <div class="modal fade" id="edit_item">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h4 class="modal-title">Edit Quality Task</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="type" class="control-label">Task Name</label>
                                        <input class="form-control" type="text" v-model="forms.name">
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="quantity" class="control-label">Task
                                            Description</label>
                                        <textarea class="form-control" rows="5" v-model="forms.description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" data-dismiss="modal" :disabled="updateOk"
                                    @click.prevent="submitToTable">SAVE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endverbatim
    </div>
</div>
<div class="overlay">
    <i class="fa fa-refresh fa-spin"></i>
</div>

@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('div.overlay').hide();
    });

    var data = {
        newIndex: 0,
        modalWork: '',
        sumbitedForm: {
            name: '',
            description: '',
            task: []
        },
        mstInput: {
            id:@json($qcType->id),
            name: @json($qcType->name),
            description: @json($qcType->description),
        },
        input: {
            name: '',
            description: '',
        },
        qtc_task: @json($qcTypeDetail),
        forms: {
            qc_typeID:@json($qcType->id),
            detailID:'',
            index: '',
            name: '',
            description: '',
        }
    }

    var vm = new Vue({
        el: '#qualityControl',
        data: data,
        methods: {
            mstUpdate(){
                console.log(this.mstInput.description);
                console.log(this.mstInput.name);
                var url = "{{ route('qc_type.updatemaster') }}";
                var data = JSON.stringify(this.mstInput);
                window.axios.put(url,data).then((response) => {
                    iziToast.success({
                        title: 'QC task updated !',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                        this.addRow(response);
                        $('div.overlay').hide();
                        this.forms.detailID='';
                        this.forms.index = '';
                        this.forms.name = '';
                        this.forms.description = '';
                    })
                    .catch((error) => {
                        iziToast.warning({
                        title: 'Please Try Agains..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    console.log(error);
                    $('div.overlay').hide();
                })
            },
            deleteDetails(id, position){
                iziToast.question({
                    close: false,
                    overlay: true,
                    timeout : 0,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 9999,
                    title: 'Confirm',
                    message: 'Are you sure you want to delete this task?',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', function (instance, toast){
                            var url = "/qc_type/deletedetail/"+id;
                            $('div.overlay').show();
                            window.axios.delete(url).then((response) => {
                                iziToast.error({
                                    displayMode: 'replace',
                                    title: "qc type detail deleted ",
                                    position: 'topRight',
                                });
                               vm.removeRow(position);
                               
                                $('div.overlay').hide();
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
                if(this.detailDeleteStatus==true){
                    this.newIndex = this.qtc_task.length;
                    this.$delete(this.qtc_task, position);
                    this.detailDeleteStatus=false;
                }
                
            },
            submitForm() {
                $('div.overlay').show();
                this.sumbitedForm.task = this.qtc_task;
                this.sumbitedForm.name = this.mstInput.name;
                this.sumbitedForm.description = this.mstInput.description;
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.sumbitedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            submitDetails(){
                $('div.overlay').show();
                var url = "{{ route('qc_type.updatedetail') }}";
                var detailData = JSON.stringify(this.forms);
                window.axios.put(url,detailData).then((response) => {
                    iziToast.success({
                        title: 'QC task updated !',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    this.addRow(response);
                    $('div.overlay').hide();
                    this.forms.detailID='';
                    this.forms.index = '';
                    this.forms.name = '';
                    this.forms.description = '';
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Agains..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    console.log(error);
                    $('div.overlay').hide();
                })
            },
            submitToTable() {
                $('div.overlay').show();
                this.submitDetails();
            },
            addRow:function(response){
                console.log(JSON.stringify(response.data));
                if (this.modalWork == 'add') {
                    data = {
                        id:JSON.stringify(response.data),
                        name: this.forms.name,
                        description: this.forms.description
                    };
                    this.qtc_task.push(data);
                    this.newIndex = this.qtc_task.length + 1;
                } else if (this.modalWork == 'edit') {
                    this.qtc_task[this.forms.index].name = this.forms.name;
                    this.qtc_task[this.forms.index].description = this.forms.description;
                }
            },
            removeRow: function(positions) {
                this.newIndex = this.qtc_task.length;

                this.$delete(this.qtc_task, positions);
            },
            openEditModal: function(positions) {
                this.modalWork = 'edit';
                this.forms.detailID = this.qtc_task[positions].id;
                this.forms.index = positions;;
                this.forms.name = this.qtc_task[positions].name;
                this.forms.description = this.qtc_task[positions].description;
                $('#edit_item').modal();
            },
            openAddModal: function() {
                this.modalWork = 'add';
                this.forms.detailID = '';
                this.forms.index = '';
                this.forms.name = '';
                this.forms.description = '';
                $('#edit_item').modal();
            },
        },
        mounted(){
            this.newIndex = this.qtc_task.length+1;
        },
        computed: {
            updateOk: function() {
                let isOk = false;
                if (this.forms.name == "" || this.forms.name == null) {
                    isOk = true;
                }
                return isOk;
            },
            createOk: function() {
                let isOk = false;
                if (this.mstInput.name == "" || this.mstInput.description == "" || this.qtc_task.length == 0) {
                    isOk = true;
                }
                return isOk;
            },
        },
    });
</script>
@endpush