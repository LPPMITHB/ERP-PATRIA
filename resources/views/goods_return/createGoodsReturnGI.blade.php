@extends('layouts.main')

@section('content-header')
@if($route == "/goods_return")
    @breadcrumb(
        [
            'title' => 'Create Goods Return',
            'items' => [
                'Dashboard' => route('index'),
                'Select Goods Issue' => route('goods_return.selectGI'),
                'Details' => '',
            ]
        ]
    )
    @endbreadcrumb
@elseif($route == "/goods_return_repair")
    @breadcrumb(
        [
            'title' => 'Create Goods Return',
            'items' => [
                'Dashboard' => route('index'),
                'Select Goods Issue' => route('goods_return_repair.selectGI'),
                'Details' => '',
            ]
        ]
    )
    @endbreadcrumb
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">
                @if($route == "/goods_return")
                    <form id="create-gi" class="form-horizontal" method="POST" action="{{ route('goods_return.storeGI') }}">
                @elseif($route == "/goods_return_repair")
                    <form id="create-gi" class="form-horizontal" method="POST" action="{{ route('goods_return_repair.storeGI') }}">
                @endif
                @csrf
                    @verbatim
                    <div id="gid">
                        <div class="col-sm-12 no-padding">
                            <div class="box-header p-t-0">
                                <div class="col-xs-12 col-lg-6 col-md-12 no-padding">
                                    <div class="box-body no-padding">
                                        <div class="col-md-4 col-xs-4 no-padding">GI Number</div>
                                        <div class="col-md-8 col-xs-8 no-padding"><b>: @endverbatim<a href= "{{ route('goods_issue.show', ['id'=>$modelGI->id]) }}" class="text-primary">@verbatim{{ modelGI.number }}</a></b></div>

                                        <div class="col-md-4 col-xs-4 no-padding">MR Number</div>
                                        <div class="col-md-8 col-xs-8 no-padding"><b>: @endverbatim<a href= "{{ route('material_requisition.show', ['id'=>$modelGI->materialRequisition->id]) }}" class="text-primary">@verbatim{{ modelGI.material_requisition.number }}</a></b></div>

                                        <div class="col-md-4 col-xs-4 no-padding">Project</div>
                                        <div class="col-md-8 col-xs-8 no-padding"><b>: {{ modelGI.material_requisition.project.number }}</b></div>

                                        <div class="col-md-4 col-xs-4 no-padding">GI Description</div>
                                        <div class="col-md-8 col-xs-8 no-padding tdEllipsis" data-container="body" data-toogle="tooltip" :title="tooltipText(modelGI.description)"><b>: {{ modelGI.description }}</b></div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-lg-4 col-md-12 no-padding">
                                    <div class="box-body no-padding">
                                        <div class="col-md-8 col-lg-7 col-xs-12 no-padding">Goods Return Description : <textarea class="form-control" rows="3" v-model="description" style="width:310px"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <table class="table table-bordered tableFixed">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="20%">Material Number</th>
                                                <th width="30%">Material Description</th>
                                                <th width="10%">Material Quantity</th>
                                                <th width="10%">Return Quantity</th>
                                                <th width="5%">Unit</th>
                                                <th width="15%">Storage Location</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(GID,index) in modelGID">
                                                <td>{{ index+1 }}</td>
                                                <td class="tdEllipsis">{{ GID.material.code }}</td>
                                                <td class="tdEllipsis">{{ GID.material.description }}</td>
                                                <td class="tdEllipsis">{{ GID.available }} </td>
                                                <td class="tdEllipsis no-padding">
                                                    <input class="form-control width100" v-model="GID.returned_temp" placeholder="Please Input Returned Quantity">
                                                </td>
                                                <td class="tdEllipsis">{{ GID.material.uom.unit }}</td>
                                                <td class="no-padding">
                                                    <selectize v-model="GID.sloc_id" :settings="slocSettings" :disabled="returnOk(GID)" :id="giveId(GID.id)">
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
    const form = document.querySelector('form#create-gi');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        modelGID : @json($modelGID),
        modelGI :   @json($modelGI),
        description:"",
        submittedForm :{},
        slocSettings: {
            placeholder: 'Please Select Storage Location'
        },
        modelSloc : @json($modelSloc),
    }

    var vm = new Vue({
        el : '#gid',
        data : data,
        computed : {
            createOk: function(){
                let isOk = true;
                this.modelGID.forEach(GID => {
                    if((GID.returned_temp+"").replace(/,/g , '') > 0){
                        if(GID.sloc_id != ""){
                            isOk = false;
                        }
                    }
                });
                return isOk;
            },
        },
        methods : {
            giveId(id){
                return id;
            },
            returnOk(GID){
                if((GID.returned_temp+"").replace(/,/g , '') > 0){
                    return false;
                }else{
                    GID.sloc_id = "";
                    return true;
                }
            },
            tooltipText($text){
                return $text;
            },
            // changeText(){
            //     if(document.getElementsByClassName('tooltip-inner')[0]!= undefined){
            //         if(document.getElementsByClassName('tooltip-inner')[0].innerHTML != modelGR.vendor.address ){
            //             document.getElementsByClassName('tooltip-inner')[0].innerHTML= modelGR.vendor.address;
            //         }
            //     }
            // },

            submitForm(){
                $('div.overlay').show();
                var data = this.modelGID;
                data = JSON.stringify(data)
                data = JSON.parse(data)

                data.forEach(GID => {
                    GID.returned_temp = GID.returned_temp.replace(/,/g , '');
                });
                this.submittedForm.GID = data;
                this.submittedForm.goods_issue_id = this.modelGI.id;
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
            modelGID:{
                handler: function(newValue) {
                    this.modelGID.forEach(GID => {
                        if((parseFloat((GID.quantity+"").replace(/,/g , '')) - parseFloat((GID.returned+"").replace(/,/g , ''))) < parseFloat((GID.returned_temp+"").replace(/,/g , ''))){
                            GID.returned_temp = GID.quantity;
                            iziToast.warning({
                                title: 'Cannot input more than available quantity..',
                                position: 'topRight',
                                displayMode: 'replace'
                            });
                        }

                        var is_decimal = GID.is_decimal;
                        if(is_decimal == 0){
                            GID.returned_temp = (GID.returned_temp+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }else{
                            var decimal = (GID.returned_temp+"").replace(/,/g, '').split('.');
                            if(decimal[1] != undefined){
                                var maxDecimal = 2;
                                if((decimal[1]+"").length > maxDecimal){
                                    GID.returned_temp = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                                }else{
                                    GID.returned_temp = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                                }
                            }else{
                                GID.returned_temp = (GID.returned_temp+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            }
                        }
                    });
                },
                deep: true
            },
        },
        created: function(){
            this.modelGID.forEach(GID => {
                var is_decimal = GID.is_decimal;
                if(is_decimal == 0){
                    GID.available = (GID.available+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }else{
                    var decimal = (GID.available+"").replace(/,/g, '').split('.');
                    if(decimal[1] != undefined){
                        var maxDecimal = 2;
                        if((decimal[1]+"").length > maxDecimal){
                            GID.available = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                        }else{
                            GID.available = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                        }
                    }else{
                        GID.available = (GID.available+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                }
            });
        },
    });
</script>
@endpush
