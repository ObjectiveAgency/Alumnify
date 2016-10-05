<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <title>Alumnify</title>
    <link rel="stylesheet" type="text/css" href="/assets/lib/stroke-7/style.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/lib/jquery.nanoscroller/css/nanoscroller.css"/><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('css')

    <link rel="stylesheet" href="/assets/css/style.css" type="text/css"/>
  </head>
  <body>
    <div class="am-wrapper">
      <nav class="navbar navbar-default navbar-fixed-top am-top-header">
        <div class="container-fluid">
          <div class="navbar-header">

            <!-- header on mobile devices -->
            <div class="page-title">
              <span>Dashboard</span>
            </div>

            <a href="#" class="am-toggle-left-sidebar navbar-toggle collapsed">
              <span class="icon-bar">
                <span></span>
                <span></span>
                <span></span>
              </span>
            </a>

            <a href="/dashboard" class="navbar-brand"></a>

          </div>
          
          <!-- <a href="#" class="am-toggle-right-sidebar">
            <span class="icon s7-menu2"></span>
          </a>

          <a href="#" data-toggle="collapse" data-target="#am-navbar-collapse" class="am-toggle-top-header-menu collapsed">
            <span class="icon s7-angle-down"></span>
          </a> -->

          <div id="am-navbar-collapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right am-user-nav">
              <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle">{{ Auth::user()->name }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="/assets/img/uploads/{{ Auth::user()->image }}"><span class="user-name">Samantha Amaretti</span><span class="angle-down s7-angle-down"></span></a>
                <ul role="menu" class="dropdown-menu">
                  <li><a href="{{ url('/profile') }}"> <span class="icon s7-user"></span>My profile</a></li>
                  <li><a href="{{ url('/settings') }}"> <span class="icon s7-config"></span>Settings</a></li>
                  <li><a href="{{ url('/logout') }}"> <span class="icon s7-power"></span>Sign Out</a></li>
                </ul>
              </li>
            </ul>

            <ul class="nav navbar-nav navbar-right am-icons-nav">
              <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"></a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <div class="am-left-sidebar">
        <div class="content">
          <div class="am-logo"></div>
          <ul class="sidebar-elements">

          @if( ! empty(Auth::user()->OAuth))
            <li class="parent {{ Request::is('dashboard*') ? 'active' : '' }}"><a href="/dashboard"><i class="icon s7-graph1"></i><span>Dashboard</span></a></li>
            <li class="parent {{ Request::is('campaign*') ? 'active' : '' }}"><a href="/campaign"><i class="icon s7-speaker"></i><span>Campaigns</span></a></li>
            <li class="parent {{ Request::is('subscribers*') ? 'active' : '' }}"><a href="/subscribers"><i class="icon s7-users"></i><span>Subscribers</span></a></li>
          @endif
            <li class="parent {{ Request::is('connections*') ? 'active' : '' }}"><a href="/connections"><i class="icon s7-plug"></i><span>Connections</span></a></li>
          </ul>
          <!--Sidebar bottom content-->
        </div>
      </div>



      @yield('content')



      </div>


      

    <script src="/assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="/assets/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/lib/jquery.nanoscroller/javascripts/jquery.nanoscroller.min.js" type="text/javascript"></script>
    <script src="/assets/js/main.js" type="text/javascript"></script>
    

    @yield('javascripts')
    
  </body>
</html>