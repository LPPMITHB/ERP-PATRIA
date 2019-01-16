
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
</head>
<div class="row">
    <div class="col-xs-12">
        <div>
            <div class="box-header no-padding" style="margin-bottom : 47px">
                <div class="col-sm-3 col-md-3 col-lg-3 no-padding-left m-b-10">
                    <img src="{{ asset('images/logo-PMP.png') }}" alt="" srcset="">                    
                </div>
                <div class="row" style="margin-left: -5px;">
                    <div class="col-sm-12" style="line-height: 13px">
                        Kav.20 Dapur 12 Sei Lekop
                    </div>
                    <div class="col-sm-12" style="line-height: 13px">
                        Sagulung, Batam
                    </div>
                    <div class="col-sm-12" style="line-height: 15px">
                        T. 0778-7367111 F.0778-7367112
                    </div>
                </div>
                <h2 class="pull-right" style="margin-top: -50px; margin-right:40px;"><b>Work Order</b></h2>
            </div>
            <hr style="height:2px;border:none;color:#333;background-color:#333;" />
            <div>
                <div class="box-body">
                    <div>Vendor   :</div>
                    <div class="p-l-5" style="word-wrap:break-word;width: 340px; border: black 1px solid; border-radius: 5px; margin-left: 65px; margin-top: -21px;">
                        <b>{{$modelWO->vendor->name}}</b>
                        <p style="margin-top:10px">{{$modelWO->vendor->address}} <br>T.{{$modelWO->vendor->phone_number}}</p>
                    </div>
                </div>
            </div>
            <div style="margin-top:-150px">
                <div class="box-body" style="margin-left: 450px; margin-top:-20px">
                    <div>WO Number  </div>
                    <div class="p-l-5" style="margin-left: 120px; margin-top:-20px">
                        {{$modelWO->number}}                    
                    </div>
                </div>
                <div class="box-body" style="margin-left: 450px; margin-top:-20px">
                    <div>WO Date  </div>
                    <div class="p-l-5" style="margin-left: 120px; margin-top:-20px">
                        {{$modelWO->created_at}}                    
                    </div>
                </div>
                <div class="box-body" style="margin-left: 450px; margin-top:-20px">
                    <div>PR Number  </div>
                    <div class="p-l-5" style="margin-left: 120px; margin-top:-20px">
                        {{$modelWO->workRequest->number}}                    
                    </div>
                </div>
                <div class="box-body" style="margin-left: 450px; margin-top:-20px">
                    <div>Payment Terms  </div>
                    <div class="p-l-5" style="margin-left: 120px; margin-top:-20px">
                        -                    
                    </div>
                </div>
                <div class="box-body" style="margin-left: 450px; margin-top:-20px">
                    <div>Delivery Date  </div>
                    <div class="p-l-5" style="margin-left: 120px; margin-top:-20px">
                        -                    
                    </div>
                </div>
                <div class="box-body" style="margin-left: 450px; margin-top:-20px">
                    <div>Description  </div>
                    <div class="p-l-5" style="margin-left: 120px; margin-top:-20px">
                        {{$modelWO->description}}                  
                    </div>
                </div>
                <div class="box-body" style="margin-left: 450px; margin-top:-20px">
                    <div>Requestor  </div>
                    <div class="p-l-5" style="margin-left: 120px; margin-top:-20px">
                        {{$modelWO->user->name}}                  
                    </div>
                </div>
            </div>
            <div class="m-l-15" style="margin-top: 15px;">
                <i style="font-size: 10px;"><b>Please deliver all the items mentioned to the above address according to agreed delivery date and according to the terms of payment as indicated. Please quote the PO number in all succeeding communications (DO and Invoice) for reference</b></i>
            </div>
            <div class="box-body" style="margin-top: -10px">
                <table class="table-bordered" id="work_order_pdf" style="width: 100%">
                    <thead>
                        <tr>
                            <th width="4%" class="text-center">No</th>
                            <th width="20%" class="text-center" >Material Name</th>
                            <th width="30%" class="text-center">Description</th>
                            <th width="10%" class="text-center">Qty</th>
                            <th width="13%" class="text-center">Price / pcs</th>
                            <th width="6%" class="text-center">Disc (%)</th>
                            <th width="17%" class="text-center">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modelWO->workOrderDetails as $WOD)
                            @if($WOD->quantity > 0)
                                <tr>
                                    <td width="4%">{{ $loop->iteration }}</td>
                                    <td width="20%" class="tdBreakWord">{{ $WOD->material->code }} - {{ $WOD->material->name }}</td>
                                    <td width="30%" class="tdBreakWord">{{ $WOD->workRequestDetail->description }}</td>
                                    <td width="10%" class="tdBreakWord text-center">{{ number_format($WOD->quantity) }}</td>
                                    <td width="13%" class="tdBreakWord text-right">{{ number_format($WOD->total_price / $WOD->quantity,2) }}</td>
                                    <td width="6%" class="tdBreakWord text-center">{{ number_format($WOD->discount,2) }}</td>
                                    <td width="17%" class="tdBreakWord text-right">{{ number_format($WOD->total_price - ($WOD->total_price * ($WOD->discount/100)),2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div> 
        </div> <!-- /.box -->
    </div> <!-- /.col-xs-12 -->
</div> <!-- /.row -->
