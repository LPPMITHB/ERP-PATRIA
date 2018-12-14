@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Edit Bill Of Service',
        'subtitle' => '',
        'items' => [
            'Dashboard' => route('index'),
            'Manage Bill Of Services' => route('bos.indexProject'),
            'Select Bill Of Service' => route('bos.indexBos', ['id' => $modelBOS->project_id]),
            'View Bill Of Service' => route('bos.show', ['id' => $modelBOS->id]),
            'Edit Bill Of Service' => route('bos.edit', ['id' => $modelBOS->id]),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <form class="form-horizontal" method="POST" action="{{ route('bos.update',['id'=>$modelBOS->id]) }}">
            <input type="hidden" name="_method" value="PATCH">
                @csrf
                <div class="box-header p-b-0">
                    <div class="col-xs-12 col-md-4">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>

                        <div class="col-xs-4 no-padding">Project Code</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOS->project->number}}</b></div>
                        
                        <div class="col-xs-4 no-padding">Project Name</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOS->project->name}}</b></div>

                        <div class="col-xs-4 no-padding">Ship Name</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOS->project->ship->type}}</b></div>

                        <div class="col-xs-4 no-padding">Ship Type</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOS->project->ship->type}}</b></div>

                        <div class="col-xs-4 no-padding">Customer</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOS->project->customer->name}}</b></div>
                    </div>

                    <div class="col-xs-12 col-md-4">
                        <div class="col-sm-12 no-padding"><b>WBS Information</b></div>
                    
                        <div class="col-xs-4 no-padding">Code</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOS->wbs->code}}</b></div>
                        
                        <div class="col-xs-4 no-padding">Name</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOS->wbs->name}}</b></div>

                        <div class="col-xs-4 no-padding">Description</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOS->wbs->description}}</b></div>

                        <div class="col-xs-4 no-padding">Deliverable</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOS->wbs->deliverables}}</b></div>

                        <div class="col-xs-4 no-padding">Progress</div>
                        <div class="col-xs-8 no-padding"><b>: {{$modelBOS->wbs->progress}}%</b></div>
                    </div>

                    <div class="col-xs-12 col-md-3 p-b-10">
                        <div class="col-sm-12 no-padding"><b>BOS Information</b></div>
                
                        <div class="col-md-5 col-xs-4 no-padding">Code</div>
                        <div class="col-md-7 col-xs-8 no-padding"><b>: {{$modelBOS->code}}</b></div>
                        
                        {{-- <div class="col-md-5 col-xs-4 no-padding">RAP Number</div>
                        <div class="col-md-7 col-xs-8 no-padding"><a href="{{ route('rap.show',$modelRAP->id) }}" class="text-primary"><b>: {{$rap_number}}</b></a></div>

                        @if(isset($modelPR))
                            <div class="col-md-5 col-xs-4 no-padding">PR Number</div>
                            <div class="col-md-7 col-xs-8 no-padding"><a href="{{ route('purchase_requisition.show',$modelPR->id) }}" class="text-primary"><b>: {{$pr_number}}</b></a></div>
                        @else
                            <div class="col-md-5 col-xs-4 no-padding">PR Number</div>
                            <div class="col-md-7 col-xs-8 no-padding"><b>: -</b></div>
                        @endif --}}
                    </div>
                </div> <!-- /.box-header -->
                <div class="box-body p-t-5">
                    @verbatim
                    <div id="bos">
                        <div class="col-xs-12 col-md-6">
                            <div class="col-md-3 col-xs-4 no-padding">BOS Description  <b>:</b></div>
                            <div class="col-md-9 col-xs-8 no-padding">
                                <textarea class="form-control" v-model="bos.description" style="width:100%"></textarea>  
                            </div>
                        </div>
                        <div class="col-md-12 p-t-0">
                            <table class="table table-bordered" id="services-table">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="30%">Service</th>
                                        <th width="38%">Description</th>
                                        <th width="7%">Cost Standard Price</th>
                                        <th width="10%" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(bosDetail, index) in serviceTable">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ bosDetail.service.code }} - {{ bosDetail.service.name }}</td>
                                        <td v-if="bosDetail.service.description != null">{{ bosDetail.service.description }}</td>
                                        <td v-else>{{ '-' }}</td>
                                        <td>{{ bosDetail.cost_standard_price }}</td>
                                        <td class="p-l-0" align="center">
                                            <a data-toggle="modal" data-target="#edit" class="btn btn-primary btn-xs" @click="getService(index)">
                                                <div class="btn-group">
                                                    EDIT
                                                </div>
                                            </a>
                                            <a class="btn btn-danger btn-xs" @click="">
                                                <div class="btn-group">
                                                    DELETE
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{newIndex}}</td>
                                        <td  class="no-padding">
                                            <selectize id="service" v-model="input.service_id" :settings="serviceSettings">
                                                <option v-for="(service, index) in services" :value="service.id">{{ service.code }} - {{ service.name }}</option>
                                            </selectize>    
                                        </td>
                                        <td class="no-padding"><input class="form-control width100" type="text" :value="input.description" disabled></td>
                                        <td class="no-padding"><input class="form-control width100" type="text" v-model="input.cost_standard_price"></td>
                                        <td class="p-l-0" align="center"><a @click.prevent="submitToTable()" :disabled="inputOk" class="btn btn-primary btn-xs" href="#">
                                            <div class="btn-group">
                                                ADD
                                            </div></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="modal fade" id="edit">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title">Edit Service</h4>
                                    </div>
                                    <div class="modal-body">
                                        <label for="service">Service Name</label>
                                        <input id="description" class="form-control" type="text" disabled v-model="modalData.service_name">

                                        <label class="p-t-10" for="description">Description</label>
                                        <input id="description" class="form-control" type="text" disabled v-model="modalData.description">

                                        <label class="p-t-15" for="cost_standard_price">Cost standard price</label>
                                        <input id="cost_standard_price" class="form-control" type="text" v-model="modalData.cost_standard_price">
                                    </div>
                                    <div class="modal-footer">
                                        <button @click.prevent="update" type="button" class="btn btn-primary" data-dismiss="modal">SAVE</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    </div>
                    @endverbatim
                </div>
            </form>
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
        $('.alert').addClass('animated bounce');
        $('#services-table').DataTable({
            'paging'      : false,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : false,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
        jQuery('.dataTable').wrap('<div class="dataTables_scroll" />');
    });

    var data = {
        bos : @json($modelBOS),
        project : @json($project),
        services : @json($services),
        wbs : @json($modelBOS->wbs),
        newIndex : 0, 
        submittedForm :{
            project_id : "",
            bos_code : "",
            description : ""
        },
        input : {
            service_id : "",
            service_name : "",
            description : "",
            cost_standard_price : "",
            cost_standard_priceInt : 0,
            bos_id : ""
        },
        serviceTable : @json($modelBOSDetail),
        serviceSettings: {
            placeholder: 'Please Select Service'
        },
        modalData : {
            bos_detail_id : "",
            service_id : "",
            description : "",
            cost_standard_price : "",
            cost_standard_priceInt : 0,
            service_name : "",
        },
        service_id:[],
    }

    var vm = new Vue({
        el : '#bos',
        data : data,
        computed:{
            inputOk: function(){
                let isOk = false;

                if(this.input.service_id == "" || this.input.service_name == "" || this.input.description == "" || this.input.cost_standard_price == ""){
                    isOk = true;
                }
                return isOk;
            },
            createOk: function(){
                let isOk = false;

                if(this.submittedForm.project_id == "" || this.submittedForm.bos_code == "" || this.submittedForm.description == "" || this.serviceTable.length < 1){
                    isOk = true;
                }
                return isOk;
            },
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
            updateDesc(newValue){
                var bos_id = this.bos.id;
                var data ={
                    desc : newValue,
                    bos_id : bos_id
                }
                data = JSON.stringify(data);
                var url = "{{ route('bos.updateDesc') }}";
                window.axios.patch(url,data).then((response) => {
                })
                .catch((error) => {
                    $('div.overlay').hide();
                })
            },
            update(){
                this.modalData.cost_standard_priceInt = (this.modalData.cost_standard_priceInt+"").replace(/,/g , '');
                this.modalData.cost_standard_priceInt = parseInt(this.modalData.cost_standard_priceInt);
                $('div.overlay').show();
                var data = this.modalData;
                data = JSON.stringify(data);
                var bos_id = this.bos.id;

                var url = "{{ route('bos.update') }}";
                console.log(url);

                window.axios.patch(url,data).then((response) => {
                    console.log(response);
                    iziToast.success({
                        title: 'Edit Success',
                        position: 'topRight',
                        displayMode: 'replace'
                    });
                    this.modalData.description = "";
                    this.modalData.bos_detail_id = "";
                    this.modalData.service_id = "";
                    this.modalData.cost_standard_price = "";
                    this.modalData.cost_standard_priceInt = 0;
                    this.modalData.service_name = "";
                    this.getBos(bos_id);
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
            getBos(bos_id){
                window.axios.get('/api/getBos/'+bos_id).then(({ data }) => {
                    this.serviceTable = data;
                    $('div.overlay').hide();
                    this.newIndex = this.serviceTable.length + 1;
                });
            },
            submitToTable(){
                this.input.cost_standard_priceInt = (this.input.cost_standard_priceInt+"").replace(/,/g , '');
                this.input.cost_standard_priceInt = parseInt(this.input.cost_standard_priceInt);

                if(this.input.service_id != "" && this.input.service_name != "" && this.input.description != "" && this.input.cost_standard_price != "" && this.input.cost_standard_priceInt > 0){
                    $('div.overlay').show();
                    var newService = this.input;
                    var bos_id = this.input.bos_id;
                    newService = JSON.stringify(newService);
                    var url = "{{ route('bos.storeBos') }}";

                    window.axios.post(url,newService).then((response) => {
                        iziToast.success({
                            title: 'Success Add Service',
                            position: 'topRight',
                            displayMode: 'replace'
                        });
                        this.service_id.push(this.input.service_id);         
                        var jsonServiceId = JSON.stringify(this.service_id);
                        this.getNewServices(jsonServiceId);

                        this.input.description = "";
                        this.input.service_id = "";
                        this.input.service_name = "";
                        this.input.cost_standard_price = "";
                        this.input.cost_standard_priceInt = 0;
                        this.serviceTable = [];
                        this.getBos(bos_id);
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
            getService: function(index) {
                var datas = this.serviceTable[index];
                this.modalData.bos_detail_id = datas.id;

                window.axios.get('/api/getBosDetail/'+this.modalData.bos_detail_id).then(({ data }) => {
                    this.modalData.service_id = data.service_id;
                    this.modalData.cost_standard_price = data.cost_standard_price;
                });
            }
        },
        watch: {
            'input.service_id': function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getService/'+newValue).then(({ data }) => {
                        if(data.description == "" || data.description == null){
                            this.input.description = '-';
                        }else{
                            this.input.description = data.description;

                        }
                        this.input.service_name = data.name;
                    });
                }else{
                    this.input.description = "";
                }
            },
            'input.cost_standard_price': function(newValue){
                this.input.cost_standard_priceInt = newValue;
                this.input.cost_standard_price = (this.input.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            },
            'modalData.cost_standard_price': function(newValue){
                this.modalData.cost_standard_priceInt = newValue;
                this.modalData.cost_standard_price = (this.modalData.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            },
            'bos.description' : function(newValue){
                this.updateDesc(newValue);
            },
            'modalData.service_id' : function(newValue){
                if(newValue != ""){
                    window.axios.get('/api/getServiceBOS/'+newValue).then(({ data }) => {
                        if(data.description == "" || data.description == null){
                            this.modalData.description = '-';
                        }else{
                            this.modalData.description = data.description;
                        }
                        console.log(data);
                        this.modalData.service_name = data.name;
                    });
                }
            },
            serviceTable: function(newValue) {
                newValue.forEach(bosDetail => {
                    bosDetail.cost_standard_price = (bosDetail.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
                });
            },
        },
        created: function() {
            this.submittedForm.project_id = this.bos.project_id;
            this.submittedForm.bos_code = this.bos_code;
            this.newIndex = this.serviceTable.length + 1;
            this.input.bos_id = this.bos.id;

            var data = this.serviceTable;
            data.forEach(bosDetail => {
                bosDetail.cost_standard_price = (bosDetail.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                this.service_id.push(bosDetail.service_id);         
            });
            var jsonServiceId = JSON.stringify(this.service_id);
            this.getNewServices(jsonServiceId);
        }
    });
       
</script>
@endpush
