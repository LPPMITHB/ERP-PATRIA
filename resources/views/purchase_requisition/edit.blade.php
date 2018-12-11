@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Edit Purchase Requisition',
        'items' => [
            'Dashboard' => route('index'),
            'View All Purchase Requisitions' => route('purchase_requisition.index'),
            'Edit Purchase Requisition' => route('purchase_requisition.edit',$modelPR->id),
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
                <div id="pr">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                <div class="col-sm-5">
                                    Purchase Requisition Number
                                </div>
                                <div class="col-sm-7">
                                    : <b>{{ modelPR.number }}</b>
                                </div>
                                <div class="col-sm-5">
                                    Project Code
                                </div>
                                <div class="col-sm-7">
                                    : <b>{{ project.code }}</b>
                                </div>
                                <div class="col-sm-5">
                                    Project Name
                                </div>
                                <div class="col-sm-7">
                                    : <b>{{ project.name }}</b>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="col-sm-5">
                                    Customer Name
                                </div>
                                <div class="col-sm-7">
                                    : <b>{{ project.customer.name }}</b>
                                </div>
                                <div class="col-sm-5">
                                    Ship Name
                                </div>
                                <div class="col-sm-7">
                                    : <b>{{ project.ship.name }}</b>
                                </div>
                                <div class="col-sm-5">
                                    Ship Type
                                </div>
                                <div class="col-sm-7">
                                    : <b>{{ project.ship.type }}</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col sm-12 p-l-10 p-r-10 p-t-10">
                            <table class="table table-bordered tableFixed" style="border-collapse:collapse;">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 35%">Material Name</th>
                                        <th style="width: 20%">Quantity</th>
                                        <th style="width: 30%">Work Name</th>
                                        <th style="width: 10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(PRD,index) in modelPRD">
                                        <td>{{ index + 1 }}</td>
                                        <td class="tdEllipsis">{{ PRD.material.code }} - {{ PRD.material.name }}</td>
                                        <td class="tdEllipsis">{{ PRD.quantity }}</td>
                                        <td class="tdEllipsis">{{ PRD.work.name }}</td>
                                        <td class="p-l-0 textCenter">
                                            <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(PRD,index)">
                                                EDIT
                                            </a>
                                            <a href="#" @click="remove(PRD.id)" class="btn btn-danger btn-xs">
                                                DELETE
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="p-l-10">{{newIndex}}</td>
                                        <td class="p-l-0 textLeft">
                                            <selectize v-model="dataInput.material_id" :settings="materialSettings">
                                                <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                            </selectize>
                                        </td>
                                        <td class="p-l-0">
                                            <input class="form-control" v-model="dataInput.quantity" placeholder="Please Input Quantity">
                                        </td>
                                        <td class="p-l-0 textLeft">
                                            <selectize v-model="dataInput.wbs_id" :settings="workSettings">
                                                <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                            </selectize>
                                        </td>
                                        <td class="p-l-0 textCenter">
                                            <button @click.prevent="add" :disabled="createOk" class="btn btn-primary btn-xs" id="btnSubmit">ADD</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>


                    <div class="modal fade" id="edit_item">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit Material</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="type" class="control-label">Material</label>
                                            <selectize id="edit_modal" v-model="editInput.material_id" :settings="materialSettings" disabled>
                                                <option v-for="(material, index) in materials" :value="material.id">{{ material.code }} - {{ material.name }}</option>
                                            </selectize>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="quantity" class="control-label">Quantity</label>
                                            <input type="text" id="quantity" v-model="editInput.quantity" class="form-control" placeholder="Please Input Quantity">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="type" class="control-label">Work Name</label>
                                            <selectize id="edit_modal" v-model="editInput.wbs_id" :settings="workSettings" disabled>
                                                <option v-for="(work, index) in works" :value="work.id">{{ work.name }}</option>
                                            </selectize>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update">SAVE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endverbatim
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

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        modelPR : @json($modelPR),
        project : @json($project),
        modelPRD : @json($modelPRD),
        materials : @json($materials),
        works : @json($works),
        workSettings: {
            placeholder: 'Please Select Work'
        },
        materialSettings: {
            placeholder: 'Please Select Material'
        },
        dataInput : {
            material_id :"",
            quantity : "",
            wbs_id : "",
        },
        editInput : {
            material_id : "",
            quantity : "",
            wbs_id : "",
        },
    }

    var vm = new Vue({
        el : '#pr',
        data : data,
        computed : {
            createOk: function(){
                let isOk = false;

                if(this.dataInput.material_id == "" || this.dataInput.quantity == "" || this.dataInput.wbs_id == "" || parseInt((this.dataInput.quantity+"").replace(/,/g , '')) < 1){
                    isOk = true;
                }

                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                if(this.editInput.material_id == "" || this.editInput.quantity == "" || this.editInput.wbs_id == "" || parseInt((this.editInput.quantity+"").replace(/,/g , '')) < 1){
                    isOk = true;
                }
                return isOk;
            }
        },
        methods : {
            getPRD(pr_id){
                window.axios.get('/api/getPRD/'+pr_id).then(({ data }) => {
                    this.modelPRD = data;
                    $('div.overlay').hide();
                    this.newIndex = this.modelPRD.length + 1;
                });
            },
            add(){
                this.dataInput.quantity = (this.dataInput.quantity+"").replace(/,/g , '');
                this.dataInput.quantity = parseInt(this.dataInput.quantity);

                $('div.overlay').show();
                var newPRD = this.dataInput;
                var currentPRD = this.modelPRD;
                var status = 0;
                currentPRD.forEach(prDetail => {
                    if(prDetail.material_id == newPRD.material_id && prDetail.wbs_id == newPRD.wbs_id){
                        status = 1;
                    }
                });

                newPRD = JSON.stringify(newPRD);
                if(status == 0){
                    var url = "{{ route('purchase_requisition.storePRD') }}";

                    window.axios.post(url,newPRD).then((response) => {
                        this.dataInput.material_id = "";
                        this.dataInput.quantity = "";
                        this.dataInput.wbs_id = "";

                        this.getPRD(this.dataInput.pr_id);

                        iziToast.success({
                            title: 'Success to add new item !',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again..',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        console.log(error);
                        $('div.overlay').hide();
                    })
                }else{
                    var url = "{{ route('purchase_requisition.updatePRD') }}";

                    window.axios.patch(url,newPRD).then((response) => {
                        this.dataInput.material_id = "";
                        this.dataInput.quantity = "";
                        this.dataInput.wbs_id = "";

                        this.getPRD(this.dataInput.pr_id);

                        iziToast.success({
                            title: 'Success to add new item !',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                    })
                    .catch((error) => {
                        iziToast.warning({
                            title: 'Please Try Again..',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        console.log(error);
                        $('div.overlay').hide();
                    })
                }
                
            },
            openEditModal(data,index){
                this.editInput.material_id = data.material_id;
                this.editInput.quantity = data.quantity;
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.index = index;
                this.editInput.pr_id = this.dataInput.pr_id
            },
            update(){
                var newPRD = JSON.stringify(this.editInput);
                var url = "{{ route('purchase_requisition.update') }}";

                window.axios.patch(url,newPRD).then((response) => {
                    this.editInput.material_id = "";
                    this.editInput.quantity = "";
                    this.editInput.wbs_id = "";

                    this.getPRD(this.dataInput.pr_id);

                    iziToast.success({
                        title: 'Success to add new item !',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    console.log(error);
                    $('div.overlay').hide();
                })
            },
            remove(prd_id){
                $('div.overlay').show();
                var url = "{{ route('purchase_requisition.destroyPRD') }}";
                window.axios.delete(url,{data:prd_id}).then((response) => {
                    console.log(response);
                    this.getPRD(this.dataInput.pr_id);

                    iziToast.success({
                        title: 'Success to remove item !',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                })
                .catch((error) => {
                    iziToast.warning({
                        title: 'Please Try Again..',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    console.log(error);
                    $('div.overlay').hide();
                })
            }
        },
        watch : {
            'dataInput.quantity': function(newValue){
                this.dataInput.quantity = (this.dataInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }, 
            'editInput.quantity': function(newValue){
                this.editInput.quantity = (this.editInput.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }, 
        },
        created: function() {
            this.newIndex = Object.keys(this.modelPRD).length+1; 
            this.dataInput.pr_id = this.modelPR.id;

            var data = this.modelPRD;
            data.forEach(prDetail => {
                prDetail.quantity = (prDetail.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        },
        updated: function() {
            this.newIndex = Object.keys(this.modelPRD).length+1; 
            this.dataInput.pr_id = this.modelPR.id;

            var data = this.modelPRD;
            data.forEach(prDetail => {
                prDetail.quantity = (prDetail.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        },
    });
</script>
@endpush
