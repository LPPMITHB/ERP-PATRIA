@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View WBS » '.$wbs->code,
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$wbs->project->number => route('project.show',$wbs->project->id),
            'Select WBS' => route('wbs.index',$wbs->project->id),
            'View WBS|'.$wbs->code => ""
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered width100 showTable tableFixed">
                    <thead>
                        <tr>
                            <th style="width: 10%">#</th>
                            <th style="width: 40%">Attribute</th>
                            <th style="width: 58%">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Code</td>
                            <td>{{ $wbs->code }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Name</td>
                            <td>{{ $wbs->name }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Description</td>
                            <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $wbs->description }}">{{ $wbs->description }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Deliverables</td>
                            <td>{{ $wbs->deliverables }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Project</td>
                            <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $wbs->project->number }} - {{ $wbs->project->name }}">{{ $wbs->project->number }} - {{ $wbs->project->name }}</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Parent WBS</td>
                            <td>{{ $wbs->wbs != null ? $wbs->wbs->code." - ".$wbs->wbs->name : "-" }}</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Planned Deadline</td>
                            <td>{{ $wbs->planned_deadline }}</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Actual Deadline</td>
                            <td>{{ $wbs->actual_deadline != null ? $wbs->actual_deadline : '-' }}</td>
                        </tr>

                        <tr>
                            <td>9</td>
                            <td>Progress</td>
                            <td>{{ $wbs->progress }} %</td>
                        </tr>
                        <tr>
                            <td >10</td>
                            <td>Status</td>
                            <td class="iconTd">
                                 @if ($wbs->status == 0)
                                    <i class="fa fa-check"></i>
                                @elseif ($wbs->status == 1)
                                    <i class="fa fa-times"></i>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection