@extends('layouts.main')

@section('content-header')
@if($menu == "building")
@breadcrumb(
[
'title' => 'Stock Taking » Count Stock for '.$snapshot->code,
'items' => [
'Dashboard' => route('index'),
'Begin Count Stock' => route('physical_inventory.indexCountStock'),
'Count Stock' => "",
]
]
)
@endbreadcrumb
@else
@breadcrumb(
[
'title' => 'Stock Taking » Count Stock for '.$snapshot->code,
'items' => [
'Dashboard' => route('index'),
'Begin Count Stock' => route('physical_inventory_repair.indexCountStock'),
'Count Stock' => "",
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
                <div class="col-sm-6">
                    <table>
                        <thead>
                            <th colspan="2">PI Document Information</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>PI Document Number</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$snapshot->code}}</b></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>&ensp;
                                    <b>
                                        @if($snapshot->status == 1)
                                        Open
                                        @elseif($snapshot->status == 0)
                                        Closed
                                        @elseif($snapshot->status == 2)
                                        Counted
                                        @elseif($snapshot->status == 4)
                                        Need Revision
                                        @endif
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Created At</td>
                                <td>:</td>
                                <td>&ensp;<b>{{$snapshot->created_at->format('d-m-Y H:i:s')}}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @verbatim
            <div id="count_stock">
                <div class="box-body">
                    <h4 class="box-title">Work Breakdown Structure</h4>
                    <table id="stock-table" class="table table-bordered tableFixed" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 15%">Material Number</th>
                                <th style="width: 30%">Material Description</th>
                                <th style="width: 5%">Unit</th>
                                <th style="width: 10%">Storage Location</th>
                                <th style="width: 25%">Location Detail</th>
                                <th style="width: 10%">Count</th>
                                <th style="width: 10%">Difference</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(data,index) in snapshotDetails">
                                <td>{{ index + 1 }}</td>
                                <td>{{ data.material.code }}</td>
                                <td>{{ data.material.description }}</td>
                                <td>{{ data.material.uom.unit }}</td>
                                <td>{{ data.storage_location.name }}</td>
                                <td>{{ data.material.location_detail }}</td>
                                <td class="p-l-0">
                                    <input v-on:keyup="count(index)" v-on:keydown="count(index)" v-model="snapshotDetails[index].count" type="text" class="form-control width100" name="diff">
                                </td>
                                <td>{{ data.difference }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <button v-on:click="save" :disabled="countOk" id="btnSubmit" class="btn btn-primary col-sm-12">CONFIRM COUNT STOCK</button>
                </div>
            </div>
            @endverbatim
            @if($menu == "building")
            <form id="countStock" method="POST" action="{{route('physical_inventory.storeCountStock', ['id' => $snapshot->id])}}">
                @else
                <form id="countStock" method="POST" action="{{route('physical_inventory_repair.storeCountStock', ['id' => $snapshot->id])}}">
                    @endif
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">
                </form>
                <div class="overlay">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const form = document.querySelector('form#countStock');

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

    var data = {
        snapshotDetails: @json($snapshotDetails),
        activeIndex: "",
    };

    var vm = new Vue({
        el: '#count_stock',
        data: data,
        computed: {
            countOk: function() {
                let isOk = false;
                this.snapshotDetails.forEach(details => {
                    if (details.count == "") {
                        isOk = true;
                    }
                });

                return isOk;
            },
        },
        methods: {
            count: function(index) {
                this.$nextTick(() => {
                    var snapshotDetail = this.snapshotDetails[index];
                    var count = parseFloat((this.snapshotDetails[index].count).replace(/,/g, ''));
                    if ((this.snapshotDetails[index].count) != "" && isNaN(count) == false) {
                        var diff = this.snapshotDetails[index].quantity - (this.snapshotDetails[index].quantity * 2) + count;
                        this.snapshotDetails[index].difference = (diff + "");

                        count_string = this.snapshotDetails[index].count;
                        this.snapshotDetails[index].count = count_string;
                    } else {
                        this.snapshotDetails[index].count = "";
                        var diff = this.snapshotDetails[index].quantity - (this.snapshotDetails[index].quantity * 2);
                        this.snapshotDetails[index].difference = (diff + "");
                    }

                    if (snapshotDetail.material.uom.is_decimal == 1) {
                        var decimal = (this.snapshotDetails[index].difference + "").replace(/,/g, '').split('.');
                        if (decimal[1] != undefined) {
                            var maxDecimal = 2;
                            if ((decimal[1] + "").length > maxDecimal) {
                                this.snapshotDetails[index].difference = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").substring(0, maxDecimal).replace(/\D/g, "");
                            } else {
                                this.snapshotDetails[index].difference = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").replace(/\D/g, "");
                            }
                        } else {
                            this.snapshotDetails[index].difference = (this.snapshotDetails[index].difference + "").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }

                        var decimal = (this.snapshotDetails[index].count + "").replace(/,/g, '').split('.');
                        if (decimal[1] != undefined) {
                            var maxDecimal = 2;
                            if ((decimal[1] + "").length > maxDecimal) {
                                this.snapshotDetails[index].count = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").substring(0, maxDecimal).replace(/\D/g, "");
                            } else {
                                this.snapshotDetails[index].count = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").replace(/\D/g, "");
                            }
                        } else {
                            this.snapshotDetails[index].count = (this.snapshotDetails[index].count + "").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                    } else {
                        this.snapshotDetails[index].difference = ((this.snapshotDetails[index].difference + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        this.snapshotDetails[index].count = ((this.snapshotDetails[index].count + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                });
            },
            save() {
                $('div.overlay').show();
                this.snapshotDetails.forEach(details => {
                    details.count = (details.count + "").replace(/,/g, '');
                });
                let struturesElem = document.createElement('input');
                struturesElem.setAttribute('type', 'hidden');
                struturesElem.setAttribute('name', 'datas');
                struturesElem.setAttribute('value', JSON.stringify(this.snapshotDetails));
                form.appendChild(struturesElem);
                form.submit();
            }
        },
        created: function() {
            this.snapshotDetails.forEach(details => {
                if (details.count != null) {
                    details.difference = ((details.quantity - (details.quantity * 2) + details.count) + "");
                    details.count = (details.count + "").replace(/,/g, '');
                } else {
                    details.count = details.quantity;
                    var count = parseFloat((details.count + "").replace(/,/g, ''));
                    details.difference = ((details.quantity - (details.quantity * 2) + count) + "");
                }

                if (details.material.uom.is_decimal == 1) {
                    var decimal = (details.difference + "").replace(/,/g, '').split('.');
                    if (decimal[1] != undefined) {
                        var maxDecimal = 2;
                        if ((decimal[1] + "").length > maxDecimal) {
                            details.difference = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").substring(0, maxDecimal).replace(/\D/g, "");
                        } else {
                            details.difference = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").replace(/\D/g, "");
                        }
                    } else {
                        details.difference = (details.difference + "").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }

                    var decimal = (details.count + "").replace(/,/g, '').split('.');
                    if (decimal[1] != undefined) {
                        var maxDecimal = 2;
                        if ((decimal[1] + "").length > maxDecimal) {
                            details.count = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").substring(0, maxDecimal).replace(/\D/g, "");
                        } else {
                            details.count = (decimal[0] + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "." + (decimal[1] + "").replace(/\D/g, "");
                        }
                    } else {
                        details.count = (details.count + "").replace(/[^0-9.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                } else {
                    details.difference = ((details.difference + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    details.count = ((details.count + "").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                }
            });
        },
    });
</script>
@endpush