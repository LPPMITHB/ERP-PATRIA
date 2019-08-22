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
                    margin-top:230px;
                    margin-bottom : 130px;
                }

                /** Define the header rules **/
                header {
                    position: fixed;
                    top: -175px;
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
                            @if($route == '/physical_inventory')
                            <img src="{{ asset('images/logo-PMP.png') }}" alt="" srcset="">
                            @elseif($route == '/physical_inventory_repair')
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
                        <h2 class="pull-right" style="margin-top: -70px; margin-right:40px;"><b>Stock Take</b></h2>
                    </div>
                    <hr style="height:1.5px;border:none;color:#333;background-color:#333;" />
                    <div style="margin-top:-100px; padding-top: 5px">
                        <div style="margin-left: 450px;">
                            <div style="font-size: 11px;">PI Number  </div>
                            <div class="p-l-5" style="font-size: 11px; margin-left: 120px; margin-top:-20px">
                                {{$modelSnapshot->code}}
                            </div>
                        </div>
                        <div style="margin-left: 450px; ">
                            <div style="font-size: 11px;">Date  </div>
                            <div class="p-l-5" style="font-size: 11px;margin-left: 120px; margin-top:-20px">
                                {{date("d-m-Y", strtotime($modelSnapshot->created_at))}}
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
                        <table class="table-bordered" id="snapshot_pdf" style="width: 100%; margin-left: -10px">
                            <thead>
                                <tr>
                                    <th style="font-size: 11px" width="5%" class="text-center">No</th>
                                    <th style="font-size: 11px" width="15%" class="text-center" >Material Number</th>
                                    <th style="font-size: 11px" width="25%" class="text-center" >Material Description</th>
                                    <th style="font-size: 11px" width="5%" class="text-center" >Unit</th>
                                    <th style="font-size: 11px" width="20%" class="text-center" >Storage Location</th>
                                    <th style="font-size: 11px" width="20%"  class="text-center">Location Detail</th>
                                    <th style="font-size: 11px" width="5%" class="text-center">Stock Quantity</th>
                                    <th style="font-size: 11px" width="5%" class="text-center">Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modelSnapshot->snapshotDetails as $SNPD)
                                    @if($SNPD->quantity > 0)
                                        <tr>
                                            <td style="font-size: 11px" width="5%">{{ $loop->iteration }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px; padding-left:4px;" width="20%" class="tdBreakWord">{{ $SNPD->material->code }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px; padding-left:4px;" width="25%" class="tdBreakWord">{{ $SNPD->material->description }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px;" width="10%" class="tdBreakWord text-center">{{ $SNPD->material->uom->unit }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px; padding-left:4px;" width="20%" class="tdBreakWord text-center">{{ $SNPD->storageLocation->name }}</td>
                                            <td style="font-size: 11px; padding-top:2px; padding-bottom:2px; padding-left:4px;" width="20%" class="tdBreakWord text-center">{{ $SNPD->material->location_detail }}</td>
                                            <td style="font-size: 11px" width="10%" class="tdBreakWord text-center">{{ number_format($SNPD->quantity) }}</td>
                                            <td style="font-size: 11px" width="10%" class="tdBreakWord text-center"></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div id="footer" style="page-break-inside:avoid;margin-left: -10px; ">
                            {{-- <div>
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
                            </div> --}}
                        </div>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </main>
    </body>
</html>
