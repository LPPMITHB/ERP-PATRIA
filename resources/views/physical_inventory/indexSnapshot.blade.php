@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Physical Inventory » Begin Snapshot',
        'items' => [
            'Dashboard' => route('index'),
            'Begin Snapshot' =>"",
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#create_snapshot" data-toggle="tab" aria-expanded="true">Create Snapshot</a></li>
                        <li class=""><a href="#view_snapshot" data-toggle="tab" aria-expanded="false">View Snapshot Document</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="create_snapshot">
                            <form class="form-horizontal" method="POST" action="{{ route('physical_inventory.displaySnapshot') }}">
                                @csrf
                                <div class="box-body">
                
                                    <div class="form-group">
                                        <label for="sloc" class="col-sm-2 control-label">Storage Location</label>
                    
                                        <div class="col-sm-10">
                                            <select id="sloc" name="sloc[]" multiple="multiple">
                                                @foreach ($storage_locations as $storage_location)
                                                    <option value="{{$storage_location->id}}">{{$storage_location->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="material" class="col-sm-2 control-label">Material</label>
                        
                                        <div class="col-sm-10">
                                            <select id="material" name="material[]" multiple="multiple">
                                                @foreach ($materials as $material)
                                                    <option value="{{$material->id}}">{{$material->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                    
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button disabled id="display" type="submit" class="btn btn-primary col-sm-12">DISPLAY</button>
                                </div>
                                <!-- /.box-footer -->
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="view_snapshot">
                            <table id="stock-table" class="table table-bordered tableFixed" style="border-collapse:collapse; table-layout:fixed;">
                                <thead>
                                    <tr>
                                        <th class="p-l-5" style="width: 5%">No</th>
                                        <th style="width: 15%">Code</th>
                                        <th style="width: 20%">Created At</th>
                                        <th style="width: 20%">Status</th>
                                        <th style="width: 20%">Items</th>
                                        <th style="width: 20%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($counter = 1)
                                    @foreach ($snapshots as $snapshot)
                                        <tr>
                                            <td class="p-l-10">{{ $counter++ }}</td>
                                            <td class="p-l-10">{{ $snapshot->code }}</td>
                                            <td class="p-l-10">{{ $snapshot->created_at }}</td>
                                            <td class="p-l-10">
                                                @if($snapshot->status == 1)
                                                    Open
                                                @elseif($snapshot->status == 0)
                                                    Closed
                                                @elseif($snapshot->status == 2)
                                                    Counted
                                                @endif
                                            </td>
                                            <td class="p-l-10">{{ count($snapshot->snapshotDetails) }}</td>
                                            <td class="p-l-0 textCenter">
                                                <button class="btn btn-primary btn-xs">
                                                    <a  href="{{route('physical_inventory.showSnapshot', ['id' => $snapshot->id])}}">
                                                        VIEW
                                                    </a>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
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
        $('div.overlay').remove();
        $('#sloc, #material').multiselect({
            includeSelectAllOption: true,
            buttonWidth: '100%',
            enableFiltering: true,
            filterBehavior: 'text',
            enableCaseInsensitiveFiltering: true,
            maxHeight: 400,
            onChange: function(element, checked) {
                var sloc = $('#sloc').val();
                var material = $('#material').val();
                if(sloc.length > 0 && material.length > 0){
                    document.getElementById("display").disabled = false;
                }else{
                    document.getElementById("display").disabled = true;
                }
            }
        })

        $('#stock-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').remove();
            }
        });
    });
</script>
@endpush
