<header class="header">
    <a href="{{ URL::to('/admin/dashboard') }}" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        MyMeals
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span>{{ Auth::user()->username }} <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <img src="{{ URL::asset('img/avatar3.png') }}" class="img-circle" alt="User Image" />
                            <p>
                                {{ Auth::user()->username }}
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                                   <div class="col-xs-7 text-center">
                                        <a href="{{ URL::to('/admin/changepassword') }}" >Change password</a>                                      
                                    </div>
                                    <div class="col-xs-4 text-center">
                                       <a href="{{ URL::to('/admin/profile') }}" >Profile</a>
                                    </div>                                    
                                </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                           
                            <div class="pull-right">
                                <a href="{{ URL::to('/auth/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>