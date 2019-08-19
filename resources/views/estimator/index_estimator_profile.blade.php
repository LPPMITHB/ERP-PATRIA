@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Estimator Profiles',
        'items' => [
            'Dashboard' => route('index'),
            'View Estimator Profiles' => '',
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
                <div class="col-sm-6 p-l-0">
                    <div class="box-tools pull-left">
                        @if($route == "/estimator")
                            <a href="{{ route('estimator.createProfile') }}" class="btn btn-primary btn-sm">CREATE</a>
                        @elseif($route == "/estimator_repair")
                            <a href="{{ route('estimator_repair.createProfile') }}" class="btn btn-primary btn-sm">CREATE</a>
                        @endif
                    </div>
                </div> 
                <table class="table table-bordered tableFixed" id="estimator-profile-table">
                    <thead>
                        <tr>
                            <th width=5%>No</th>
                            <th width=12%>Code</th>
                            <th width=25%>Description</th>
                            <th width=20%>Ship Type</th>
                            <th width=13%>Status</th>
                            <th width=15%>Created At</th>
                            <th width=15%></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($modelProfile as $profile)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$profile->code}}">{{ $profile->code }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$profile->description}}">{{ $profile->description }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$profile->ship->type}}">{{ $profile->ship->type }}</td>
                                <td class="tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $profile->status == "1" ? "Active": "Non Active" }}"> {{ $profile->status == "1" ? "Active": "Non Active" }}</td>
                                <td class="tdEllipsis">{{ date_format($profile->created_at, 'd-m-Y') }}</td>
                                </td>
                                @if($route == "/estimator")
                                    <td class="p-l-0 p-r-0" align="center">
                                        <a href="{{ route('estimator.editProfile', ['id'=>$profile->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                        <a href="{{ route('estimator.showProfile', ['id'=>$profile->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        <a onClick="confirmation({!! $profile->id !!})" class="btn btn-danger btn-xs">DELETE</a>
                                    </td>
                                @elseif($route == "/estimator_repair")
                                    <td class="p-l-0 p-r-0" align="center">
                                        <a href="{{ route('estimator_repair.editProfile', ['id'=>$profile->id]) }}" class="btn btn-primary btn-xs">EDIT</a>
                                        <a href="{{ route('estimator_repair.showProfile', ['id'=>$profile->id]) }}" class="btn btn-primary btn-xs">VIEW</a>
                                        <a onClick="confirmation({!! $profile->id !!})" class="btn btn-danger btn-xs">DELETE</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('#estimator-profile-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'bFilter'     : true,
            'initComplete': function(){
                $('div.overlay').hide();
            }
        });
    });

    function confirmation(profile_id){
        iziToast.show({
            close: false,
            overlay: true,
            timeout : 0,
            displayMode: 'once',
            id: 'question',
            zindex: 9999,
            title: 'Confirm',
            message: 'Are you sure you want to delete this Estimator Profile?',
            position: 'center',
            buttons: [
                ['<button>OK</button>', function (instance, toast) {
                    let route = @json($route);
                    if(route == "/estimator"){
                        document.location.href = "/estimator/deleteProfile/"+profile_id;
                    }else if(route == "/estimator_repair"){
                        document.location.href = "/estimator_repair/deleteProfile/"+profile_id;
                    }
                }, true], 
                ['<button>CANCEL</button>', function (instance, toast) {
                    instance.hide({
                        transitionOut: 'fadeOutUp',
                    }, toast, 'buttonName');
                }]
            ],
        });
    }
</script>
@endpush