@extends('layouts.main')
@section('content-header')
    @breadcrumb(
        [
            'title' => 'Manage Quality Control Task',
            'subtitle' => '',
            'items' => [
                'Dashboard' => route('index'),
                'Quality Control' => route('qc_type.index'),
                'Create' => '',
            ]
        ]
    )
    @endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 p-b-50">
        <div class="box">
            <div class="box-body no-padding p-b-10">
                <form id="create-qc" class="form-horizontal" method="POST" action="{{ route('qc_type.store') }}">
                    @csrf
                    @verbatim
                    <div id="qualityControl">
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
                                            <a href="#" @click="removeRow(index)" class="btn btn-danger btn-xs">
                                                <div class="btn-group">DELETE</div>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>{{newIndex}}</td>
                                        <td class="no-padding"><input class="form-control" type="text"
                                                v-model="input.name"></td>
                                        <td class="no-padding">
                                            <textarea class="form-control" rows="1"
                                                v-model="input.description"></textarea>
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
                            <button id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right"
                                :disabled="createOk">CREATE</button>
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
                                                <label for="quantity" class="control-label">Task Description</label>
                                                <textarea class="form-control" rows="5"
                                                    v-model="forms.description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                                            :disabled="updateOk" @click.prevent="submitToTable()">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endverbatim
                </form>
            </div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const form = document.querySelector('form#create-qc');

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
            name: '',
            description: '',
        },
        input: {
            name: '',
            description: '',
        },
        qtc_task: [],
        forms: {
            index: '',
            name: '',
            position: '',
            description: '',
        }
    }

    var vm = new Vue({
        el: '#qualityControl',
        data: data,
        methods: {
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
            submitToTable() {
                if (this.modalWork == 'add') {
                    data = {
                        name: this.forms.name,
                        description: this.forms.description
                    };
                    this.qtc_task.push(data);
                    this.newIndex = this.qtc_task.length + 1;
                } else if (this.modalWork == 'edit') {
                    this.qtc_task[this.forms.index].name = this.forms.name;
                    this.qtc_task[this.forms.index].description = this.forms.description;
                }
                this.modalWork = '';
                this.forms.index = '';
                this.forms.name = '';
                this.forms.description = '';
            },
            removeRow: function(positions) {
                this.newIndex = this.qtc_task.length;
                this.$delete(this.qtc_task, positions);
            },
            openEditModal: function(positions) {
                this.modalWork = 'edit';
                this.forms.index = positions;
                this.forms.name = this.qtc_task[positions].name;
                this.forms.description = this.qtc_task[positions].description;
                $('#edit_item').modal();
            },
            openAddModal: function() {
                this.modalWork = 'add';
                this.forms.index = '';
                this.forms.name = '';
                this.forms.description = '';
                $('#edit_item').modal();
            },
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