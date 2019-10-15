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
                    margin-top:200px;
                    margin-bottom : 140px;
                }

                /** Define the header rules **/
                header {
                    position: fixed;
                    top: -190px;
                    left: 0cm;
                    right: 0cm;
                }
                #footer{
                    position: fixed;
                    bottom: 0px;
                    left: 10px;
                    right: 0cm;
                }
                table,td,th{
                    border: 1px black solid;
                }
        </style>
    </head>
    <body>
        <script type="text/php">
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
        </script>
        <header>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header no-padding" style="margin-bottom : 47px">
                        <div class="col-sm-3 col-md-3 col-lg-3 no-padding-left m-b-7">
                            @if($route == '/goods_issue')
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
                        <h2 class="pull-right" style="margin-top: -70px; margin-right:40px;"><b>Goods Issue</b></h2>
                    </div>
                    <hr style="height:1.5px;border:none;color:#333;background-color:#333;" />
                </div>
            </div>
            <div style="margin-top: -45px">
                <div class="p-l-5" style="height: 60px;word-wrap:break-word;width: 400px; border: black 1px solid; border-radius: 5px;margin-top: 34px;">
                    <div style="font-size: 11px"><b>Description</b></div>
                    <div style="font-size: 11px">{{$modelGI->description}}</div>
                </div>
                <div style="margin-top:-70px; padding-top:5px">
                    <div style="margin-left: 450px; ">
                        <div style="font-size: 11px;">Job No</div>
                        <div class="p-l-5" style="font-size: 11px; margin-left: 100px; margin-top:-20px">
                            : @if($modelGI->material_requisition_id != null && $modelGI->materialRequisition->project != null)
                            {{ $modelGI->materialRequisition->project->number}}
                            @else 
                            -
                            @endif
                        </div>
                    </div>
                    <div style="margin-left: 450px; ">
                        <div style="font-size: 11px;">MR Number  </div>
                        <div class="p-l-5" style="font-size: 11px;margin-left: 100px; margin-top:-20px">
                            : @if($modelGI->material_requisition_id != null)
                            {{ $modelGI->materialRequisition->number}}
                            @else
                            -
                            @endif
                        </div>
                    </div>
                    <div style="margin-left: 450px; ">
                        <div style="font-size: 11px;">Document Date  </div>
                        <div class="p-l-5" style="font-size: 11px;margin-left: 100px; margin-top:-20px">
                            : {{date("d-m-Y", strtotime($modelGI->created_at))}}
                        </div>
                    </div>
                    <div style="margin-left: 450px; ">
                        <div style="font-size: 11px;">Issued Date  </div>
                        <div class="p-l-5" style="font-size: 11px;margin-left: 100px; margin-top:-20px">
                            : {{date("d-m-Y", strtotime($modelGI->issue_date))}}
                        </div>
                    </div>
                    <div style="margin-left: 450px; ">
                        <div style="font-size: 11px;">Delivery Date  </div>
                        <div class="p-l-5" style="font-size: 11px;margin-left: 100px; margin-top:-20px">

                            : {{date("d-m-Y", strtotime($modelGI->materialRequisition->delivery_date))}}
                            : @if($modelGI->material_requisition_id != null)
                            {{date("d-m-Y", strtotime($modelGI->materialRequisition->delivery_date))}}
                            @else
                            -
                            @endif
                        </div>
                    </div>
                    <div style="margin-left: 450px; ">
                        <div style="font-size: 11px;">Rebill to  </div>
                        <div class="p-l-5" style="font-size: 11px;margin-left: 100px; margin-top:-20px">
                            :
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main style="margin-top: 30px">
            <div class="row">
                <div class="col-xs-12">
                    <div>
                        <table class="table-bordered" id="work_order_pdf" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="font-size: 11px" width="4%" class="text-center">NO</th>
                                    <th style="font-size: 11px" width="20%" class="text-center" >ITEM NO</th>
                                    <th style="font-size: 11px" width="40%" class="text-center">ITEM DESCRIPTION</th>
                                    <th style="font-size: 11px" width="13%" class="text-center">QUANTITY</th>
                                    <th style="font-size: 11px" width="7%" class="text-center">U/M</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modelGI->goodsIssueDetails as $GID)
                                    @if($GID->quantity > 0)
                                        <tr>
                                            <td style="font-size: 11px" width="4%">{{ $loop->iteration }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="20%" class="tdBreakWord">{{ $GID->material->code }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="30%" class="tdBreakWord">{{ $GID->material->description }}</td>
                                            <td style="font-size: 11px" width="13%" class="tdBreakWord">{{ number_format($GID->quantity) }}</td>
                                            <td style="font-size: 11px" width="10%" class="tdBreakWord">{{ $GID->material->uom->unit     }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div id="footer" style="page-break-inside:avoid;margin-left: -10px; ">
                            <div>
                                <div style="margin-left: 0px; margin-top: 3px; font-size: 11px">Requested By</div>
                                <hr style="margin-left: 0px; margin-top: 45px; width:75px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-top: -20px; font-size: 12px">{{$modelGI->material_requisition_id !=null ? $modelGI->materialRequisition->user->name : "-"}}</div>
                                <div style="margin-left: 0px;margin-top: 0px;font-size: 11px">Date {{$modelGI->material_requisition_id !=null ? date("d-m-Y", strtotime($modelGI->materialRequisition->created_at )) : "-"}}</div>
                            </div>
                            <div style="margin-left: 230px; margin-top:-150px">
                                <div style="margin-top: 3px; font-size: 11px">Approved By</div>
                                <hr style="margin-left: 0px; margin-top: 45px; width:75px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-top: -20px; font-size: 12px">{{$modelGI->material_requisition_id !=null ? $modelGI->materialRequisition->approvedBy->name : "-"}}</div>
                                <div style="margin-top: 0px;font-size: 11px">Date {{$modelGI->material_requisition_id !=null ? date("d-m-Y", strtotime($modelGI->materialRequisition->approval_date)) : "-"}}</div>
                            </div>
                            <div style="margin-left: 440px; margin-top:-150px">
                                <div style="margin-top: 3px; font-size: 11px">Issued By</div>
                                <hr style="margin-left: 0px; margin-top: 45px; width:75px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-top: -20px; font-size: 12px">{{$modelGI->user->name}}</div>
                                <div style="margin-top: 0px;font-size: 11px">Date {{date("d-m-Y", strtotime($modelGI->issue_date))}}</div>
                            </div>
                            <div style="margin-left: 640px; margin-top:-150px">
                                <div style="margin-top: 3px; font-size: 11px">Received By</div>
                                <hr style="margin-left: 0px; margin-top: 45px; width:75px;height:0.5px;border:none;color:#333;background-color:#333;" />
                                <div style="margin-top: 0px;font-size: 11px">Date</div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </main>
    </body>
</html>
