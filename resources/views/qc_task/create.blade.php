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
                    @if($route == 'qc_task')
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

                                    <div class="col-md-4 no-padding">QC Type Code</div>
                                    <div class="col-md-8 no-padding"><b>: {{selectedQcType.code}}</b></div>
                                    
                                    <div class="col-md-4 no-padding">QC Type Name</div>
                                    <div class="col-md-8 no-padding"><b>: {{selectedQcType.name}}</b></div>

                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <label for="" >QC Type</label>
                                    <selectize v-model="qc_type_id" :settings="qcTypeSettings" >
                                        <option v-for="(qc_type, index) in qc_types" :value="qc_type.id">{{ qc_type.name }}</option>
                                    </selectize>
                                </div>
                            </div>
                            <div class="row" v-show="qc_type_id != ''">
                                <div class="col sm-12 p-l-15 p-r-10 p-t-10 p-r-15">
                                    <table class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">No</th>
                                                <th style="width: 33%">QC Task Name</th>
                                                <th style="width: 20%">Position</th>
                                                <th style="width: 30%">Description</th>
                                                <th style="width: 13%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(qc_task,index) in dataQcTask">
                                                <td>{{ index + 1 }}</td>
                                                <td class="tdEllipsis">{{ qc_task.name }}</td>
                                                <td class="tdEllipsis">{{ qc_task.position }}</td>
                                                <td class="tdEllipsis">{{ qc_task.description }}</td>
                                                <td class="p-l-0 textCenter">
                                                    <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(qc_task,index)">
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
                                                    <input class="form-control" v-model="dataInput.description" placeholder="Please Input Name">
                                                </td>
                                                <td class="p-l-0">
                                                    <input class="form-control" v-model="dataInput.position" placeholder="Please Input Position">
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
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right">CREATE</button>
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
    $(document).ready(function(){
        $('div.overlay').hide();
    });



    var data = {
        qc_types : @json($modelQcType),
        selectedQcType :"",
        qc_type_id : "",
        wbs : @json($modelWbs),
        newIndex : "",
        dataQcTask : [],

        qcTypeSettings: {
            placeholder: 'Please Select QC Type'
        },

        dataInput : {
            number :"",
            description : "",
            position : "",
        },
    }

    var vm = new Vue({
        el : '#qc_task',
        data : data,
        computed : {
            dataOk: function(){
                let isOk = false;

                if(this.dataQcTask.length > 0){
                    isOk = true;
                }

                return isOk;
            },
        },
        methods : {
            
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
                        this.dataQcTask = data.quality_control_type_details;
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