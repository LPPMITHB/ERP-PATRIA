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
                    margin-top:210px;
                    margin-bottom : 100px;
                }

                /** Define the header rules **/
                header {
                    position: fixed;
                    top: -180px;
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
                        <h2 class="pull-right" style="margin-top: -70px; margin-right:40px;"><b>Goods Issue</b></h2>
                    </div>
                    <hr style="height:1.5px;border:none;color:#333;background-color:#333;" />
                </div>
            </div>
            <table class="table-bordered" style="width: 103%; margin-left: -10px">
                <tbody>
                    <tr>
                        <td style="font-size: 11px; padding-left:5px;" colspan="2">JOB NO : {{$modelGI->materialRequisition->project != null ? $modelGI->materialRequisition->project->number : "-"}}</td>
                        <td style="font-size: 11px; padding-left:5px;">MR NO : {{$modelGI->materialRequisition->number}}</td>
                        <td style="font-size: 11px; padding-left:5px;">DATE : {{$modelGI->created_at}}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 11px; padding-left:5px;" colspan="3">REBILL TO :</td>
                        <td style="font-size: 11px; padding-left:5px;">PAGE :</td>
                    </tr>
                </tbody>
            </table>
        </header>
        <main style="margin-top: -5px">
            <div class="row">
                <div class="col-xs-12">
                    <div>
                        <table class="table-bordered" id="work_order_pdf" style="width: 103%; margin-left: -10px">
                            <thead>
                                <tr>
                                    <th style="font-size: 11px" width="4%" class="text-center">NO</th>
                                    <th style="font-size: 11px" width="20%" class="text-center" >ITEM NO</th>
                                    <th style="font-size: 11px" width="30%" class="text-center">ITEM DESCRIPTION</th>
                                    <th style="font-size: 11px" width="10%" class="text-center">U/M</th>
                                    <th style="font-size: 11px" width="13%" class="text-center">QUANTITY</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modelGI->goodsIssueDetails as $GID)
                                    @if($GID->quantity > 0)
                                        <tr>
                                            <td style="font-size: 11px" width="4%">{{ $loop->iteration }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="20%" class="tdBreakWord">{{ $GID->material->code }} - {{ $GID->material->name }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="30%" class="tdBreakWord">{{ $GID->material->description }}</td>
                                            <td style="font-size: 11px" width="10%" class="tdBreakWord">{{ $GID->material->uom->unit     }}</td>
                                            <td style="font-size: 11px" width="13%" class="tdBreakWord">{{ number_format($GID->quantity) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div id="footer" style="page-break-inside:avoid;margin-left: -10px; ">
                            <table class="table-bordered" style="width: 103%; margin-left: -10px">
                                <tbody>
                                    <tr>
                                        <td class="text-center" height="20" style="font-size: 11px; padding-left:5px; width: 40px"></td>
                                        <td class="text-center" height="20" style="font-size: 11px; padding-left:5px;">Requested By</td>
                                        <td class="text-center" height="20" style="font-size: 11px; padding-left:5px;">Authorised By</td>
                                        <td class="text-center" height="20" style="font-size: 11px; padding-left:5px;">Issued By</td>
                                        <td class="text-center" height="20" style="font-size: 11px; padding-left:5px;">Received By</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" height="20" style="font-size: 11px; padding-left:5px;">Name</td>
                                        <td height="20" style="font-size: 11px; padding-left:5px;">{{$modelGI->materialRequisition->user->name}}</td>
                                        <td height="20" style="font-size: 11px; padding-left:5px;"></td>
                                        <td height="20" style="font-size: 11px; padding-left:5px;"></td>
                                        <td height="20" style="font-size: 11px; padding-left:5px;"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" height="20" style="font-size: 11px; padding-left:5px;">Sign</td>
                                        <td height="20" style="font-size: 11px; padding-left:5px;"></td>
                                        <td height="20" style="font-size: 11px; padding-left:5px;"></td>
                                        <td height="20" style="font-size: 11px; padding-left:5px;"></td>
                                        <td height="20" style="font-size: 11px; padding-left:5px;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </main>
    </body>
</html>
