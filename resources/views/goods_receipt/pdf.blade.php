<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1.0">
    
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css" media="all">
        <style>
             /** 
                    Set the margins of the page to 0, so the footer and the header
                    can be of the full height and width !
                 **/
                 
                /** Define now the real margins of every page in the PDF **/
                @page{
                    margin-top:310px;
                    margin-bottom : 130px;
                }

                /** Define the header rules **/
                header {
                    position: fixed;
                    top: -248px;
                    left: 0cm;
                    right: 0cm;
                }
                #footer{
                    position: fixed;
                    bottom: 0px;
                    left: 10px;
                    right: 0cm;
                }
        </style>
    </head>
    <body>
        <script type="text/php">
            if (isset($pdf)) {
            }
        </script>
        <header>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header no-padding" style="margin-bottom : 47px">
                        <div class="col-sm-3 col-md-3 col-lg-3 no-padding-left m-b-7">
                            <img src="{{ asset('images/logo-PMP.png') }}" alt="" srcset="">                    
                        </div>
                        <div class="row" style="margin-left: -5px;">
                            <div class="col-sm-12" style="font-size: 11px;line-height: 13px">
                                {{$branch->address}}
                            </div>
                            <div class="col-sm-12" style="font-size: 11px;line-height: 13px">
                                {{$branch->city}}
                            </div>
                            <div class="col-sm-12" style="font-size: 11px;line-height: 15px">
                                T.{{$branch->phone_number}} F.{{$branch->fax}}
                            </div>
                        </div>
                        <h2 class="pull-right" style="margin-top: -70px; margin-right:40px;"><b>Goods Receipt</b></h2>
                    </div>
                    <hr style="height:1.5px;border:none;color:#333;background-color:#333;" />
                    <div>
                        <div>
                            <div style="font-size: 11px;">Vendor   :</div>
                            <div class="p-l-5" style="word-wrap:break-word;width: 340px; border: black 1px solid; border-radius: 5px; margin-left: 65px; margin-top: -50px;">
                                @if($modelGR->purchase_order_id != "")
                                <b style="font-size: 12px;">{{$modelGR->purchaseOrder->vendor->name}}</b>
                                <p style="font-size: 11px; margin-top:10px">{{$modelGR->purchaseOrder->vendor->address}} <br>
                                    @if(isset($modelGR->purchaseOrder->vendor->phone_number_1))
                                    T.{{$modelGR->purchaseOrder->vendor->phone_number_1}}
                                    @else
                                    @endif
                                </p>
                                @elseif($modelGR->work_order_id != "")
                                <b style="font-size: 12px;">{{$modelGR->workOrder->vendor->name}}</b>
                                <p style="font-size: 11px; margin-top:10px">{{$modelGR->workOrder->vendor->address}} <br>
                                    @if(isset($modelGR->workOrder->vendor->phone_number_1))
                                    T.{{$modelGR->workOrder->vendor->phone_number_1}}
                                    @else
                                    @endif
                                </p>
                                @elseif($modelGR->purchase_order_id == "" && $modelGR->work_order_id == "")
                                -
                                @endif
                            </div>
                            <div style="font-size: 11px;">Project  :</div>
                            <div class="p-l-5" style="word-wrap:break-word;width: 340px; margin-left: 65px; margin-top: -50px;">
                                @if($modelGR->purchase_order_id != "")
                                <b style="font-size: 12px;">{{$modelGR->purchaseOrder->project->name}}</b>
                                @elseif($modelGR->work_order_id != "")
                                <b style="font-size: 12px;">{{$modelGR->workOrder->project->name}}</b>
                                @elseif($modelGR->purchase_order_id == "" && $modelGR->work_order_id == "")
                                -
                                @endif
                            </div>
                            <div style="font-size: 11px;">Dept  :</div>
                            <div class="p-l-5" style="word-wrap:break-word;width: 340px; margin-left: 65px; margin-top: -50px;">
                                <b style="font-size: 12px;">{{$modelGR->user->role->name}}</b>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:-100px; padding-top: -10px">
                        <div style="margin-left: 450px;">
                            <div style="font-size: 11px;">GR Number  </div>
                            <div class="p-l-5" style="font-size: 11px; margin-left: 120px; margin-top:-20px">
                                {{$modelGR->number}}                    
                            </div>
                        </div>
                        <div style="margin-left: 450px; ">
                            <div style="font-size: 11px;">GR Date  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{date("d-m-Y", strtotime($modelGR->created_at))}}                    
                            </div>
                        </div>
                        <div  style="margin-left: 450px;">
                            <div style="font-size: 11px;">FOB </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                -                    
                            </div>
                        </div>
                        <div  style="margin-left: 450px;">
                            @if($modelGR->purchase_order_id != "")
                            <div style="font-size: 11px;">PO Number  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{$modelGR->purchaseOrder->number}}                    
                            </div>
                            @elseif($modelGR->work_order_id != "")
                            <div style="font-size: 11px;">WO Number  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{$modelGR->workOrder->number}}                    
                            </div>
                            @else
                            <div style="font-size: 11px;">PO Number  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                -                   
                            </div>
                            @endif
                        </div>
                        <div  style="margin-left: 450px;">
                            <div style="font-size: 11px;">Ship Date  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                @if($modelGR->ship_date != "")
                                {{$modelGR->ship_date}}
                                @else 
                                -
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main>
            <div class="row">
                <div class="col-xs-12">
                    <div>
                        <table class="table-bordered" id="goods_receipt_pdf" style="width: 100%; margin-left: -10px">
                            <thead>
                                <tr>
                                    <th style="font-size: 11px" width="4%" class="text-center">NO</th>
                                    <th style="font-size: 11px" width="22%" class="text-center" >ITEM NO</th>
                                    <th style="font-size: 11px" width="33%" class="text-center">ITEM DESCRIPTION</th>
                                    <th style="font-size: 11px" width="8%" class="text-center">QUANTITY</th>
                                    <th style="font-size: 11px" width="8%" class="text-center">U/M</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modelGR->goodsReceiptDetails as $GRD)
                                    @if($GRD->quantity > 0)
                                        <tr>
                                            <td style="font-size: 11px" width="4%">{{ $loop->iteration }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px; padding-left:4px;" width="22%" class="tdBreakWord">{{ $GRD->material->code }} - {{ $GRD->material->name }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px; padding-left:4px;" width="30%" class="tdBreakWord">{{ $GRD->material->description }}</td>
                                            <td style="font-size: 11px" width="8%" class="tdBreakWord text-center">{{ number_format($GRD->quantity) }}</td>
                                            <td style="font-size: 11px" width="8%" class="tdBreakWord text-center">{{ $GRD->material->uom->unit }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div id="footer" style="page-break-inside:avoid;margin-left: -10px;">
                            <div class="col-xs-12" style="margin-top:3px; width:230px;padding-left:5px; border: black 1px solid; border-radius: 5px; height:80px;">
                                <div style="font-size: 11px"><b>Description</b></div>
                                <div style="font-size: 11px">{{$modelGR->description}}</div>
                            </div>
                            <div>
                                <div style="margin-left: 290px; margin-top: 3px; font-size: 11px">Prepared By</div>
                                <hr style="margin-left: 290px; margin-top: 45px; width:75px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-left: 290px;margin-top: -20px;font-size: 11px">Date</div>
                            </div>
                            <div style="margin-left: 410px; margin-top:-150px">
                                <div style="margin-top: 3px; font-size: 11px">Aproved By</div>
                                <hr style="margin-left: 0px; margin-top: 45px; width:75px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-top: -20px;font-size: 11px">Date</div>
                            </div>  
                            <div style="margin-top:-60px; width:200px;padding-left:5px; border: black 1px solid; border-radius: 5px; height:40px; margin-left:510px;">
                                <div style="font-size: 11px"><b>Total Item</b></div>
                                <div class="p-l-5" style="font-size: 11px;margin-left: 170px; margin-top:-20px">
                                    {{$modelGR->goodsReceiptDetails->count('material')}}                    
                                </div>
                                <div style="font-size: 11px"><b>Total Quantity</b></div>
                                <div class="p-l-5" style="font-size: 11px;margin-left: 170px; margin-top:-20px">
                                    {{$modelGR->goodsReceiptDetails->sum('quantity')}}                    
                                </div>
                            </div>
                        </div>
                    </div> 
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </main>
    </body>
</html>
