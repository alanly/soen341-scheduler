<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>schdlr. &ndash; @yield('page_title')</title>

    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/bootstrap/2.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/fontawesome/3.0.2/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <style>
      @yield('page_styles')
    </style>
    <link href="//cdn.jsdelivr.net/bootstrap/2.3.1/css/bootstrap-responsive.min.css" rel="stylesheet">
  </head>
  <body>
    <header id="main-head" class="container-fluid">
    <h1 class="pull-left"><a href="/">schdlr.</a></h1>

      @if(Auth::check())
      <nav id="main-nav" class="pull-right">
        <ul class="nav nav-pills">
          <li{{ Request::is('/') ? ' class="active"' : ''  }}><a href="/"><i class="icon-dashboard"></i> Dashboard</a></li>
          <li{{ Request::is('schedule*') ? ' class="active"' : '' }}><a href="/schedule"><i class="icon-calendar"></i> Schedules</a></li>
          <li{{ Request::is('course*') ? ' class="active"' : '' }}><a href="/course"><i class="icon-book"></i> Courses</a></li>
          <li{{ Request::is('academicrecord*') ? ' class="active"' : '' }}><a href="/academicrecord"><i class="icon-list-ol"></i> Academic Record</a></li>
          <li{{ Request::is('profile*') ? ' class="active"' : '' }}><a href="/profile"><i class="icon-user"></i> Profile</a></li>
          <li><a href="/logout"><i class="icon-signout"></i> Logout</a></li>
        </ul>
      </nav>
      @endif 
    </header>

    <hr>

    <section id="main-content" class="container-fluid">
      @yield('page_content')
    </section>

    <hr>

    <footer id="main-foot" class="container-fluid">
      <div class="row-fluid">
        <p class="muted pull-left"><small>2013 &copy; Team Dolla Dolla Bill Y'all.</small></p>

        @if( Auth::check() && Auth::user()->is_admin == 1 )
          @if( Request::is('admin*') )
            <p class="pull-right"><a href="/"><i class="icon-road"></i> Switch to Regular Interface</a></p>
          @else
            <p class="pull-right"><a href="/admin"><i class="icon-cogs"></i> Switch to Administrative Interface</a></p>
          @endif
        @endif

        @yield('page_footer_nav')
      </div>
    </footer>

    <script src="//cdn.jsdelivr.net/jquery/1.9.1/jquery-1.9.1.min.js"></script>
    <script src="//cdn.jsdelivr.net/bootstrap/2.3.1/js/bootstrap.min.js"></script>
    @yield('page_scripts')
  </body>
</html>
