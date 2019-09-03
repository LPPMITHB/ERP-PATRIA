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
                                    <div class="col-md-8 no-padding tdEllipsis" v-tooltip:top="(wbs.number)"><b>: {{wbs.number}}</b></div>
            
                                    <div class="col-md-4 no-padding">Description</div>
                                    <div v-if="wbs.description != ''" class="col-md-8 no-padding tdEllipsis" v-tooltip:top="(wbs.description)"><b>: {{wbs.description}}</b></div>
                                    <div v-else class="col-md-8 no-padding tdEllipsis" v-tooltip:top="(wbs.description)"><b>: -</b></div>
            
                                    <div class="col-md-4 no-padding">Deliverable</div>
                                    <div class="col-md-8 no-padding tdEllipsis" v-tooltip:top="(wbs.deliverables)"><b>: {{wbs.deliverables}}</b></div>
                                    
                                    <div class="col-sm-12 no-padding"><b>QC Type Information</b></div>

                                    <div class="col-md-4 no-padding">QC Type Code</div>
                                    <div class="col-md-8 no-padding tdEllipsis" v-tooltip:top="(qc_types.code)"><b>: {{qc_types.code}}</b></div>
                                    
                                    <div class="col-md-4 no-padding">QC Type Name</div>
                                    <div class="col-md-8 no-padding tdEllipsis" v-tooltip:top="(qc_types.name)"><b>: {{qc_types.name}}</b></div>

                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <label for="" >QC Type</label>
                                    <selectize v-model="qc_type_id" :settings="qcTypeSettings" >
                                        <option v-for="(qc_type, index) in qc_types" :value="qc_type.id">{{ qc_type.name }}</option>
                                    </selectize>
                                </div>
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


        qcTypeSettings: {
            placeholder: 'Please Select QC Type'
        },
    }

    Vue.directive('tooltip', function(el, binding){
        $(el).tooltip({
            title: binding.value,
            placement: binding.arg,
            trigger: 'hover'             
        })
    })

    console.log(data);
    var vm = new Vue({
        el : '#qc_task',
        data : data,
        computed : {
            dataOk: function(){
                let isOk = false;

                if(this.dataMaterial.length > 0){
                    isOk = true;
                }

                return isOk;
            },
        },
        watch : {
            'qc_type_id' : function(newValue){
                // this.dataInput.wbs_id = "";
                if(newValue != ""){
                    $('div.overlay').show();
                    window.axios.get('/api/getQcType/'+newValue).then(({ data }) => {
                        this.selectedQcType = "";
                        this.selectedQcType.forEach(data => {
                            var code = data.code;
                            var name = data.name;
                        });
                        this.wbss = data.wbss;
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