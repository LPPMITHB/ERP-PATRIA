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
                                Kav.20 Dapur 12 Sei Lekop
                            </div>
                            <div class="col-sm-12" style="font-size: 11px;line-height: 13px">
                                Sagulung, Batam
                            </div>
                            <div class="col-sm-12" style="font-size: 11px;line-height: 15px">
                                T. 0778-7367111 F.0778-7367112
                            </div>
                        </div>
                        <h2 class="pull-right" style="margin-top: -70px; margin-right:40px;"><b>Work Order</b></h2>
                    </div>
                    <hr style="height:1.5px;border:none;color:#333;background-color:#333;" />
                    <div>
                        <div class="box-body">
                            <div style="font-size: 11px;">Vendor   :</div>
                            <div class="p-l-5" style="word-wrap:break-word;width: 340px; border: black 1px solid; border-radius: 5px; margin-left: 65px; margin-top: -50px;">
                                <b style="font-size: 12px;">{{$modelWO->vendor->name}}</b>
                                <p style="font-size: 11px; margin-top:10px">{{$modelWO->vendor->address}} <br>T.{{$modelWO->vendor->phone_number_1}}</p>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:-155px">
                        <div class="box-body" style="margin-left: 450px; margin-top:-20px">
                            <div style="font-size: 11px;">WO Number  </div>
                            <div class="p-l-5" style="font-size: 11px; margin-left: 120px; margin-top:-20px">
                                {{$modelWO->number}}                    
                            </div>
                        </div>
                        <div class="box-body" style="margin-left: 450px; margin-top:-18px">
                            <div style="font-size: 11px;">WO Date  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{date("d-m-Y", strtotime($modelWO->created_at))}}                    
                            </div>
                        </div>
                        <div class="box-body" style="margin-left: 450px; margin-top:-20px">
                            <div style="font-size: 11px;">PR Number  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{$modelWO->workRequest->number}}                    
                            </div>
                        </div>
                        <div class="box-body" style="margin-left: 450px; margin-top:-20px">
                            <div style="font-size: 11px;">Payment Terms  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                -                    
                            </div>
                        </div>
                        <div class="box-body" style="margin-left: 450px; margin-top:-20px">
                            <div style="font-size: 11px;">Delivery Date  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                -                    
                            </div>
                        </div>
                        <div class="box-body" style="margin-left: 450px; margin-top:-20px">
                            <div style="font-size: 11px;">Job  </div>
                            <div class="p-l-5" style="font-size: 11px; margin-left: 120px; margin-top:-20px">
                                -                 
                            </div>
                        </div>
                        <div class="box-body" style="margin-left: 450px; margin-top:-20px">
                            <div style="font-size: 11px;">Requestor  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{$modelWO->user->name}}                  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div style="line-height:11px;margin-left: -755px; margin-top: 241px; word-wrap:break-word;width: 720px;">
                        <i style="font-size: 9px;"><b>Please deliver all the items mentioned to the above address according to agreed delivery date and according to the terms of payment as indicated. Please quote the PO number in all succeeding communications (DO and Invoice) for reference</b></i>
                    </div>
                </div>
            </div>
        </header>
        <main style="margin-top: -15px">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-body" >
                        <table class="table-bordered" id="work_order_pdf" style="width: 103%; margin-left: -10px">
                            <thead>
                                <tr>
                                    <th style="font-size: 11px" width="4%" class="text-center">No</th>
                                    <th style="font-size: 11px" width="20%" class="text-center" >Material Name</th>
                                    <th style="font-size: 11px" width="30%" class="text-center">Description</th>
                                    <th style="font-size: 11px" width="10%" class="text-center">Qty</th>
                                    <th style="font-size: 11px" width="13%" class="text-center">Price / pcs</th>
                                    <th style="font-size: 11px" width="6%" class="text-center">Disc (%)</th>
                                    <th style="font-size: 11px" width="17%" class="text-center">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modelWO->workOrderDetails as $WOD)
                                    @if($WOD->quantity > 0)
                                        <tr>
                                            <td style="font-size: 11px" width="4%">{{ $loop->iteration }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="20%" class="tdBreakWord">{{ $WOD->material->code }} - {{ $WOD->material->name }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="30%" class="tdBreakWord">{{ $WOD->workRequestDetail->description }}</td>
                                            <td style="font-size: 11px" width="10%" class="tdBreakWord text-center">{{ number_format($WOD->quantity) }}</td>
                                            <td style="font-size: 11px" width="13%" class="tdBreakWord text-right">{{ number_format($WOD->total_price / $WOD->quantity,2) }}</td>
                                            <td style="font-size: 11px" width="6%" class="tdBreakWord text-center">{{ number_format($WOD->discount,2) }}</td>
                                            <td style="font-size: 11px" width="17%" class="tdBreakWord text-right">{{ number_format($WOD->total_price - ($WOD->total_price * ($WOD->discount/100)),2) }}</td>
                                        </tr>
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
                                <div style="font-size: 11px">Note</div>
                                <div style="font-size: 11px">{{$modelWO->description}}</div>
                            </div>
                            <div style="margin-left: 430px; margin-top: -20px">
                                <div style="width:265px; margin-left:30px; margin-top:-5px; border: black 1px solid; border-radius: 5px;">
                                    <div style="margin-left: 48px; font-size: 12px">Sub Total</div>
                                    <div style="margin-left: 103px; margin-top:-20px; font-size: 12px">:</div>
                                    <div class="p-r-5" style="margin-top:-20px; font-size: 12px" align="right">{{number_format($modelWO->workOrderDetails->sum('total_price'),2)}}</div>
                                    <div style="margin-left: 52px; font-size: 12px">Discount</div>
                                    <div style="margin-left: 103px; margin-top:-20px; font-size: 12px">:</div>
                                    <div class="p-r-5" style="margin-top:-20px; font-size: 12px" align="right">{{number_format($modelWO->workOrderDetails->sum('total_price') - $modelWO->total_price,2)}}</div>
                                </div>
                                <div style="width:265px; margin-left:30px; margin-top:3px; border: black 1px solid; border-radius: 5px;">
                                    <div style="margin-left: 79px; font-size: 12px">Tax</div>
                                    <div style="margin-left: 103px; margin-top:-20px; font-size: 12px">:</div>
                                    <div class="p-r-5" style="margin-top:-20px; font-size: 12px" align="right">0</div>
                                </div>
                                <div style="width:265px; margin-left:30px; margin-top:3px; border: black 1px solid; border-radius:05px;">
                                    <div style="margin-left: 6px; font-size: 12px">Estimated Freight</div>
                                    <div style="margin-left: 103px; margin-top:-20px; font-size: 12px">:</div>
                                    <div class="p-r-5" style="margin-top:-20px; font-size: 12px" align="right">0</div>
                                </div>
                                <div style="width:265px; margin-left:30px; margin-top:3px; border: black 1px solid; border-radius: 5px;">
                                    <div style="margin-left: 36px; font-size: 12px"><b>Total Order</b></div>
                                    <div style="margin-left: 103px; margin-top:-20px; font-size: 12px"><b>:</b></div>
                                    <div class="p-r-5" style="margin-top:-20px; font-size: 12px" align="right"><b>IDR {{number_format($modelWO->total_price,2)}}</b></div>
                                </div>
                            </div>
                            <div>
                                <div style="margin-top: 10px; font-size: 12px">Prepared by</div>
                                <hr style="margin-left: 0px; margin-top: 60px; width:200px;height:0.5px;border:none;color:#333;background-color:#333;" />
                            </div>
                            <div style="margin-left: 250px; margin-top:-150px">
                                <div style="margin-top: 10px; font-size: 12px">Aproved by</div>
                                <hr style="margin-left: 0px; margin-top: 60px; width:200px;height:0.5px;border:none;color:#333;background-color:#333;" />
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
