<!-- Logo -->
<a href="{{ route('index') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>ERP</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>ERP-PATRIA</b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- Notifications: style can be found in dropdown.less -->
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="{{ route('user.show', ['id' => Auth::user()->id ]) }}">
            <span class="hidden-xs">{{ auth()->user()->name }}</span>
            <span class="mobile_view"><i class="fa fa-user"></i></span>
          </a>
        </li>
        <!-- Logout Button -->
        <li class="dropdown user user-menu">
          <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <span class="hidden-xs">Sign Out</span> <i class="fa fa-sign-out"></i></a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </li>
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            @if(auth()->user()->role->notifications->where('status',1)->count())
            <span class="label label-warning">{{ auth()->user()->role->notifications->where('status',1)->count() }}</span>
            @endif
          </a>
          <ul class="dropdown-menu" style="width: 550px">
              @if(auth()->user()->role->notifications->where('status',1)->count())
                <li class="header">You have {{ auth()->user()->role->notifications->where('status',1)->count() }} new notifications</li>
                  @foreach(auth()->user()->role->notifications as $notification)
                  @php
                    $data = json_decode($notification->data);
                    $now = new DateTime(date("Y-m-d"));
                    $notification_date = new DateTime($notification->notification_date);
                    $interval = $notification_date->diff($now);
                  @endphp
                  <li>
                      <a href="{{$data->url}}">
                        <div class="row">
                          <div style="width: 20px;" class="col-sm-1">
                            @if($data->title == "Activity")
                              <i style="font-size: 25px" class="fa fa-suitcase text-aqua m-t-7"></i>
                            @endif
                          </div>
                          <div class="col-sm-11">
                            <div class="col-sm-12"><b>{{$data->title}}</b></div>
                            <div class="col-sm-12">{{$interval->days}} Day(s) {{ $data->text }}</div>
                          </div>
                        </div>
                      </a>
                  </li>
                  @endforeach
              @else
                <li class="header">You have no new notifications</li>
              @endif
            <li class="footer"><a href="#">View all</a></li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>
      </ul>
    </div>
  </nav>