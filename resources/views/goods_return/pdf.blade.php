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

        </script>
        <header>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header no-padding" style="margin-bottom : 47px">
                        <div class="col-sm-3 col-md-3 col-lg-3 no-padding-left m-b-7">
                            @if($route == '/goods_return')
                            <img src="{{ asset('images/logo-PMP.png') }}" alt="" srcset="">
                            @else
                            <img src="{{ asset('images/logo-PAMI.jpg') }}" alt="" srcset="">
                            @endif
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
                        <h2 class="pull-right" style="margin-top: -70px; margin-right:40px;"><b>Goods Return</b></h2>
                    </div>
                    <hr style="height:1.5px;border:none;color:#333;background-color:#333;" />
                    <div>
                        <div>
                            <div style="font-size: 11px;">To Vendor   :</div>
                            <div class="p-l-5" style="word-wrap:break-word;width: 340px; border: black 1px solid; border-radius: 5px; margin-left: 65px; margin-top: -50px;">
                                @if($modelGRT->purchase_order_id != null)
                                <b style="font-size: 12px;">{{$modelGRT->purchaseOrder->vendor->name}}</b>
                                <p style="font-size: 11px; margin-top:10px">{{$modelGRT->purchaseOrder->vendor->address}} <br>T.{{$modelGRT->purchaseOrder->vendor->phone_number_1}}</p>
                                @elseif($modelGRT->goods_receipt_id != null)
                                    @if($modelGRT->goodsReceipt->purchase_order_id != null)
                                        <b style="font-size: 12px;">{{$modelGRT->goodsReceipt->purchaseOrder->vendor->name}}</b>
                                        <p style="font-size: 11px; margin-top:10px">{{$modelGRT->goodsReceipt->purchaseOrder->vendor->address}} <br>T.{{$modelGRT->goodsReceipt->purchaseOrder->vendor->phone_number_1}}</p>
                                    @elseif($modelGRT->goodsReceipt->work_order_id != null)
                                        <b style="font-size: 12px;">{{$modelGRT->goodsReceipt->workOrder->vendor->name}}</b>
                                        <p style="font-size: 11px; margin-top:10px">{{$modelGRT->goodsReceipt->workOrder->vendor->address}} <br>T.{{$modelGRT->goodsReceipt->workOrder->vendor->phone_number_1}}</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:-100px; padding-top: -10px">
                        <div style="margin-left: 450px;">
                            <div style="font-size: 11px;">Goods Return Number  </div>
                            <div class="p-l-5" style="font-size: 11px; margin-left: 120px; margin-top:-20px">
                                {{$modelGRT->number}}
                            </div>
                        </div>
                        <div style="margin-left: 450px; ">
                            <div style="font-size: 11px;">Date  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{date("d-m-Y", strtotime($modelGRT->created_at))}}
                            </div>
                        </div>
                        <div  style="margin-left: 450px;">
                            @if($modelGRT->purchase_order_id != null)
                            <div style="font-size: 11px;">PO Number  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{$modelGRT->purchaseOrder->number}}
                            </div>
                            @elseif($modelGRT->goods_receipt_id != null)
                                <div style="font-size: 11px;">Goods Receipt Number  </div>
                                <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                    {{$modelGRT->goodsReceipt->number}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main>
            <div class="row">
                <div class="col-xs-12">
                    <div>
                        <table class="table-bordered" id="goods_return_pdf" style="width: 100%; margin-left: -10px">
                            <thead>
                                <tr>
                                    <th style="font-size: 11px" width="5%" class="text-center">No</th>
                                    <th style="font-size: 11px" width="30%" class="text-center" >Material Number</th>
                                    <th style="font-size: 11px" width="30%" class="text-center" >Material Description</th>
                                    <th style="font-size: 11px" width="10%" class="text-center" >Unit</th>
                                    <th style="font-size: 11px" width="10%" class="text-center">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modelGRT->goodsReturnDetails as $GRTD)
                                    @if($GRTD->quantity > 0)
                                        <tr>
                                            <td style="font-size: 11px" width="4%">{{ $loop->iteration }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px; padding-left:4px;" width="20%" class="tdBreakWord">{{ $GRTD->material->code }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px; padding-left:4px;" width="20%" class="tdBreakWord">{{ $GRTD->material->description }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="6%" class="tdBreakWord text-center">{{ $GRTD->material->uom->unit }}</td>
                                            <td style="font-size: 11px" width="10%" class="tdBreakWord text-center">{{ number_format($GRTD->quantity) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div id="footer" style="page-break-inside:avoid;margin-left: -10px; ">
                            <div>
                                <div style="margin-top: 10px; margin-left: 50px; font-size: 12px">Received by,</div>
                                <hr style="margin-left: 50px; margin-top: 45px; width:145px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-left: 50px;margin-top: -20px;font-size: 11px">Date</div>
                            </div>
                            <div style="margin-left: 250px; margin-top:-150px">
                                <div style="margin-top: 10px; margin-left: 55px; font-size: 12px">Carrier,</div>
                                <hr style="margin-left: 55px; margin-top: 45px; width:145px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-left: 55px;margin-top: -20px;font-size: 11px">Date</div>
                            </div>
                            <div style="margin-left: 500px; margin-top:-150px">
                                <div style="margin-top: 10px; margin-left: 55px; font-size: 12px">Best Regards,</div>
                                <hr style="margin-left: 55px; margin-top: 45px; width:145px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-left: 55px;margin-top: -20px;font-size: 11px">Date</div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </main>
    </body>
</html>
