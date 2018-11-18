<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>ERP - PATRIA</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        @stack('style')
    </head>
    <body class="{{ $defaultSkin->default ?? 'skin-blue' }} sidebar-mini fixed">
        <div class="wrapper">
            <header class="main-header">
                @include('includes.header')
            </header>

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                @include('includes.sidenav')
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    @yield('content-header')
                </section>

                <!-- Main content -->
                <section class="content p-b-0">
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
        </script>
        @stack('script')
    </body>
</html>
