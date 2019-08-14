@extends('layouts.main')
@section('content-header')
@if($route == "/estimator")
    @if($cost_standard->id)
        @breadcrumb(
            [
                'title' => 'Edit Cost Standard',
                'items' => [
                    'Dashboard' => route('index'),
                    'View All Cost Standards' => route('estimator.indexEstimatorCostStandard'),
                    $cost_standard->name => route('estimator.showCostStandard',$cost_standard->id),
                    'Edit Cost Standard' => '',
                ]
            ]
        )
        @endbreadcrumb
    @else 
        @breadcrumb(
            [
                'title' => 'Create Cost Standard',
                'items' => [
                    'Dashboard' => route('index'),
                    'View All Cost Standards' => route('estimator.indexEstimatorCostStandard'),
                    'Create Cost Standard' => '',
                ]
            ]
        )
        @endbreadcrumb
    @endif
@elseif($route == "/estimator_repair")
    @if($cost_standard->id)
    @breadcrumb(
        [
            'title' => 'Edit Cost Standard',
            'items' => [
                'Dashboard' => route('index'),
                'View All Cost Standards' => route('estimator_repair.indexEstimatorCostStandard'),
                $cost_standard->name => route('estimator_repair.showCostStandard',$cost_standard->id),
                'Edit Cost Standard' => '',
            ]
        ]
    )
    @endbreadcrumb
    @else 
    @breadcrumb(
        [
            'title' => 'Create Cost Standard',
            'items' => [
                'Dashboard' => route('index'),
                'View All Cost Standards' => route('estimator_repair.indexEstimatorCostStandard'),
                'Create Cost Standard' => '',
            ]
        ]
    )
    @endbreadcrumb
    @endif
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                @if($route == "/estimator")
                    @if($cost_standard->id)
                        <form id="cost-standard" class="form-horizontal" method="POST" action="{{ route('estimator.updateCostStandard',['id'=>$cost_standard->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                    @else
                        <form id="cost-standard" class="form-horizontal" method="POST" action="{{ route('estimator.storeCostStandard') }}">
                    @endif
                @elseif($route == "/estimator_repair")
                    @if($cost_standard->id)
                        <form id="cost-standard" class="form-horizontal" method="POST" action="{{ route('estimator_repair.updateCostStandard',['id'=>$cost_standard->id]) }}">
                        <input type="hidden" name="_method" value="PATCH">
                    @else
                        <form id="cost-standard" class="form-horizontal" method="POST" action="{{ route('estimator_repair.storeCostStandard') }}">
                    @endif
                @endif
                @csrf
                    <div class="box-body">
                        @verbatim
                        <div id="cost_standard">
                            <div class="form-group">
                                <label for="code" class="col-sm-2 control-label">Code *</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="code" name="code" required v-model="submittedForm.code" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name *</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" required autofocus v-model="submittedForm.name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">Description</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="description" name="description" required autofocus v-model="submittedForm.description">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="uom" class="col-sm-2 control-label">Unit of Measurement *</label>

                                <div class="col-sm-10">
                                    <selectize id="uom" name="uom_id" v-model="submittedForm.uom_id" :settings="uom_settings">
                                        <option v-for="(uom, index) in modelUom" :value="uom.id">{{ uom.name }}</option>
                                    </selectize>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="value" class="col-sm-2 control-label">Value (Rp.) *</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="value" name="value" required autofocus v-model="submittedForm.value">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="wbs" class="col-sm-2 control-label">WBS Cost Estimation *</label>

                                <div class="col-sm-10">
                                    <selectize id="wbs" name="wbs_id" v-model="submittedForm.wbs_id" :settings="wbs_settings">
                                        <option v-for="(wbs, index) in modelWbs" :value="wbs.id">{{ wbs.name }}</option>
                                    </selectize>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">Status *</label>

                                <div class="col-sm-10">
                                    <select class="form-control" id="status" name="status" v-model="submittedForm.status">
                                        <option value="1">Active</option>
                                        <option value="0">Non Active</option>
                                    </select>
                                </div>
                            </div>

                            <div class="box-footer p-r-0">
                                <template v-if="costStandard.length != undefined">
                                    <button :disabled="createOk" @click.prevent="submitForm" type="button" class="btn btn-primary pull-right">CREATE</button>
                                </template>
                                <template v-else-if="costStandard.length == undefined">
                                    <button :disabled="createOk" @click.prevent="submitForm" type="button" class="btn btn-primary pull-right">SAVE</button>
                                </template>
                            </div>
                        </div>
                        @endverbatim
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const form = document.querySelector('form#cost-standard');

    $(document).ready(function(){
        $('div.overlay').hide();
    })

    var data = {
        modelUom : @json($modelUom),
        modelWbs : @json($modelWbs),
        costStandard : @json($cost_standard),
        submittedForm : {
            code : "",
            name : "",
            description : "",
            wbs_id : "",
            status : "",
            uom_id : "",
            value : "",
        },
        wbs_settings: {
            placeholder: 'Please Select WBS Cost Estimation'
        },
        uom_settings: {
            placeholder: 'Please Select UOM'
        },
        oldData : {
            code : @json(Request::old('code')),
            name : @json(Request::old('name')),
            description : @json(Request::old('description')),
            wbs_id : @json(Request::old('wbs_id')),
            status : @json(Request::old('status')),
            uom_id : @json(Request::old('uom_id')),
            value : @json(Request::old('value')),
        }
    }

    var vm = new Vue({
        el : '#cost_standard',
        data : data,
        computed : {
            createOk :function(){
                let isOk = false;
                    if(this.submittedForm.code == "" || this.submittedForm.name == "" || this.submittedForm.wbs_id == "" || this.submittedForm.status == "" || this.submittedForm.uom_id == "" || this.submittedForm.value == ""){
                        isOk = true;
                    }
                return isOk;
            }
        },
        methods : {
            submitForm(){
                $('div.overlay').show();
                this.submittedForm.value = (this.submittedForm.value+"").replace(/,/g , '');

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.submittedForm));
                form.appendChild(struturesElem);
                form.submit();
            },
        },
        watch:{
            'submittedForm.value': function(newValue) {
                    if(newValue != ""){
                        this.submittedForm.value = (this.submittedForm.value+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                },
        },
        created: function(){
            if(this.costStandard.length != undefined){
                this.submittedForm.status = 1;
                this.submittedForm.code = @json($cost_standard_code);

                // Jika terjadi error dan redirect ke halaman create, setiap data yang sudah terisi tidak akan hilang semua
                if(this.oldData.code != null) {
                    this.submittedForm.code = this.oldData.code;
                }
                if(this.oldData.name != null) {
                    this.submittedForm.name = this.oldData.name;
                }
                if(this.oldData.description != null) {
                    this.submittedForm.description = this.oldData.description;
                }
                if(this.oldData.wbs_id != null) {
                    this.submittedForm.wbs_id = this.oldData.wbs_id;
                }
                if(this.oldData.status != null) {
                    this.submittedForm.status = this.oldData.status;
                }
                if(this.oldData.uom_id != null) {
                    this.submittedForm.uom_id = this.oldData.uom_id;
                }
                if(this.oldData.value != null) {
                    this.submittedForm.value = (this.oldData.value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            }else{
                this.submittedForm.code = this.costStandard.code;
                this.submittedForm.name = this.costStandard.name;
                this.submittedForm.description = this.costStandard.description;
                this.submittedForm.wbs_id = this.costStandard.estimator_wbs_id;
                this.submittedForm.status = this.costStandard.status;
                this.submittedForm.uom_id = this.costStandard.uom_id;
                this.submittedForm.value = (this.costStandard.value+"").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        }
    })

</script>
@endpush