@extends('layouts.main')
@section('content-header')
    @if ($menu == "building")
        @breadcrumb(
            [
                'title' => 'Project Cost Evaluation » '.$project->name,
                'items' => [
                    'Dashboard' => route('index'),
                    'View all Projects' => route('project.index'),
                    'Project|'.$project->number => route('project.show',$project->id),
                    'Project Cost Evaluation' => ""
                ]
            ]
        )
        @endbreadcrumb
    @else
        @breadcrumb(
            [
                'title' => 'Project Cost Evaluation » '.$project->name,
                'items' => [
                    'Dashboard' => route('index'),
                    'View all Projects' => route('project_repair.index'),
                    'Project|'.$project->number => route('project_repair.show',$project->id),
                    'Project Cost Evaluation' => ""
                ]
            ]
        )
        @endbreadcrumb
    @endif
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header">
                <div class="col-xs-12 col-lg-4 col-md-12">    
                    <div class="box-body">
                        <div class="col-sm-12 no-padding"><b>Project Information</b></div>
                        
                        <div class="col-md-4 col-xs-6 no-padding">Code</div>
                        <div class="col-md-8 col-xs-6 no-padding"><b>: {{$project->number}}</b></div>
                        
                        <div class="col-md-4 col-xs-6 no-padding">Ship</div>
                        <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->ship->type}}"><b>: {{$project->ship->type}}</b></div>

                        <div class="col-md-4 col-xs-6 no-padding">Customer</div>
                        <div class="col-md-8 col-xs-6 no-padding tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$project->customer->name}}"><b>: {{$project->customer->name}}</b></div>

                        <div class="col-md-4 col-xs-6 no-padding">Currrent Date</div>
                        <div class="col-md-8 col-xs-6 no-padding"><b>: {{date("d-m-Y")}}</b></div>
                    </div>
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
                            <div class="box-body">
                                <div class="col-md-4">
                                    <h4 class="p-l-10">Estimated Cost</h4>
                                    <table class="table table-bordered showTable" style="border-collapse:collapse;">
                                        <thead>
                                            <tr>
                                                <th width="50%">Profile Estimator</th>
                                                <th width="50%">Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                {{-- <td>Estimator 001</td>
                                                <td>Rp.{{number_format(120000000)}}</td> --}}
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="p-l-10">Planned Cost</h4>
                                    <table class="table table-bordered showTable tableFixed" style="border-collapse:collapse;">
                                        <thead>
                                            <tr>
                                                <th width="50%">WBS</th>
                                                <th width="50%">Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>   
                                            @foreach ($planned as $data)
                                                <tr>
                                                    <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$data['wbs_number']}}">{{$data['wbs_number']}}</td>
                                                    <td>Rp {{number_format($data['cost'])}}</td>
                                                </tr>    
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                <h4 class="p-l-10">Actual Cost</h4>
                                    <table class="table table-bordered showTable tableFixed" style="border-collapse:collapse;">
                                        <thead>
                                            <tr>
                                                <th width="50%">WBS</th>
                                                <th width="50%">Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>   
                                            @foreach ($actual as $data)
                                                @if ($planned[$data['wbs_id']]['cost'] > 0 &&  $data['cost'] > 0)
                                                    @php
                                                        $temp_percentage =($data['cost']/$planned[$data['wbs_id']]['cost'])*100;
                                                    @endphp
                                                    @if ( $temp_percentage > 100)
                                                        <tr style="background-color: red;">
                                                            <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$data['wbs_number']}}">{{$data['wbs_number']}}</td>
                                                            <td >Rp {{number_format($data['cost'])}}</td>
                                                        </tr> 
                                                    @elseif($temp_percentage > 95)
                                                        <tr style="background-color: yellow;">
                                                            <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$data['wbs_number']}}">{{$data['wbs_number']}}</td>
                                                            <td >Rp {{number_format($data['cost'])}}</td>
                                                        </tr> 
                                                    @else
                                                        <tr>
                                                            <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$data['wbs_number']}}">{{$data['wbs_number']}}</td>
                                                            <td >Rp {{number_format($data['cost'])}}</td>
                                                        </tr> 
                                                    @endif
                                                @else
                                                    <tr>
                                                        <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$data['wbs_number']}}">{{$data['wbs_number']}}</td>
                                                        <td >Rp {{number_format($data['cost'])}}</td>
                                                    </tr> 
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="overlay">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="material">
                            <div class="box-body">
                                <div class="col-md-12 no-padding">
                                    <h4 class="p-l-10">Material Evaluation</h4>
                                    <table class="table table-bordered showTable tableFixed" style="border-collapse:collapse;">
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
                                            @foreach($materialEvaluation as $data) 
                                            <tr>
                                                <td class="tdEllipsis">{{ $loop->iteration }}</td>
                                                <td class="tdEllipsis">{{ $data['material'] }}</td>
                                                <td class="tdEllipsis">{{ number_format($data['quantity'],2) }}</td>
                                                <td class="tdEllipsis">{{ number_format($data['used'],2) }}</td>
                                                <td class="tdEllipsis">{{ number_format($data['quantity'] - $data['used'], 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="overlay">
                                    <i class="fa fa-refresh fa-spin"></i>
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
        jQuery('.table').wrap('<div class="dataTables_scroll" />');
    });
    
</script>
@endpush