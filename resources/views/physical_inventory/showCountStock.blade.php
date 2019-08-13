@extends('layouts.main')

@section('content-header')
@breadcrumb(
[
'title' => 'Stock Taking Adjusted » '.$snapshot->code,
'items' => [
'Dashboard' => route('index'),
'Show Snapshot' => "",
]
]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-blue">
            <div class="row">
                <div class="col-sm-4 col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">PI Document Number</span>
                            <span class="info-box-number">{{ $snapshot->code }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8 col-md-8 m-t-10">
                    <div class="row">
                        <div class="col-md-2">
                            Status
                        </div>
                        <div class="col-md-3">
                            :
                            <b>
                                @if($snapshot->status == 1)
                                Open
                                @elseif($snapshot->status == 0)
                                Closed
                                @elseif($snapshot->status == 2)
                                Counted
                                @elseif($snapshot->status == 3)
                                Approved
                                @elseif($snapshot->status == 4)
                                Need Revision
                                @elseif($snapshot->status == 5)
                                Revised
                                @elseif($snapshot->status == 6)
                                Rejected
                                @endif
                            </b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Created At
                        </div>
                        <div class="col-md-3">
                            :
                            <b>{{$snapshot->created_at->format('d-m-Y H:i:s')}}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Audited By
                        </div>
                        <div class="col-md-3">
                            :
                            <b>{{$snapshot->auditedBy->name}}</b>
                        </div>
                    </div>
                    @if($snapshot->status == 5)
                    <div class="row">
                        <div class="col-md-2">
                            Updated By
                        </div>
                        <div class="col-md-3">
                            :
                            <b>{{$snapshot->updatedBy->name}}</b>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
            <div class="box-body p-t-0">
                <table class="table table-bordered showTable" id="stock-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 15%">Material Number</th>
                            <th style="width: 20%">Material Description</th>
                            <th style="width: 5%">Unit</th>
                            <th style="width: 25%">Storage Location</th>
                            <th style="width: 10%">Quantity</th>
                            <th style="width: 10%">Count</th>
                            <th style="width: 10%">Adjusted Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach ($snapshot->snapshotDetails as $details)
                        <tr>
                            <td class="p-l-10">{{ $counter++ }}</td>
                            <td class="p-l-10">{{ $details->material->code }}</td>
                            <td class="p-l-10">{{ $details->material->description }}</td>
                            <td class="p-l-10">{{ $details->material->uom->unit }}</td>
                            <td class="p-l-10">{{ $details->storageLocation->name }}</td>
                            <td class="p-l-10">{{ number_format($details->quantity,2) }}</td>
                            <td class="p-l-10">{{ number_format($details->count,2) }}</td>
                            <td class="p-l-10">{{ number_format($details->adjusted_stock,2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.box-body -->
            @if($confirm)
            <div class="box-footer">
                @if($menu == "building")
                <form id="snapshot" method="POST" action="{{route('physical_inventory.storeAdjustStock', ['id' => $snapshot->id])}}">
                    @else
                    <form id="snapshot" method="POST" action="{{route('physical_inventory_repair.storeAdjustStock', ['id' => $snapshot->id])}}">
                        @endif
                        @csrf
                        <input type="hidden" name="_method" value="PATCH">
                        <!-- <button onclick="showOverlay()" style="margin-right:20px;" id="btnSubmit" class="btn btn-primary col-sm-2">APPROVE STOCK ADJUSTMENT</button>

                        <button onclick="showOverlay()" style="margin-right:20px;" id="btnSubmit" class="btn btn-danger col-sm-2">REVISE STOCK ADJUSTMENT</button>

                        <button onclick="showOverlay()" style="margin-right:20px;" id="btnSubmit" class="btn btn-danger col-sm-2">REJECT STOCK ADJUSTMENT</button> -->
                        @verbatim
                        <div id="approval">
                            <div class="col-md-12 m-b-10 p-r-0 p-t-10">
                                <button type="button" class="col-xs-12 col-md-1 btn btn-primary pull-right m-l-10 m-t-5" @click.prevent="submitForm('approve')">APPROVE</button>
                                <button type="button" class="col-xs-12 col-md-1 btn btn-danger pull-right m-l-10 p-r-10 m-t-5" @click.prevent="submitForm('need-revision')">REVISE</button>
                                <button type="button" class="col-xs-12 col-md-1 btn btn-danger pull-right p-r-10 m-t-5" @click.prevent="submitForm('reject')">REJECT</button>
                            </div>
                        </div>
                        @endverbatim
                    </form>
            </div>
            @endif
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#stock-table').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'initComplete': function() {
                $('div.overlay').remove();
            }
        });
    });

    function showOverlay() {
        $('div.overlay').show();
    }
    const form = document.querySelector('form#snapshot');

    $(document).ready(function() {
        $('div.overlay').hide();
    });

    var data = {
        dataSubmit: {
            status: "",
            desc: ""
        }
    }

    var vm = new Vue({
        el: '#approval',
        data: data,
        methods: {
            submitForm(status) {
                $('div.overlay').show();
                this.dataSubmit.desc = "description"; //document.getElementById('rev_desc').value;
                this.dataSubmit.status = status;

                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.dataSubmit));
                form.appendChild(struturesElem);
                form.submit();
            },
        },
        created: function() {
            // document.getElementById('rev_desc').value = this.dataSubmit.desc;

        },
    })
</script>
@endpush