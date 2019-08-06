@extends('layouts.main')

@push('style')

@endpush

@section('content-header')
@breadcrumb(
    [
        'title' => 'Approval Configuration',
        'items' => [
            'Dashboard' => route('index'),
            'Approval Configuration' => '',
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
                <form id="approval" class="form-horizontal" method="POST" action="{{ route('approval.save') }}">
                @csrf
                    @verbatim
                    <div id="approval">
                        <div class="box-body no-padding">
                            <div class="col-md-12 p-l-0 p-r-0">
                                <div class="box-group" id="accordion">

                                    <div class="panel box box-primary">
                                        <div class="box-header with-border">
                                            <h4 class="box-title pull-right">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#purchase_requisition">
                                                    PURCHASE REQUISITION
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="purchase_requisition" class="panel-collapse collapse">
                                            <div class="box-body no-padding">
                                                <div class="col-sm-1">
                                                    <h4>Select Type:</h4>
                                                </div>
                                                <div class="col-sm-3">
                                                    <template v-for="(type,index) in types">
                                                        <input type="radio" :value="type" v-model="selectedTypePR">
                                                        <label>{{ type }}</label>
                                                        <br>
                                                    </template>
                                                </div>
                                                <div class="col-sm-8">
                                                    <template v-if="selectedTypePR == '1 Stage'">
                                                        <table class="table table-bordered tableFixed m-t-5">
                                                            <thead>
                                                                <tr>
                                                                    <th width="5%">No</th>
                                                                    <th width="30%">Minimum</th>
                                                                    <th width="30%">Maximum</th>
                                                                    <th width="25%">Role</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td class="no-padding">
                                                                        <input class="form-control" type="text" v-model="dataInput.minimum" placeholder="Please Input Minumum Amount">
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <input class="form-control" type="text" v-model="dataInput.minimum" placeholder="Please Input Maximum Amount">
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <selectize id="role" v-model="dataInput.role_id" :settings="roleSettings">
                                                                            <option v-for="(role, index) in roles" :value="role.id">{{ role.name }}</option>
                                                                        </selectize>  
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </template>
                                                </div>
                                                <div class="col-sm-12 p-b-5">
                                                    <button @click.prevent="savePR()" type="button" class="btn btn-primary pull-right">SAVE</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endverbatim
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const form = document.querySelector('form#approval');

    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        types : ['1 Stage', '2 Stage', '2 Stage Special Condition'],
        approvalPR : @json($approvalPR),
        roles: @json($roles),
        selectedTypePR : @json($approvalPR[0]->type),
        newIndex: 0,
        dataInput:{
            minimum:"",
            maximum:"",
            role_id:"",
        },
        roleSettings: {
            placeholder: 'Please Select Role'
        },
    }

    var vm = new Vue({
        el : '#approval',
        data : data,
        method: {
            save(){

            },
        },
        watch:{
            'selectedType': function(newValue){

            }
        },
        created(){
            this.newIndex += 1;
        },
    });
</script>
@endpush