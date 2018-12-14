@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'WBS & Estimator Configuration » '.$project->name,
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('project.selectProjectConfig'),
            ]
        ]
    )
    @endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-6">
                    <table>
                        <thead>
                            <th colspan="2">Project Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->number}}</b></td>
                            </tr>
                            <tr>
                                <td>Ship</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->ship->type}}</b></td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->customer->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Planned Start Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $project->planned_start_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Planned End Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $project->planned_end_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> <!-- /.box-header -->
            @verbatim
            <div id="config">
                <div class="box-body">
                    <table class="table table-bordered" id="boms-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="35%">Estimator Profile</th>
                                <th width="40%">Work Breakdown Structure(s)</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ newIndex }}</td>
                                <td class="no-padding">
                                    <selectize v-model="dataInput.estimator_id" :settings="estimatorSettings">
                                        <option v-for="(estimator, index) in modelEstimator" :value="estimator.id">{{ estimator.name }}</option>
                                    </selectize>
                                </td>
                                <td class="no-padding">
                                    <selectize v-model="dataInput.wbs_id" :settings="workSettings">
                                        <option v-for="(work, index) in modelWork" :value="work.id">{{ work.name }}</option>
                                    </selectize>    
                                </td>
                                <td class="p-l-5 p-r-5" align="center">
                                    <a class="btn btn-primary btn-xs" href="">SUBMIT</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> <!-- /.box-body -->
            </div>
            @endverbatim
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();
    });

    var data = {
        modelWork : @json($works),
        modelEstimator : [],
        dataInput : {
            estimator_id : "",
            wbs_id : []
        },
        datas: [],
        estimatorSettings: {
            placeholder: 'Please Select Estimator'
        },
        workSettings: {
            placeholder: 'Please Select Work(s)',
            maxItems : null,
            dropdownDirection : "auto",
            plugins: ['remove_button'],
        },
        newIndex : "",
    }

    var vm = new Vue({
        el : '#config',
        data : data,
        computed : {

        },
        created: function(){
            this.newIndex = Object.keys(this.datas).length+1;
        }
    });
</script>
@endpush
