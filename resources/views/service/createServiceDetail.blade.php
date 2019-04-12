@extends('layouts.main')
@section('content-header')

    @breadcrumb(
        [
            'title' => 'Create Service Detail',
            'items' => [
                'Dashboard' => route('index'),
                'View All Services' => route('service.index'),
                $service->name => route('service.show',$service->id),
                'Create Service Detail' => '',
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
                    <form id="service" class="form-horizontal" method="POST" action="{{ route('service.storeServiceDetail') }}">
                @csrf
                @verbatim
                    <div id="service">
                        <div class="box-body">
                            <div class="col-sm-12">
                                <label for="name" class="control-label">Name</label>
                                <input type="text" id="name" v-model="dataInput.name" class="form-control" placeholder="Please Input Service Detail Name">
                            </div>
                            <div class="col-sm-12">
                                <label for="description" class="control-label">Description</label>
                                <input type="text" id="description" v-model="dataInput.description" class="form-control" placeholder="Please Input Description">
                            </div>
                            <div class="col-sm-12">
                                <label for="uom" class="control-label">Unit Of Measurement</label>
                                    <selectize name="uom_id" id="uom" v-model="dataInput.uom_id" placeholder="Please Select Unit of Measurement">
                                        <option v-for="(uom, index) in uoms" :value="uom.id">{{ uom.unit }}</option>
                                    </selectize> 
                            </div>
                            <div class="col-sm-12">
                                <label for="cost_standard_price" class="control-label">Cost Standard Price (Rp.)</label>
                                <input type="text" id="cost_standard_price" v-model="dataInput.cost_standard_price" class="form-control" placeholder="Please Input Cost Standard Price">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button @click.prevent="submitForm" :disabled="dataOk" type="submit" class="btn btn-primary pull-right">CREATE</button>
                        </div>
                    </div>
                @endverbatim
                </form>
            </div> <!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    const form = document.querySelector('form#service');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        uoms : @json($uoms),
        service : @json($service),
        oldData : {
            name : @json(Request::old('name')),
            description : @json(Request::old('description')),
            uom_id : @json(Request::old('uom_id')),
            cost_standard_price : @json(Request::old('cost_standard_price')),
        },
        dataInput : {
            name : "",
            description : "",
            service_id : @json($service->id),
            uom_id : "",
            cost_standard_price : "",
        },
    }

    var vm = new Vue({
        el : '#service',
        data : data,
        computed : {
            dataOk: function(){
                let isOk = false;
                
                if(this.dataInput.name == "" || this.dataInput.uom_id =="" || this.dataInput.cost_standard_price ==""){
                    isOk = true;
                }
                return isOk;
            },
        },
        methods : {
            submitForm(){
                $('div.overlay').show();
                this.dataInput.cost_standard_price = this.dataInput.cost_standard_price.replace(/,/g , '');
                    let struturesElem = document.createElement('input');
                    struturesElem.setAttribute('type', 'hidden');
                    struturesElem.setAttribute('name', 'datas');
                    struturesElem.setAttribute('value', JSON.stringify(this.dataInput));
                    form.appendChild(struturesElem);
                    $(document.body).append(form)
                    form.submit();
                    $('div.overlay').hide();
            },
        },
        watch :{
            'dataInput.cost_standard_price': function(newValue) {
                var decimal = newValue.replace(/,/g, '').split('.');
                if(decimal[1] != undefined){
                    var maxDecimal = 2;
                    if((decimal[1]+"").length > maxDecimal){
                        this.dataInput.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").substring(0,maxDecimal).replace(/\D/g, "");
                    }else{
                        this.dataInput.cost_standard_price = (decimal[0]+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"."+(decimal[1]+"").replace(/\D/g, "");
                    }
                }else{
                    this.dataInput.cost_standard_price = (newValue+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            },
        }
    });
</script>
@endpush
