@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'Project Cost Evaluation » '.$project->name,
        'items' => [
            'Dashboard' => route('index'),
            'Project|'.$project->code => route('project.show',$project->id),
            'Project Cost Evaluation' => ""
        ]
    ]
)
@endbreadcrumb
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
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
                                <td>&ensp;<b>{{$project->code}}</b></td>
                            </tr>
                            <tr>
                                <td>Ship</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->ship->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->customer->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Currrent Date</td>
                                <td>:</td>
                                <td>&ensp;<b>{{date("d-m-Y")}}</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#cost" data-toggle="tab">Cost</a></li>
                        <li><a href="#material" data-toggle="tab">Material</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="cost">
                            <div class="box box-solid">
                                <div class="box-body">
                                    <div class="col-md-4 no-padding">
                                        <div class="box box-solid bg-dark">
                                            <h4 class="p-l-10">Estimated Cost</h4>
                                            <div class="box-body">
                                                <table class="table table-bordered showTable" style="border-collapse:collapse;">
                                                    <thead>
                                                        <tr>
                                                            <th width="50%">Profile Estimator</th>
                                                            <th width="50%">Cost</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Estimator 001</td>
                                                            <td>Rp.{{number_format(100000000)}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="box box-solid">
                                            <h4 class="p-l-10">Planned Cost</h4>
                                            <div class="box-body">
                                                <table class="table table-bordered showTable" style="border-collapse:collapse;">
                                                    <thead>
                                                        <tr>
                                                            <th width="50%">WBS</th>
                                                            <th width="50%">Cost</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>WBS 001</td>
                                                            <td>Rp.{{number_format(120000000)}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="box box-solid">
                                            <h4 class="p-l-10">Actual Cost</h4>
                                            <div class="box-body">
                                                <table class="table table-bordered showTable" style="border-collapse:collapse;">
                                                    <thead>
                                                        <tr>
                                                            <th width="50%">WBS</th>
                                                            <th width="50%">Cost</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>WBS 001</td>
                                                            <td>Rp.{{number_format(130000000)}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="overlay">
                                        <i class="fa fa-refresh fa-spin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="material">
                            <div class="box box-solid">
                                <div class="box-body">
                                    <div class="col-md-12 no-padding">
                                        <div class="box box-solid bg-dark">
                                            <h4 class="p-l-10">Material Evaluation</h4>
                                            <div class="box-body">
                                                <table class="table table-bordered showTable" style="border-collapse:collapse;">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th width="50%">Material</th>
                                                            <th width="15%">Quantity</th>
                                                            <th width="15%">Used</th>
                                                            <th width="15%">Remaining</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>MT0001 - ROUND BAR</td>
                                                            <td>135</td>
                                                            <td>30</td>
                                                            <td>105</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>MT0002 - STEEL PLATE</td>
                                                            <td>207</td>
                                                            <td>57</td>
                                                            <td>150</td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>MT0003 - GRAB RAIL</td>
                                                            <td>100</td>
                                                            <td>23</td>
                                                            <td>77</td>
                                                        </tr>
                                                        <tr>
                                                            <td>4</td>
                                                            <td>MT0004 - STEEL PLATE GRADE A</td>
                                                            <td>25</td>
                                                            <td>23</td>
                                                            <td>2</td>
                                                        </tr>
                                                        <tr>
                                                            <td>5</td>
                                                            <td>MT0005 - L 150x90x9</td>
                                                            <td>350</td>
                                                            <td>20</td>
                                                            <td>330</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="overlay">
                                        <i class="fa fa-refresh fa-spin"></i>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();
    });
    
</script>
@endpush