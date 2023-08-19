<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: {{ Config::get('constants.SIDEBAR_COLOR') }}; z-index: 1000;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('/public/img/logo.png') }}" alt="Laravel Starter" class="brand-image img-circle elevation-3"
        style="opacity: .8">
        <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('admin/dashboard') }}" class="nav-link {!! classActiveSegment(2, 'dashboard') !!}">
                        <i class="nav-icon fa fa-th"></i>
                        <p>
                          Dashboard
                      </p>
                  </a>
              </li>
               <li class="nav-item">
                    <a href="{{ url('admin/users') }}" class="nav-link {!! classActiveSegment(2, 'users') !!}">
                        <i class="nav-icon fa fa-th"></i>
                        <p>
                          Users
                      </p>
                  </a>
              </li>
          </ul>
      </nav>
      <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>