@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View WBS » '.$work->code,
        'items' => [
            'Dashboard' => route('index'),
            'View all Projects' => route('project.index'),
            'Project|'.$work->project->code => route('project.show',$work->project->id),
            'Select WBS' => route('project.indexWBS',$work->project->id),
            'View WBS|'.$work->code => ""
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
                            <td>{{ $work->code }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Name</td>
                            <td>{{ $work->name }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Description</td>
                            <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $work->description }}">{{ $work->description }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Deliverables</td>
                            <td>{{ $work->deliverables }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Project</td>
                            <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $work->project->code }} - {{ $work->project->name }}">{{ $work->project->code }} - {{ $work->project->name }}</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Parent Work</td>
                            <td>{{ $work->work != null ? $work->work->code." - ".$work->work->name : "-" }}</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Planned Deadline</td>
                            <td>{{ $work->planned_deadline }}</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Actual Deadline</td>
                            <td>{{ $work->actual_deadline != null ? $work->actual_deadline : '-' }}</td>
                        </tr>

                        <tr>
                            <td>9</td>
                            <td>Progress</td>
                            <td>{{ $work->progress }} %</td>
                        </tr>
                        <tr>
                            <td >10</td>
                            <td>Status</td>
                            <td class="iconTd">
                                 @if ($work->status == 0)
                                    <i class="fa fa-check"></i>
                                @elseif ($work->status == 1)
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