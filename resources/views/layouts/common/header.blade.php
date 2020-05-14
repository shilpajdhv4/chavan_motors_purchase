<header class="main-header" style="font-weight: bold">
    <!-- Logo -->
<!--   <a href="" class="logo">
       mini logo for sidebar mini 50x50 pixels 
      <span class="logo-mini"></span>
       logo for regular state and mobile devices 
      <span class="logo-lg"><b>Chavan  </b>Motors</span>
    </a>-->
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <a href="#" style="float: left; background-color: transparent; background-image: none;padding: 15px 15px;font-family: fontAwesome;" >
          <span style="">@yield('title')</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        
          <li class="dropdown user user-menu">
            <a class="dropdown-item" href="{{ url('logout') }}"
                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }} ({{Auth::user()->name}})
            </a>

            <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>  
          </li>
        </ul>
      </div>
    </nav>
  </header>