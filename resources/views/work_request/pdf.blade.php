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
                        <h2 class="pull-right" style="margin-top: -70px; margin-right:40px;"><b>Work Request</b></h2>
                    </div>
                    <hr style="height:1.5px;border:none;color:#333;background-color:#333;" />
                    <div>
                        <div>
                            <div style="font-size: 11px;">Vendor   :</div>
                            <div class="p-l-5" style="word-wrap:break-word;width: 340px; border: black 1px solid; border-radius: 5px; margin-left: 65px; margin-top: -50px;">
                                <b style="font-size: 12px;">-</b>
                                <p style="font-size: 11px; margin-top:10px"></p>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:-100px; padding-top: -10px">
                        <div style="margin-left: 450px;">
                            <div style="font-size: 11px;">WR Number  </div>
                            <div class="p-l-5" style="font-size: 11px; margin-left: 120px; margin-top:-20px">
                                {{$modelWR->number}}             
                            </div>
                        </div>
                        <div style="margin-left: 450px; ">
                            <div style="font-size: 11px;">WR Date  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{$modelWR->created_at}}                    
                            </div>
                        </div>
                        <div  style="margin-left: 450px;">
                            <div style="font-size: 11px;">Payment Terms  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                -                    
                            </div>
                        </div>
                        <div  style="margin-left: 450px;">
                            <div style="font-size: 11px;">Delivery Date  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                -                    
                            </div>
                        </div>
                        <div  style="margin-left: 450px;">
                            <div style="font-size: 11px;">Job  </div>
                            <div class="p-l-5" style="font-size: 11px; margin-left: 120px; margin-top:-20px">
                                -                 
                            </div>
                        </div>
                        <div  style="margin-left: 450px;">
                            <div style="font-size: 11px;">Requestor  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{$modelWR->user->name}}                  
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
                        <table class="table-bordered" id="work_request_pdf" style="width: 100%; margin-left: -10px">
                            <thead>
                                <tr>
                                    <th style="font-size: 11px" width="4%" class="text-center">No</th>
                                    <th style="font-size: 11px" width="20%" class="text-center" >Material Number</th>
                                    <th style="font-size: 11px" width="20%" class="text-center" >Material Description</th>
                                    <th style="font-size: 11px" width="6%" class="text-center" >Unit</th>
                                    <th style="font-size: 11px" width="10%" class="text-center">Description</th>
                                    <th style="font-size: 11px" width="10%" class="text-center">Type</th>
                                    <th style="font-size: 11px" width="12%" class="text-center">Required Date</th>
                                    <th style="font-size: 11px" width="8%" class="text-center">Qty</th>
                                    <th style="font-size: 11px" width="13%" class="text-center">Price / pcs</th>
                                    <th style="font-size: 11px" width="6%" class="text-center">Disc (%)</th>
                                    <th style="font-size: 11px" width="17%" class="text-center">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modelWR->workRequestDetails as $WRD)
                                    @if($WRD->quantity > 0)
                                        <tr>
                                            <td style="font-size: 11px" class="text-center" width="4%">{{ $loop->iteration }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px; padding-left:4px;" width="20%" class="tdBreakWord">{{ $WRD->material->code }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px; padding-left:4px;" width="20%" class="tdBreakWord">{{ $WRD->material->description }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px; padding-left:4px;" width="6%" class="tdBreakWord">{{ $WRD->material->uom->unit }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px; padding-left:4px;" width="30%" class="tdBreakWord">{{ $WRD->description }}</td>
                                            <td style="font-size: 11px" width="10%" class="tdBreakWord text-center">{{ ($WRD->type == 0) ? "Raw Material" : "Finished Goods"}} </td>
                                            <td style="font-size: 11px" width="12%" class="tdBreakWord text-center">{{ ($WRD->required_date != null) ? date("d-m-Y", strtotime($WRD->required_date)) : "-"}} </td>
                                            <td style="font-size: 11px" width="8%" class="tdBreakWord text-center">{{ number_format($WRD->quantity) }}</td>
                                            <td style="font-size: 11px" width="13%" class="tdBreakWord text-center">-</td>
                                            <td style="font-size: 11px" width="6%" class="tdBreakWord text-center">-</td>
                                            <td style="font-size: 11px" width="17%" class="tdBreakWord text-center">-</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div id="footer" style="page-break-inside:avoid;margin-left: -10px; ">
                            <div class="col-xs-12" style="margin-top:3px; width:230px;padding-left:5px; border: black 1px solid; border-radius: 5px; height:80px;">
                                <div style="font-size: 11px"><b>Description</b></div>
                                <div style="font-size: 11px">{{$modelWR->description}}</div>
                            </div>
                            <div>
                                <div style="margin-left: 300px; margin-top: 3px; font-size: 11px">Prepared By</div>
                                <hr style="margin-left: 300px; margin-top: 45px; width:100px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-left: 300px;margin-top: -20px;font-size: 11px">Date</div>
                            </div>
                            <div style="margin-left: 440px; margin-top:-150px">
                                <div style="margin-top: 3px; font-size: 11px">Aproved By</div>
                                <hr style="margin-left: 0px; margin-top: 45px; width:100px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-top: -20px;font-size: 11px">Date</div>
                            </div>
                            <div style="margin-left: 580px; margin-top:-150px">
                                <div style="margin-top: 3px; font-size: 11px">Supplier Confirmation</div>
                                <hr style="margin-left: 0px; margin-top: 45px; width:100px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="font-size: 11px; margin-top: -20px;">Chop and Sign</div>
                                <div style="font-size: 11px">Date</div>
                            </div>
                        </div>
                    </div> 
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </main>
    </body>
</html>
