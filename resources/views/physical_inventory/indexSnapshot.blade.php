@extends('layouts.main')

@section('content-header')
@breadcrumb(
[
'title' => 'Stock Taking » Create Stock Take',
'items' => [
'Dashboard' => route('index'),
'Create Stock Take' =>"",
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
                        <li class="active"><a href="#create_snapshot" data-toggle="tab" aria-expanded="true">Create
                                Stock Take</a></li>
                        <li class=""><a href="#view_snapshot" data-toggle="tab" aria-expanded="false">View Stock Take
                                Document</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="create_snapshot">
                            @if($menu == "building")
                            <form class="form-horizontal" method="POST"
                                action="{{ route('physical_inventory.displaySnapshot') }}">
                                @else
                                <form class="form-horizontal" method="POST"
                                    action="{{ route('physical_inventory_repair.displaySnapshot') }}">
                                    @endif
                                    @csrf
                                    <div class="box-body">

                                        <div class="form-group">
                                            <label for="warehouse" class="col-sm-2 control-label">Warehouse</label>

                                            <div class="col-sm-10">
                                                <select id="warehouse" name="warehouse[]" multiple="multiple">
                                                    @foreach ($warehouses as $warehouse)
                                                    <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="sloc" class="col-sm-2 control-label">Storage Location</label>

                                            <div class="col-sm-10">
                                                <select id="sloc" name="sloc[]" multiple="multiple">
                                                    @foreach ($storage_locations as $storage_location)
                                                    <option value="{{$storage_location->id}}"
                                                        warehouse_id="{{$storage_location->warehouse_id}}">
                                                        {{$storage_location->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="material" class="col-sm-2 control-label">Material</label>

                                            <div class="col-sm-10">
                                                <select id="material" name="material[]" multiple="multiple">
                                                    @foreach ($materials as $material)
                                                    <option value="{{$material->id}}">{{$material->code}} -
                                                        {{$material->description}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button disabled id="display" onclick="showOverlay()" type="submit"
                                            class="btn btn-primary col-sm-12">DISPLAY</button>
                                    </div>
                                    <!-- /.box-footer -->
                                </form>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="view_snapshot">
                            <div class="col-sm-6 p-l-0">
                                <div class="box-tools pull-left">
                                    <span id="date-label-from" class="date-label">From: </span><input
                                        class="date_range_filter datepicker" type="text" id="datepicker_from" />
                                    <span id="date-label-to" class="date-label">To: </span><input
                                        class="date_range_filter datepicker" type="text" id="datepicker_to" />
                                    <button id="btn-reset" class="btn btn-primary btn-sm">RESET</button>
                                </div>
                            </div>
                            <table id="snapshot-table" class="table table-bordered tableFixed"
                                style="border-collapse:collapse; table-layout:fixed;">
                                <thead>
                                    <tr>
                                        <th class="p-l-5" style="width: 5%">No</th>
                                        <th style="width: 15%">Code</th>
                                        <th style="width: 20%">Status</th>
                                        <th style="width: 20%">Items</th>
                                        <th style="width: 15%">Document Date</th>
                                        <th style="width: 20%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($counter = 1)
                                    @foreach ($snapshots as $snapshot)
                                    <tr>
                                        <td class="p-l-10">{{ $counter++ }}</td>
                                        <td class="p-l-10">{{ $snapshot->code }}</td>
                                        <td class="p-l-10">{{ $snapshot->created_at->format('d-m-Y H:i:s') }}</td>
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
                                        <td class="tdEllipsis">{{ $snapshot->created_at->format('d-m-Y') }}</td>
                                        <td class="p-l-0 textCenter">
                                            @if($snapshot->status == 1)
                                            @if($menu == "building")
                                            <a id="btn_submit" onclick="showOverlay()" class="btn btn-primary btn-xs"
                                                href="{{route('physical_inventory.showSnapshot', ['id' => $snapshot->id])}}">
                                                VIEW
                                            </a>
                                            @else
                                            <a id="btn_submit" onclick="showOverlay()" class="btn btn-primary btn-xs"
                                                href="{{route('physical_inventory_repair.showSnapshot', ['id' => $snapshot->id])}}">
                                                VIEW
                                            </a>
                                            @endif
                                            @else
                                            @if($menu == "building")
                                            <a id="btn_submit" onclick="showOverlay()" class="btn btn-primary btn-xs"
                                                href="{{route('physical_inventory.showCountStock', ['id' => $snapshot->id])}}">
                                                VIEW
                                            </a>
                                            @else
                                            <a id="btn_submit" onclick="showOverlay()" class="btn btn-primary btn-xs"
                                                href="{{route('physical_inventory_repair.showCountStock', ['id' => $snapshot->id])}}">
                                                VIEW
                                            </a>
                                            @endif
                                            @endif
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
    var sloc_options = @json($storage_locations);
    var material_options = @json($storage_location_details);
    $(document).ready(function(){
        $('div.overlay').hide();
        
        $('#warehouse').multiselect({
            includeSelectAllOption: true,
            buttonWidth: '100%',
            enableFiltering: true,
            filterBehavior: 'text',
            enableCaseInsensitiveFiltering: true,
            maxHeight: 400,
            onChange: function(element, checked) {
                var sloc = $('#sloc').val();
                var material = $('#material').val();
                var warehouse = $('#warehouse').val();
                if(sloc.length > 0 && material.length > 0 && warehouse.length > 0){
                    document.getElementById("display").disabled = false;
                }else{
                    document.getElementById("display").disabled = true;
                }
                var data = [];
                if(warehouse.length > 0){
                    sloc_options.forEach(sloc_option => {
                        for (let j = 0; j < warehouse.length; j++) {
                            const warehouse_selected = warehouse[j];
                            if(warehouse_selected == sloc_option.warehouse_id){
                                data.push(
                                    {label: sloc_option.name, value: sloc_option.id}
                                );
                            }
                        }
                    });
                    $("#sloc").multiselect('dataprovider', data);    
                }
            }
        });
        $('#sloc').multiselect({
            includeSelectAllOption: true,
            buttonWidth: '100%',
            enableFiltering: true,
            filterBehavior: 'text',
            enableCaseInsensitiveFiltering: true,
            maxHeight: 400,
            onChange: function(element, checked){
                var sloc = $('#sloc').val();
                var material = $('#material').val();
                if(sloc.length > 0 && material.length > 0 && warehouse.length > 0){
                    document.getElementById("display").disabled = false;
                }else{
                    document.getElementById("display").disabled = true;
                }
                var data = [];
                if(sloc.length > 0){
                material_options.forEach(material_options => {
                for (let j = 0; j < sloc.length; j++) { const sloc_selected=sloc[j];
                    if(sloc_selected==material_options.storage_location_id){ data.push( {label: material_options.material.description, value: material_options.material.id} ); } }
                    }); $("#material").multiselect('dataprovider', data); }
            }
        });
        $('#material').multiselect({
            includeSelectAllOption: true,
            buttonWidth: '100%',
            enableFiltering: true,
            filterBehavior: 'text',
            enableCaseInsensitiveFiltering: true,
            maxHeight: 400,onChange: function(element, checked){
                var sloc = $('#sloc').val();
                var material = $('#material').val();
                if(sloc.length > 0 && material.length > 0 && warehouse.length > 0){
                    document.getElementById("display").disabled = false;
                }else{
                    document.getElementById("display").disabled = true;
                }
            }
        });

        var snapshot_table = $('#snapshot-table').DataTable({
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

        $("#datepicker_from").datepicker({
            autoclose : true,
            format : "dd-mm-yyyy"
        }).keyup(function() {
            var temp = this.value.split("-");
            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            snapshot_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            minDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            snapshot_table.draw();
        });

        $("#datepicker_to").datepicker({
            autoclose : true,
            format : "dd-mm-yyyy"
        }).keyup(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            snapshot_table.draw();
        }).change(function() {
            var temp = this.value.split("-");
            maxDateFilter = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
            snapshot_table.draw();
        });

        document.getElementById("btn-reset").addEventListener("click", reset);

        function reset() {
            $("#datepicker_from").val('');
            $("#datepicker_to").val('');
            maxDateFilter = "";
            minDateFilter = "";
            snapshot_table.draw();
        }

        // Date range filter
        minDateFilter = "";
        maxDateFilter = "";

        $.fn.dataTableExt.afnFiltering.push(
            function(oSettings, aData, iDataIndex) {
                if (typeof aData._date == 'undefined') {
                    var temp = aData[4].split("-");
                    aData._date = new Date(temp[1]+"-"+temp[0]+"-"+temp[2]).getTime();
                }

                if (minDateFilter && !isNaN(minDateFilter)) {
                    if (aData._date < minDateFilter) {
                        return false;
                    }
                }

                if (maxDateFilter && !isNaN(maxDateFilter)) {
                    if (aData._date > maxDateFilter) {
                        return false;
                    }
                }

                return true;
            }
        );
    });
    function showOverlay(){
        $('div.overlay').show();
    }
</script>
@endpush