@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'Edit RAP » '.$modelRap->number,
        'items' => [
            'Dashboard' => route('index'),
            'View RAP' => route('rap.edit',$modelRap->id),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-blue">
            <div class="box_header">
                <div class="col-sm-6 p-b-10 p-t-10">
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
                                <td>Start Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $project->planned_start_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td>End Date</td>
                                <td>:</td>
                                <td>&ensp;<b>@php
                                            $date = DateTime::createFromFormat('Y-m-d', $project->planned_end_date);
                                            $date = $date->format('d-m-Y');
                                            echo $date;
                                        @endphp
                                    </b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @verbatim
            <div id="edit-rap">
                <div class="box-body p-t-0 p-b-0">
                    <table class="table table-bordered tableNonPagingVue">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Material Name</th>
                                <th width="15%">Quantity</th>
                                <th width="25%">Cost per pcs (Rp.)</th>
                                <th width="25%">Sub Total Cost (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(rapd, index) in modelRAPD">
                                <td>{{ index+1 }}</td>
                                <td>{{ rapd.material.code }} - {{ rapd.material.name }}</td>
                                <td class="">{{ rapd.quantity }}</td>
                                <td class="no-padding">
                                    <input v-model="rapd.price" class="form-control width100">
                                </td>
                                <td class="no-padding">
                                    <input v-model="rapd.priceTotal" class="form-control width100" disabled>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">SAVE</button>
                </div>
            </div>
            @endverbatim
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    $(document).ready(function(){
        $('div.overlay').hide();

        $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'Material Name'){
                $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
            }else{
                $(this).html( '<input disabled class="form-control width100" type="text"/>' );
            }

            $( 'input', this ).on( 'keyup change', function () {
                if ( tableNonPagingVue.column(i).search() !== this.value ) {
                    tableNonPagingVue
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            });
        });

        var tableNonPagingVue = $('.tableNonPagingVue').DataTable( {
            orderCellsTop   : true,
            paging          : false,
            autoWidth       : true,
            lengthChange    : false,
            info            : false,
        });
    });

    var data = {
        modelRAPD : @json($modelRAPD)
    }

    var vm = new Vue({
        el: '#edit-rap',
        data: data,
        watch:{

        },
        created: function(){
            var data = this.modelRAPD;
            data.forEach(rapDetail => {
                rapDetail.priceTotal = rapDetail.price;
                rapDetail.price = rapDetail.price / rapDetail.quantity;
                rapDetail.price = (rapDetail.price+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
                rapDetail.priceTotal = (rapDetail.priceTotal+"").replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");            
            });
        }
    });
</script>
@endpush
