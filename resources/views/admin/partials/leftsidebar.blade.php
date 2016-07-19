<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ URL::asset('img/avatar3.png') }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Hello, {{ Auth::user()->username }}</p>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="{{ Ekko::isActiveURL('/admin/dashboard') }}">
                <a href="{{ URL::to('/admin/dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Ekko::isActiveURL('/admin/users') }}">
                <a href="{{ URL::to('/admin/users') }}">
                    <i class="fa fa-group"></i> Users 
                </a>
            </li>
            
            <li class="{{ Ekko::isActiveURL('/admin/items') }}">
                <a href="{{ URL::to('/admin/items') }}">
                    <i class="fa fa-cubes"></i> Items 
                </a>
            </li>
            
            <li class="{{ Ekko::isActiveURL('/admin/meals') }}">
                <a href="{{ URL::to('/admin/meals') }}">
                    <i class="fa fa-cutlery"></i> Meals 
                </a>
            </li>
            
<!--            <li class="">
                <a href="#">
                    <i class="fa fa-shopping-cart"></i> Orders 
                </a>
            </li>-->
            <li class="{{ Ekko::isActiveURL('/admin/offers') }}">
                <a href="{{ URL::to('/admin/offers') }}">
                    <i class="fa fa-money"></i> Offers 
                </a>
            </li>
            
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>