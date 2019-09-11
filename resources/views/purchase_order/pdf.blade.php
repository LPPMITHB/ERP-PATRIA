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
                    margin-bottom : 240px;
                }

                /** Define the header rules **/
                header {
                    position: fixed;
                    top: -268px;
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
                if ( isset($pdf) ) {
                    $x = 540;
                    $y = 5;
                    $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
                    $font = null;
                    $size = 9;
                    $color = array(0,0,0);
                    $word_space = 0.0;  //  default
                    $char_space = 0.0;  //  default
                    $angle = 0.0;   //  default
                    $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
                }
            }
        </script>
        <header>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header no-padding" style="margin-bottom : 47px">
                        <div class="col-sm-3 col-md-3 col-lg-3 no-padding-left m-b-7">
                            @if($route == '/purchase_order')
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
                        <h2 class="pull-right" style="margin-top: -70px; margin-right:40px;"><b>Purchase Order</b></h2>
                    </div>
                    <hr style="height:1.5px;border:none;color:#333;background-color:#333;" />
                    <div>
                        <div>
                            <div style="font-size: 11px;">Vendor   :</div>
                            <div class="p-l-5" style="word-wrap:break-word;width: 340px; border: black 1px solid; border-radius: 5px; margin-left: 65px; margin-top: -60px;">
                                <b style="font-size: 12px;">{{$modelPO->vendor->name}}</b>
                                <p style="font-size: 11px; margin-top:10px">{{$modelPO->vendor->address}} <br>T.{{$modelPO->vendor->phone_number_1}}</p>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:-100px; padding-top: -15px">
                        <div style="margin-left: 450px;">
                            <div style="font-size: 11px;">PO Number  </div>
                            <div class="p-l-5" style="font-size: 11px; margin-left: 120px; margin-top:-20px">
                                {{$modelPO->number}}
                            </div>
                        </div>
                        <div style="margin-left: 450px; ">
                            <div style="font-size: 11px;">PO Date  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{date("d-m-Y", strtotime($modelPO->created_at))}}
                            </div>
                        </div>
                        <div  style="margin-left: 450px;">
                            <div style="font-size: 11px;">PR Number  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{$modelPO->purchaseRequisition->number}}
                            </div>
                        </div>
                        <div  style="margin-left: 450px;">
                            <div style="font-size: 11px;">Payment Terms  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{($modelPO->payment_terms != null) ? $modelPO->payment_terms : '-'}}
                            </div>
                        </div>
                        <div  style="margin-left: 450px;">
                            <div style="font-size: 11px;">Delivery Terms  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{($modelPO->delivery_terms != null) ? $modelPO->delivery_terms : '-'}}
                            </div>
                        </div>
                        <!-- <div  style="margin-left: 450px;">
                            <div style="font-size: 11px;">Job  </div>
                            <div class="p-l-5" style="font-size: 11px; margin-left: 120px; margin-top:-20px">
                                {{($modelPO->project) ? $modelPO->project->number : '-'}}
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="col-xs-12">
                    <div style="line-height:11px;margin-left: -755px; margin-top: 241px; word-wrap:break-word;width: 720px;">
                        <i style="font-size: 9px;"><b>Please deliver all the items mentioned to the above address according to agreed delivery date and according to the terms of payment as indicated. Please quote the PO number in all succeeding communications (DO and Invoice) for reference</b></i>
                    </div>
                </div>
            </div>
        </header>
        <main style="margin-top: -5px">
            <div class="row">
                <div class="col-xs-12">
                    <div>
                        <table class="table-bordered" id="work_order_pdf" style="width: 100%; margin-left: -10px">
                            <thead>
                                <tr>
                                    <th style="font-size: 11px" width="5%" class="text-center">No</th>
                                    <th style="font-size: 11px" width="15%" class="text-center" >Material Number</th>
                                    <th style="font-size: 11px" width="20%" class="text-center">Material Description</th>
                                    <th style="font-size: 11px" width="7%" class="text-center">Requested Quantity</th>
                                    <th style="font-size: 11px" width="8%" class="text-center">Unit</th>
                                    <th style="font-size: 11px" width="15%" class="text-center">Unit Price</th>
                                    <th style="font-size: 11px" width="5%" class="text-center">Disc (%)</th>
                                    <th style="font-size: 11px" width="15%" class="text-center">Amount</th>
                                    <th style="font-size: 11px" width="10%" class="text-center">Delivery Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($discount = 0)
                                @php($tax = 0)
                                @php($freight = 0)
                                @foreach($modelPO->purchaseOrderDetails as $POD)
                                    @if($POD->quantity > 0)
                                        <tr>
                                            <td style="font-size: 11px" width="5%">{{ $loop->iteration }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="15%" class="tdBreakWord">{{ $POD->material->code }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="20%" class="tdBreakWord">{{ $POD->material->description }}</td>
                                            <td style="font-size: 11px" width="7%" class="tdBreakWord text-center">{{ number_format($POD->quantity) }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="8%" class="tdBreakWord text-center">{{ $POD->material->uom->unit }}</td>
                                            <td style="font-size: 11px" width="15%" class="tdBreakWord text-right">{{ number_format($POD->total_price / $POD->quantity,2) }}</td>
                                            <td style="font-size: 11px" width="5%" class="tdBreakWord text-center">{{ number_format($POD->discount,2) }}</td>
                                            <td style="font-size: 11px" width="15%" class="tdBreakWord text-right">{{ number_format($POD->total_price - ($POD->total_price * ($POD->discount/100)),2) }}</td>
                                            <td style="font-size: 11px" width="10%" class="tdBreakWord">{{ isset($POD->delivery_date) ? date('d-m-Y', strtotime($POD->delivery_date)) : '-' }}</td>
                                        </tr>
                                        @php($discount += $POD->total_price * (($POD->discount)/100))
                                        @php($tax += $POD->total_price * (($POD->tax)/100))
                                        @php($freight += $POD->estimated_freight)
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div id="footer" style="page-break-inside:avoid;margin-left: -10px; ">
                            <div style="font-size: 11px; margin-top:5px;">Say :</div>
                            <div style="height: 20px; font-size: 9px; width:420px; padding-left:5px; margin-left:30px; margin-top:-16px; border: black 1px solid; border-radius: 5px;">
                                    {{$words}} IDR
                            </div>
                            <div class="col-xs-12" style="margin-top:3px; width:435px;padding-left:5px; border: black 1px solid; border-radius: 5px; height:80px;">
                                <div style="font-size: 11px"><b>Description</b></div>
                                <div style="font-size: 11px">{{$modelPO->description}}</div>
                            </div>
                            <div style="margin-left: 430px; margin-top: -20px">
                                <div style="width:265px; margin-left:30px; margin-top:-5px; border: black 1px solid; border-radius: 5px;">
                                    <div style="margin-left: 48px; font-size: 12px">Sub Total</div>
                                    <div style="margin-left: 103px; margin-top:-20px; font-size: 12px">:</div>
                                    <div class="p-r-5" style="margin-top:-20px; font-size: 12px" align="right">{{number_format($modelPO->total_price,2)}}</div>
                                    <div style="margin-left: 52px; font-size: 12px">Discount</div>
                                    <div style="margin-left: 103px; margin-top:-20px; font-size: 12px">:</div>
                                    <div class="p-r-5" style="margin-top:-20px; font-size: 12px" align="right">{{number_format($discount,2)}}</div>
                                </div>
                                <div style="width:265px; margin-left:30px; margin-top:3px; border: black 1px solid; border-radius: 5px;">
                                    <div style="margin-left: 79px; font-size: 12px">Tax</div>
                                    <div style="margin-left: 103px; margin-top:-20px; font-size: 12px">:</div>
                                    <div class="p-r-5" style="margin-top:-20px; font-size: 12px" align="right">{{number_format($tax,2)}}</div>
                                </div>
                                <div style="width:265px; margin-left:30px; margin-top:3px; border: black 1px solid; border-radius:05px;">
                                    <div style="margin-left: 6px; font-size: 12px">Estimated Freight</div>
                                    <div style="margin-left: 103px; margin-top:-20px; font-size: 12px">:</div>
                                    <div class="p-r-5" style="margin-top:-20px; font-size: 12px" align="right">{{number_format($freight,2)}}</div>
                                </div>
                                <div style="width:265px; margin-left:30px; margin-top:3px; border: black 1px solid; border-radius: 5px;">
                                    <div style="margin-left: 36px; font-size: 12px"><b>Total Order</b></div>
                                    <div style="margin-left: 103px; margin-top:-20px; font-size: 12px"><b>:</b></div>
                                    <div class="p-r-5" style="margin-top:-20px; font-size: 12px" align="right"><b>IDR {{number_format(($modelPO->total_price - $discount + $tax + $freight),2)}}</b></div>
                                </div>
                            </div>
                            <div>
                                <div style="margin-top: 10px; font-size: 12px">Prepared by</div>
                                <hr style="margin-left: 0px; margin-top: 60px; width:200px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-top: -20px; font-size: 12px">{{$modelPO->user->name}}</div>
                            </div>
                            <div style="margin-left: 250px; margin-top:-150px">
                                <div style="margin-top: 10px; font-size: 12px">Aproved by</div>
                                <hr style="margin-left: 0px; margin-top: 60px; width:200px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-top: -20px; font-size: 12px">{{$modelPO->approvedBy->name}}</div>
                            </div>
                            <div style="margin-left: 500px; margin-top:-150px">
                                <div style="margin-top: 10px; font-size: 12px">Supplier Confirmation</div>
                                <hr style="margin-left: 0px; margin-top: 60px; width:200px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-top: -20px; font-size: 12px;">Chop and Sign</div>
                                <div style=" font-size: 12px">Date</div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </main>
    </body>
</html>
