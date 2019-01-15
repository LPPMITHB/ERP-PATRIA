@extends('layouts.main')

@section('content-header')
@if($menu == "building")
    @breadcrumb(
        [
            'title' => 'PHYSICAL INVENTORY » STOCK DETAILS',
            'items' => [
                'Dashboard' => route('index'),
                'Begin Snapshot' => route('physical_inventory.indexSnapshot'),
                'Stock Details' => ''
            ]
        ]
    )
    @endbreadcrumb
@else
    @breadcrumb(
        [
            'title' => 'PHYSICAL INVENTORY » STOCK DETAILS',
            'items' => [
                'Dashboard' => route('index'),
                'Begin Snapshot' => route('physical_inventory_repair.indexSnapshot'),
                'Stock Details' => ''
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
            <div class="box-body">
                <h4 class="box-title">Stock Snapshot <b>{{$piCode}}</b> </h4>
                <table id="stock-table" class="table table-bordered showTable tableFixed" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 45%">Material Name</th>
                            <th style="width: 40%">Storage Location</th>
                            <th style="width: 10%">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach ($stocks as $stock)
                            <tr>
                                <td class="p-l-10">{{ $counter++ }}</td>
                                <td class="p-l-10">{{ $stock->material->name }}</td>
                                <td class="p-l-10">{{ $stock->storageLocation->name }}</td>
                                <td class="p-l-10">{{ $stock->quantity }}</td>
                            </tr>
                        @endforeach
                        @if(count($stocks) == 0)
                            <tr>
                                <td colspan="4" class="textCenter"><b>NO STOCK</b></td>
                                <td style="display: none;"></td>
                                <td style="display: none;"></td>
                                <td style="display: none;"></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                @if($menu == "building")
                    <form id="snapshot" method="POST" action="{{ route('physical_inventory.storeSnapshot') }}">
                @else
                    <form id="snapshot" method="POST" action="{{ route('physical_inventory_repair.storeSnapshot') }}">
                @endif
                    @csrf
                </form>
                <button id="btnSubmit" {{count($stocks)>0 ? '' : 'disabled'}} class="btn btn-primary col-sm-12">CREATE SNAPSHOT</button>
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

    const form = document.querySelector('form#snapshot');

    sloc = @json($sloc);
    material = @json($material);

    $(document).ready(function(){
        $('#stock-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'initComplete': function(){
                $('div.overlay').remove();
            },
        });
    });

    document.getElementById("btnSubmit").addEventListener("click", function(){
        let struturesElemSloc = document.createElement('input');
        struturesElemSloc.setAttribute('type', 'hidden');
        struturesElemSloc.setAttribute('name', 'sloc');
        struturesElemSloc.setAttribute('value', sloc);
        form.appendChild(struturesElemSloc);
        
        let struturesElemMaterial = document.createElement('input');
        struturesElemMaterial.setAttribute('type', 'hidden');
        struturesElemMaterial.setAttribute('name', 'material');
        struturesElemMaterial.setAttribute('value', material);
        form.appendChild(struturesElemMaterial);
        form.submit();
    });

    
</script>
@endpush
