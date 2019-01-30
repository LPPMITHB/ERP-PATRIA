<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>ERP - PATRIA</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
        @stack('style')
    </head>
    <body class="{{ $defaultSkin->default ?? 'skin-blue' }} sidebar-mini fixed">
        <div class="wrapper">
            <header class="main-header" id="header">
                @include('includes.header')
            </header>

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar" id="sidebar">
                @include('includes.sidenav')
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" id="content">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    @yield('content-header')
                </section>

                <!-- Main content -->
                <section class="content p-b-0 p-t-5">
                    @yield('content')
                </section>
                <!-- /.content -->
            </div>

            <!-- /.content-wrapper -->
            <footer class="main-footer">
                @include('includes.footer')
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Create the tabs -->
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs"></ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Home tab content -->
                    <div class="tab-pane" id="control-sidebar-home-tab"></div>
                <!-- /.tab-pane -->
                </div>
            </aside>

            <!-- /.control-sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        
        <!-- ./wrapper -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            $(function () {
                @include('components.iziToast');
            });

            // disabled button submit without Vue.js
            const forms = document.querySelectorAll('form');
            forms.forEach((form) => {
                form.addEventListener('submit', (e) => {
                    let formElement = e.target;
                    let buttonProcess = formElement.querySelector('button#process');
                    if(buttonProcess != null) {
                    buttonProcess.disabled = true;
                    console.log('Button has been disabled');
                    }
                });
            });
            var alreadyWrap = true;

            function myFunction(x) {
                if (x.matches) { // If media query matches
                    $('.table').wrap('<div class="dataTables_scroll" />');
                    var prevScrollpos = window.pageYOffset;
                    window.onscroll = function() {
                    var currentScrollPos = window.pageYOffset;
                    if (prevScrollpos > currentScrollPos) {
                        document.getElementById("header").style.top = "0";
                        document.getElementById("sidebar").style.top = "0";
                    } else {
                        document.getElementById("header").style.top = "-100px";
                        document.getElementById("sidebar").style.top = "-100px";
                    }
                    prevScrollpos = currentScrollPos;
                    }
                } 
            }

            var x = window.matchMedia("(max-width: 500px)")
            myFunction(x) // Call listener function at run time
            x.addListener(myFunction) // Attach listener function on state changes

            var x = window.matchMedia("(max-width: 1024px)")
            myFunction(x) // Call listener function at run time
            x.addListener(myFunction) // Attach listener function on state changes

            // table searching per coloumn with paging
            $('.tablePaging thead tr').clone(true).appendTo( '.tablePaging thead' );
            $('.tablePaging thead tr:eq(1) th').addClass('indexTable').each( function (i) {
                var title = $(this).text();
                if(title == 'Status' || title == 'No' || title == ""){
                    $(this).html( '<input disabled class="form-control width100" type="text"/>' );
                }else{
                    $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
                }

                $( 'input', this ).on( 'keyup change', function () {
                    if ( tablePaging.column(i).search() !== this.value ) {
                        tablePaging
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                });
            });
 
            var tablePaging = $('.tablePaging').DataTable( {
                orderCellsTop   : true,
                fixedHeader     : true,
                paging          : true,
                autoWidth       : false,
                lengthChange    : false,
            });

            // table searching per coloumn without paging
            $('.tableNonPaging thead tr').clone(true).appendTo( '.tableNonPaging thead' );
            $('.tableNonPaging thead tr:eq(1) th').addClass('indexTable').each( function (i) {
                var title = $(this).text();
                if(title == 'Status' || title == 'No' || title == ""){
                    $(this).html( '<input disabled class="form-control width100" type="text"/>' );
                }else{
                    $(this).html( '<input class="form-control width100" type="text" placeholder="Search '+title+'"/>' );
                }

                $( 'input', this ).on( 'keyup change', function () {
                    if ( tableNonPaging.column(i).search() !== this.value ) {
                        tableNonPaging
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                });
            });
 
            var tableNonPaging = $('.tableNonPaging').DataTable( {
                orderCellsTop   : true,
                paging          : false,
                autoWidth       : false,
                lengthChange    : false,
                info            : false,
            });

        </script>
        @stack('script')
    </body>
</html>
