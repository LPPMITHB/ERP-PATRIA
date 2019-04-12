@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Edit Service',
        'subtitle' => 'Edit',
        'items' => [
            'Dashboard' => route('index'),
            'View All Services' => route('service.index'),
            'Edit Service' => route('service.edit',$service->id),
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
                <form id="service" class="form-horizontal" method="POST" action="{{ route('service.update',['id'=>$service->id]) }}">
                @csrf
                    <input type="hidden" name="_method" value="PATCH"> 
                @verbatim
                    <div id="service">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="code" class="col-sm-2 control-label">Code</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"  required v-model="dataInput.code" disabled>
                                </div>
                            </div>
    
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" required autofocus v-model="dataInput.name">
                                </div>
                            </div>

                            <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Ship Type</label>
                                    <div class="col-sm-10">
                                        <selectize id="ship" v-model="dataInput.ship_id" :settings="shipTypeSettings">
                                            <option v-for="(ship, index) in ships" :value="ship.id">{{ ship.type }}</option>
                                        </selectize>
                                    </div>
                                </div>
                            </div>
                        <div class="box-footer">
                            <button @click.prevent="submitForm" :disabled="dataOk" type="submit" class="btn btn-primary pull-right">SAVE</button>
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
    const form = document.querySelector('form#service');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        service : @json($service),
        ships : @json($ships),
        dataInput : {
            code : @json($service->code),
            name : @json($service->name),
            ship_id : @json($service->ship_id),
        },
        shipTypeSettings: {
            placeholder: 'Please Select Ship Type',
        },
    }

    var vm = new Vue({
        el : '#service',
        data : data,
        computed : {
            dataOk: function(){
                let isOk = false;
                
                if(this.dataInput.name == "" || this.dataInput.type ==""){
                    isOk = true;
                }
                return isOk;
            },
        },
        methods: {
            submitForm(){
                $('div.overlay').show();

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.dataInput));
                
                form.appendChild(struturesElem);
                document.body.appendChild(form);
                form.submit();
            }
        },
    });
</script>
@endpush
