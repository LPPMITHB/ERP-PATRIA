@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Service Detail',
        'items' => [
            'Dashboard' => route('index'),
            'View All Services' => route('service.index'),
            $service->name => route('service.show',$service->id),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="col-xs-12 col-lg-8 col-md-12 no-padding">
                    <div class="box-body no-padding">
                        <div class="col-sm-12 no-padding"><b>Service Information</b></div>
                        
                        <div class="col-md-2 col-xs-2 no-padding">Code</div>
                        <div class="col-md-10 col-xs-10 no-padding"><b>: {{$service->code}}</b></div>
                        
                        <div class="col-md-2 col-xs-2 no-padding">Name</div>
                        <div class="col-md-10 col-xs-10 no-padding"><b>: {{$service->name}}</b></div>

                        <div class="col-md-2 col-xs-2 no-padding">Ship Type</div>
                        <div class="col-md-10 col-xs-10 no-padding"><b>: {{ $service->ship_id != '' ? $service->ship->type : 'General' }}</b></div>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-4 col-md-12 no-padding ">
                        <a href="{{ route('service.createServiceDetail',$service->id) }}" class="btn btn-primary btn-sm pull-right">INPUT SERVICE DETAIL</a>
                </div>
            </div>
            @verbatim
                <div id="detail">
                    <div class="box-body p-t-0 p-b-0">
                        <table class="table table-bordered tableFixed tablePagingVue">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="25%">Name</th>
                                    <th width="25%">Description</th>
                                    <th width="20%">Cost Standard Price</th>
                                    <th width="10%">Unit of Measurement</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(sd, index) in modelSD">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ sd.name }}</td>
                                    <td>{{ sd.description }}</td>
                                    <td>{{ 'Rp'+ ' '+sd.cost_standard_price }}</td>
                                    <td>{{ sd.uom.name }}</td>
                                    <td><a href="#edit_info" class="btn btn-primary btn-xs pull-center" data-toggle="modal" @click="openEditModal(sd)">EDIT</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="edit_info">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <h4 class="modal-title">Edit Service Detail Information</h4>
                                </div>
                                <div class="modal-body p-t-0">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="name" class="control-label">Name</label>
                                            <input type="text" id="name" v-model="editInput.name" class="form-control">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="description" class="control-label">Description</label>
                                            <input type="text" id="description" v-model="editInput.description" class="form-control" placeholder="Please Input Description">
                                        </div>
                                        <div class="col-sm-12">
                                                <label for="uom" class="control-label">Unit Of Measurement</label>
                                                    <selectize id="uom" v-model="editInput.uom_id" :settings="uomSettings">
                                                        <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.name }}</option>
                                                    </selectize> 
                                        </div>
                                        <div class="col-sm-12">
                                                <label for="cost_standard_price" class="control-label">Cost Standard Price</label>
                                                <input type="text" id="cost_standard_price" v-model="editInput.cost_standard_price" class="form-control" placeholder="Please Input Cost Standard Price">
                                        </div>
                                    </div>
                                </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" @click.prevent="update" :disabled="editOk">SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endverbatim
        </div>
    </div>
</div>
@endsection

@push('script')
<script>

$(document).ready(function(){
        $('.tablePagingVue thead tr').clone(true).appendTo( '.tablePagingVue thead' );
        $('.tablePagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == ""){
                $(this).html( '<input disabled class="form-control width100" type="text"/>' );
            }else{
                $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
            }

            $( 'input', this ).on( 'keyup change', function () {
                if ( tablePagingVue.column(i).search() !== this.value ) {
                    tablePagingVue
                    .column(i)
                    .search( this.value )
                    .draw();
                }
            });
        });

        var tablePagingVue = $('.tablePagingVue').DataTable( {
            orderCellsTop   : true,
            fixedHeader     : true,
            paging          : true,
            autoWidth       : false,
            lengthChange    : false,
            info            : false,
        });

        $('div.overlay').hide();
    });

var data = {
        service_id : @json($service_id),
        modelSD : @json($modelSD),
        uoms : @json($uoms),
        data:{
            cost_standard_price : "",
        },
        editInput : {
            name : "",
            service_detail_id : "",
            description : "",
            uom_id : "",
            cost_standard_price : "",
        },
        uomSettings: {
            placeholder: 'Please Select UOM'
        },
        
    };

    var vm = new Vue({
    el : '#detail',
    data : data,
    computed :{
        editOk: function(){
            let isOk = false;
            if(this.editInput.name == "" || this.editInput.uom_id == "" || this.editInput.cost_standard_price == ""){
                isOk = true;
            }
            return isOk;
        }
    },
    methods : {
        getSD(){
            window.axios.get('/api/getNewServiceDetail/'+this.service_id).then(({ data }) => {
                data.forEach(datas => {
                    datas.cost_standard_price = (datas.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                });
                this.modelSD = data;
            })
            .catch((error) => {
                iziToast.warning({
                    displayMode: 'replace',
                    title: "Please try again.. "+error,
                    position: 'topRight',
                });
                $('div.overlay').hide();
            });
        },
        openEditModal(sd){
            this.editInput.name = sd.name;
            this.editInput.service_detail_id = sd.id;
            this.editInput.description = sd.description;
            this.editInput.uom_id = sd.uom_id;
            this.editInput.cost_standard_price = sd.cost_standard_price;
        },
        update(){
            this.editInput.cost_standard_price = parseInt((this.editInput.cost_standard_price+"").replace(/,/g , ''));
            let data = this.editInput;
            

            var url = "{{ route('service.updateDetail') }}";

            window.axios.put(url,data).then((response) => {
                if(response.data.error != undefined){
                    iziToast.warning({
                        displayMode: 'replace',
                        title: response.data.error,
                        position: 'topRight',
                    });
                    $('div.overlay').hide();            
                }else{
                    this.getSD();
                    iziToast.success({
                        displayMode: 'replace',
                        title: response.data.response,
                        position: 'topRight',
                    });
                }
                $('div.overlay').hide();
            })
            .catch((error) => {
                iziToast.warning({
                    displayMode: 'replace',
                    title: "Please try again.. "+error,
                    position: 'topRight',
                });
                $('div.overlay').hide();
            })

        }
    },
    watch:{
        'editInput.cost_standard_price' : function(newvalue){
                this.editInput.cost_standard_price = (this.editInput.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
        },
    },
    created:function(){
        this.modelSD.forEach(sd => {
            sd.cost_standard_price = (sd.cost_standard_price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");  
        });
    }
});
</script>
@endpush
