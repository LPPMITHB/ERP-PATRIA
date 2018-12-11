@extends('layouts.main')
@section('content-header')
@breadcrumb(
    [
        'title' => 'View Remaining Material » '.$work->bom->rap->number,
        'items' => [
            'Dashboard' => route('index'),
            'Select Project' => route('rap.selectProjectViewRM'),
            'Select WBS' => route('rap.selectWBS',$project->id),
            'Show Remaining Material' => ""
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
                                <td>&ensp;<b>{{$project->number}}</b></td>
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
                                <td>Progress</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$project->progress}} %</b>
                                </td>
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

                <div class="col-sm-6 ">
                    <table>
                        <thead>
                            <th colspan="2">WBS Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$work->code}}</b></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$work->name}}</b></td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$work->description}}</b></td>
                            </tr>
                            <tr>
                                <td>Deliverable</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$work->deliverables}}</b></td>
                            </tr>
                            <tr>
                                <td>Progress</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$work->progress}} %</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="box-body">
                <h4 class="p-l-10">Material Evaluation</h4>
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
                        @php($counter = 1)
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td>MT0001 - ROUND BAR</td>
                            <td>135</td>
                            <td>30</td>
                            <td>105</td>
                        </tr>
                    </tbody>
                </table>
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
    $(document).ready(function(){
        $('div.overlay').hide();
    });
    
</script>
@endpush