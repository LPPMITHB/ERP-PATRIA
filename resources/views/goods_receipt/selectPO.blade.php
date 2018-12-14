@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Create Goods Receipt » Create Details',
        'items' => [
            'Dashboard' => route('index'),
            'Select Purchase Order' => route('goods_receipt.createGrWithRef'),
            'Details' => route('goods_receipt.selectPO',$modelPO->id),
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
                <form id="create-gr" class="form-horizontal" method="POST" action="{{ route('goods_receipt.store') }}">
                @csrf
                    @verbatim
                    <div id="pod">
                        <div class="box_header">
                            <div class="col-sm-12">
                                <div class="col-sm-6 p-l-0">
                                    <div class="row">
                                        <div class="col-sm-3 p-l-0 p-r-0">
                                            PO Number
                                        </div>
                                        <div class="col-sm-3 p-l-0 p-r-0">
                                            : <b> {{ modelPO.number }}</b>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 p-l-0 p-r-0">
                                            Vendor
                                        </div>
                                        <div class="col-sm-3 p-l-0 p-r-0">
                                            : <b> {{ modelPO.vendor.name }} </b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" >
                                        GR Description  :
                                </div>
                                <div class="col-sm-4 p-l-0">
                                    <textarea class="form-control" rows="3" v-model="description" style="width:376px"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="row">
                                <table class="table table-bordered table-hover" id="pod-table">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="35%">Material</th>
                                            <th width="15%">Quantity</th>
                                            <th width="15%">Received</th>
                                            <th width="30%">Storage Location</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(POD,index) in modelPOD" v-if="POD.quantity > 0">
                                            <td>{{ index+1 }}</td>
                                            <td>{{ POD.material.code }} - {{ POD.material.name }}</td>
                                            <td>{{ POD.quantity }}</td>
                                            <td class="tdEllipsis no-padding">
                                                <input class="form-control width100" v-model="POD.received" placeholder="Please Input Received Quantity">
                                            </td>
                                            <td class="no-padding">
                                                <selectize v-model="POD.sloc_id" :settings="slocSettings">
                                                    <option v-for="(storageLocation, index) in modelSloc" :value="storageLocation.id">{{storageLocation.code}} - {{storageLocation.name}}</option>
                                                </selectize>  
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 p-t-10">
                                <button @click.prevent="submitForm" class="btn btn-primary pull-right" :disabled="createOk">CREATE</button>
                            </div>
                        </div>

                    </div>
                    @endverbatim
                </form>
        </div><!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    const form = document.querySelector('form#create-gr');

    $(document).ready(function(){
        $('#pod-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').remove();
            }
        });
    });

    var data = {
        modelPOD : @json($modelPODs),
        modelPO :   @json($modelPO),
        modelSloc : @json($modelSloc),

        slocSettings: {
            placeholder: 'Please Select Storage Location'
        },
        description:"",
        submittedForm :{},
    }

    var vm = new Vue({
        el : '#pod',
        data : data,
        computed : {
            createOk: function(){
                let isOk = false;
                
                return isOk;
            },
        },
        methods : {
            submitForm(){
                var data = this.modelPOD;
                data = JSON.stringify(data)
                data = JSON.parse(data)

                data.forEach(POD => {
                    POD.quantity = POD.quantity.replace(/,/g , ''); 
                    POD.received = parseInt(POD.received);     
                });

                this.submittedForm.POD = data;
                this.submittedForm.po_id = this.modelPO.id;
                this.submittedForm.description = this.description;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        watch : {
            modelPOD:{
                handler: function(newValue) {
                    var data = newValue;
                    data.forEach(POD => {
                        if(parseInt(POD.quantity.replace(/,/g , '')) < parseInt(POD.received.replace(/,/g , ''))){
                            POD.received = POD.quantity;
                            iziToast.warning({
                                title: 'Cannot input more than avaiable quantity..',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                        }
                        POD.received = (POD.received+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
                    });
                },
                deep: true
            },
        },
        created: function(){
            var data = this.modelPOD;
            data.forEach(POD => {
                POD['sloc_id'] = null;
                POD.received = parseInt(POD.quantity) - parseInt(POD.received);
                POD.quantity = POD.received;
                POD.quantity = (POD.quantity+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
                POD.received = (POD.received+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        }
    });
</script>
@endpush
