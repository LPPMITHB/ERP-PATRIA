@extends('layouts.main')

@section('content-header')
@breadcrumb(
    [
        'title' => 'View Goods Return',
        'items' => [
            'Dashboard' => route('index'),
            'View Goods Return' => route('goods_return.show',$modelGI->id),
        ]
    ]
)
@endbreadcrumb
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        @if($menu == "building")
            <form id="approve-gr"class="form-horizontal" action="{{ route('goods_return.approval') }}">
        @elseif($menu == "repair")
            <form id="approve-gr"class="form-horizontal" action="{{ route('goods_return_repair.approval') }}">
        @endif
        <div class="box box-blue">
            <div class="row">
                <div class="col-sm-3 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">GI Number</span>
                            <span class="info-box-number">{{ $modelGI->number }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-xs-4 col-md-4">
                            Status
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b>{{ $status }}</b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Created By
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b> {{ $modelGI->user->name }} </b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Created At
                        </div>
                        <div class="col-xs-8 col-md-8">
                            : <b> {{ $modelGI->created_at->format('d-m-Y H:i:s') }} </b>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            Description
                        </div>
                        <div class="col-xs-8 col-md-8 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{$modelGI->description}}">
                            : <b> {{ $modelGI->description }} </b>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-sm-4 col-md-4 m-t-10 m-l-10">
                    <div class="row">
                        <div class="col-xs-5 col-md-5">
                            Customer Name
                        </div>
                        <div class="col-md-7 tdEllipsis" data-container="body" data-toggle="tooltip" title="{{ $modelGI->project->customer->name}}">
                            : <b> {{ $modelGI->project->customer->name }} </b>
                        </div>
                        <div class="col-xs-5 col-md-5">
                            Status
                        </div>
                        @if($modelGI->status == 1)
                            <div class="col-xs-7 col-md-7">
                                : <b>OPEN</b>
                            </div>
                        @elseif($modelGI->status == 2)
                            <div class="col-xs-7 col-md-7">
                                : <b>APPROVE</b>
                            </div>
                        @elseif($modelGI->status == 3)
                            <div class="col-xs-7 col-md-7">
                                : <b>NEEDS REVISION</b>
                            </div>
                        @elseif($modelGI->status == 4)
                            <div class="col-xs-7 col-md-7">
                                : <b>REVISED</b>
                            </div>
                        @elseif($modelGI->status == 5)
                            <div class="col-xs-7 col-md-7">
                                : <b>REJECTED</b>
                            </div>
                        @elseif($modelGI->status == 0)
                            <div class="col-xs-7 col-md-7">
                                : <b>ISSUED</b>
                            </div>
                        @endif
                        <div class="col-xs-5 col-md-5">
                            Created By
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ $modelGI->user->name }} </b>
                        </div>
                        <div class="col-xs-5 col-md-5">
                            Created At
                        </div>
                        <div class="col-xs-7 col-md-7">
                            : <b> {{ $modelGI->created_at }} </b>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="box-body p-t-0 p-b-0">
                <table class="table table-bordered showTable tableFixed tableNonPagingVue">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Material Number</th>
                            <th width="20%">Material Description</th>
                            <th width="25%">Quantity</th>
                            <th width="30%">Storage Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelGI->goodsIssueDetails as $GID)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $GID->material->code }}</td>
                                <td>{{ $GID->material->description }}</td>
                                <td>{{ number_format($GID->quantity) }}</td>
                                <td>{{ $GID->storageLocation != null ? $GID->storageLocation->name : "-" }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @verbatim
                <div id="approval">
                    <div class="col-md-12 m-b-10 p-r-0 p-t-10" v-if="modelGI.status == 1 || modelGI.status == 4">
                        <button type="button" class="col-xs-12 col-md-1 btn btn-primary pull-right m-l-10 m-t-5" @click.prevent="submitForm('approve')">APPROVE</button>
                        <button type="button" class="col-xs-12 col-md-1 btn btn-danger pull-right m-l-10 p-r-10 m-t-5" @click.prevent="submitForm('need-revision')">REVISE</button>
                        <button type="button" class="col-xs-12 col-md-1 btn btn-danger pull-right p-r-10 m-t-5" @click.prevent="submitForm('reject')">REJECT</button>
                    </div>
                </div>
                @endverbatim
            </div> <!-- /.box-body -->
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
@endsection

@push('script')
<script>
    const form = document.querySelector('form#approve-gr');

    $(document).ready(function(){
        $('.tableNonPagingVue thead tr').clone(true).appendTo( '.tableNonPagingVue thead' );
        $('.tableNonPagingVue thead tr:eq(1) th').addClass('indexTable').each( function (i) {
            var title = $(this).text();
            if(title == 'No' || title == "Cost per pcs" || title == "Sub Total Cost" || title == "Quantity"){
                $(this).html( '<input disabled class="form-control width100" type="text"/>' );
            }else{
                $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
            }

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                    .column(i)
                    .search( this.value )
                    .draw();
                }
            });
        });

        var table = $('.tableNonPagingVue').DataTable( {
            orderCellsTop   : true,
            paging          : false,
            autoWidth       : false,
            lengthChange    : false,
            info            : false,
        });

        $('div.overlay').hide();
    });

    var data = {
        modelGI : @json($modelGI),
        dataSubmit : {
            gi_id : @json($modelGI->id),
            status : "",
        }
    }

    var vm = new Vue({
        el : '#approval',
        data : data,
        methods : {
            submitForm(status){
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

        },
    })
</script>
@endpush
