@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Manage Bill Of Service',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('bos.indexProject'),
            'Select WBS' => route('bos.selectWBS',$project->id),
            'Manage Bill Of Service' => '',
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body no-padding p-b-10">
                <form id="create-bos" class="form-horizontal" method="POST" action="{{ route('bos.store') }}">
                @csrf
                    @verbatim
                    <div id="bos">
                        <div class="box-header">
                            <div class="col-sm-4">
                                <table>
                                    <thead>
                                        <th colspan="2">Project Information</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="p-r-40">Project Code</td>
                                            <td class="p-r-5">:</td>
                                            <td><b>{{project.code}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Project Name</td>
                                            <td>:</td>
                                            <td><b>{{project.name}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Ship Name</td>
                                            <td>:</td>
                                            <td><b>{{project.ship.name}}</b></td>
    
                                            
                                        </tr>
                                        <tr>
                                            <td>Ship Type</td>
                                            <td>:</td>
                                            <td><b>{{project.ship.type}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Customer</td>
                                            <td>:</td>
                                            <td><b>{{project.customer.name}}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-4">
                                <table>
                                    <thead>
                                        <th colspan="2">WBS Information</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Code</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{wbs.code}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{wbs.name}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Description</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{wbs.description}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Deliverable</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{wbs.deliverables}}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Progress</td>
                                            <td>:</td>
                                            <td>&ensp;<b>{{wbs.progress}}%</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-4">
                                <td rowspan="2">BOS Description</td>
                                <td rowspan="2">:</td>
                                <td rowspan="2">
                                    <textarea class="form-control" rows="3" v-model="submittedForm.description" style="width:326px"></textarea>  
                                </td>
                            </div>
                            
                        </div> <!-- /.box-header -->
                        <div class="col-md-12 p-t-20">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="28%">Service</th>
                                        <th width="38%">Description</th>
                                        <th width="19%">Cost Standard Price</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(service, index) in serviceTable">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ service.service_name }}</td>
                                        <td>{{ service.description }}</td>
                                        <td>{{ service.cost_standard_price }}</td>
                                        <td class="p-l-5" align="center">
                                            <a class="btn btn-primary btn-xs" data-toggle="modal" href="#edit_item" @click="openEditModal(service,index)">
                                                EDIT
                                            </a>
                                            <a href="#" @click="removeRow(service.service_id)" class="btn btn-danger btn-xs">
                                                <div class="btn-group">DELETE</div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{newIndex}}</td>
                                        <td class="no-padding">
                                            <selectize id="service" v-model="input.service_id" :settings="serviceSettings">
                                                <option v-for="(service, index) in services" :value="service.id">{{ service.name }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding"><input class="form-control" type="text" :value="input.description" disabled></td>
                                        <td class="no-padding"><input class="form-control" type="text" v-model="input.cost_standard_price"></td>
                                        <td class="p-l-0" align="center"><a @click.prevent="submitToTable()" :disabled="inputOk" class="btn btn-primary btn-xs" href="#">
                                            <div class="btn-group">
                                                ADD
                                            </div></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <button id="process" @click.prevent="submitForm()" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                        </div>
                        <div class="modal fade" id="edit_item">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Edit Service</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="type" class="control-label">Service</label>
                                                <selectize id="edit_modal" v-model="editInput.service_id" :settings="serviceSettings">
                                                    <option v-for="(service, index) in services_modal" :value="service.id">{{ service.code }} - {{ service.name }}</option>
                                                </selectize>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="cost_standard_price" class="control-label">Cost standard price</label>
                                                <input type="text" id="cost_standard_price" v-model="editInput.cost_standard_price" class="form-control" placeholder="Please Input Cost standard price">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" :disabled="updateOk" data-dismiss="modal" @click.prevent="update(editInput.old_service_id, editInput.service_id)">SAVE</button>
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
    const form = document.querySelector('form#create-bos');

    $(document).ready(function(){
        $('div.overlay').hide();
        $('.alert').addClass('animated bounce');
        
    });

    var data = {
        submit: "ok",
        project : @json($project),
        services : @json($services),
        wbs : @json($wbs),
        newIndex : 0, 
        submittedForm :{
            project_id : "",
            wbs_id : "",
            description : ""
        },
        input : {
            service_id : "",
            service_name : "",
            service_code : "",
            description : "",
            cost_standard_price : "",
            cost_standard_priceInt : 0
        },
        editInput : {
            old_service_id : "",
            service_id : "",
            service_code : "",
            service_name : "",
            cost_standard_price : "",
            cost_standard_priceInt : 0,
        },
        serviceTable : [],
        serviceSettings: {
            placeholder: 'Please Select service'
        },
        service_id:[],
        service_id_modal:[],
        services_modal :[],
    }

    var vm = new Vue({
        el : '#bos',
        data : data,
        computed:{
            inputOk: function(){
                let isOk = false;

                var string_newValue = this.input.cost_standard_priceInt+"";
                this.input.cost_standard_priceInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.input.service_id == "" || this.input.service_name == "" || this.input.description == "" || this.input.cost_standard_price == "" || this.input.cost_standard_priceInt < 1){
                    isOk = true;
                }
                return isOk;
            },
            createOk: function(){
                let isOk = false;

                if(this.serviceTable.length < 1 || this.submit == ""){
                    isOk = true;
                }
                return isOk;
            },
            updateOk: function(){
                let isOk = false;

                var string_newValue = this.editInput.cost_standard_priceInt+"";
                this.editInput.cost_standard_priceInt = parseInt(string_newValue.replace(/,/g , ''));

                if(this.editInput.service_id == "" || this.editInput.cost_standard_priceInt < 1 || this.editInput.cost_standard_priceInt == "" || isNaN(this.editInput.cost_standard_priceInt)){
                    isOk = true;
                }

                return isOk;
            }
        },
        methods: {
            getNewServices(jsonServiceId){
                window.axios.get('/api/getServicesBOS/'+jsonServiceId).then(({ data }) => {
                    this.services = data;
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
            getNewModalServices(jsonServiceId){
                window.axios.get('/api/getServicesBOS/'+jsonServiceId).then(({ data }) => {
                    this.services_modal = data;
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
            openEditModal(data,index){
                this.editInput.service_id = data.service_id;
                this.editInput.old_service_id = data.service_id;
                this.editInput.service_code = data.service_code;
                this.editInput.service_name = data.service_name;
                this.editInput.cost_standard_price = data.cost_standard_price;
                this.editInput.cost_standard_priceInt = data.cost_standard_priceInt;
                this.editInput.wbs_id = data.wbs_id;
                this.editInput.wbs_name = data.wbs_name;
                this.editInput.index = index;

                var service_id = JSON.stringify(this.service_id);
                service_id = JSON.parse(service_id);
                
                this.service_id_modal = service_id;
                this.service_id_modal.forEach(id => {
                    if(id == data.service_id){
                        var index = this.service_id_modal.indexOf(id);
                        this.service_id_modal.splice(index, 1);
                    }
                });
                var jsonServiceId = JSON.stringify(this.service_id_modal);
                this.getNewModalServices(jsonServiceId);
            },
            submitForm(){
                this.submit = "";
                this.submittedForm.services = this.serviceTable;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
            submitToTable(){
                if(this.input.service_id != "" && this.input.service_name != "" && this.input.description != "" && this.input.cost_standard_price != "" && this.input.cost_standard_priceInt > 0){
                    var data = JSON.stringify(this.input);
                    data = JSON.parse(data);
                    this.serviceTable.push(data);

                    this.service_id.push(data.service_id); //ini buat nambahin service_id terpilih

                    var jsonServiceId = JSON.stringify(this.service_id);
                    this.getNewServices(jsonServiceId);             

                    this.newIndex = this.serviceTable.length + 1;  

                    this.input.description = "";
                    this.input.service_id = "";
                    this.input.service_name = "";
                    this.input.cost_standard_price = "";
                    this.input.cost_standard_priceInt = 0;
                }
            },
            removeRow: function(serviceId) {
                var index_serviceId = "";
                var index_serviceTable = "";

                this.service_id.forEach(id => {
                    if(id == serviceId){
                        index_serviceId = this.service_id.indexOf(id);
                    }
                });
                this.serviceTable.forEach(data => {
                    if(data.service_id == serviceId){
                        index_serviceTable = this.serviceTable.indexOf(data.service_id);
                    }
                });

                this.serviceTable.splice(index_serviceTable, 1);
                this.service_id.splice(index_serviceId, 1);
                this.newIndex = this.serviceTable.length + 1;

                var jsonServiceId = JSON.stringify(this.service_id);
                this.getNewServices(jsonServiceId);
            },
            update(old_service_id, new_service_id){
                this.serviceTable.forEach(service => {
                    if(service.service_id == old_service_id){
                        var service = this.serviceTable[this.editInput.index];
                        service.cost_standard_priceInt = this.editInput.cost_standard_priceInt;
                        service.cost_standard_price = this.editInput.cost_standard_price;
                        service.service_id = new_service_id;
                        service.wbs_id = this.editInput.wbs_id;

                        window.axios.get('/api/getServiceBOS/'+new_service_id).then(({ data }) => {
                            service.service_name = data.name;
                            service.service_code = data.code;

                            this.service_id.forEach(id => {
                                if(id == old_service_id){
                                    var index = this.service_id.indexOf(id);
                                    this.service_id.splice(index, 1);
                                }
                            });
                            this.service_id.push(new_service_id);

                            var jsonServiceId = JSON.stringify(this.service_id);
                            this.getNewServices(jsonServiceId);

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
                    }
                });
            },
        },
        watch: {
            'input.service_id': function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getServiceBOS/'+newValue).then(({ data }) => {
                        if(data.description == "" || data.description == null){
                            this.input.description = '-';
                        }else{
                            this.input.description = data.description;
                            this.input.cost_standard_price = data.cost_standard_price;

                        }
                        this.input.service_name = data.name;
                        this.input.service_code = data.code;
                    });
                }
            },
            'input.cost_standard_price': function(newValue){
                this.input.cost_standard_priceInt = newValue;
                this.input.cost_standard_price = (this.input.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
            }
        },
        created: function() {
            this.submittedForm.project_id = this.project.id;
            this.submittedForm.wbs_id = this.wbs.id;          

            this.newIndex = this.serviceTable.length + 1;
        }
    });
       
</script>
@endpush
