<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: {{ Config::get('constants.SIDEBAR_COLOR') }};z-index: 1000;">
    <a href="#" class="brand-link">
        <img src="{{ asset('/public/img/logo.png') }}" alt="Laravel Starter" class="brand-image img-circle elevation-3"
        style="opacity: .8">
        <span class="brand-text font-weight-light">{{ trans('app.Admin') }}</span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
          <input type="text" name="q" class="form-control search-menu-box" placeholder="Search..." autocomplete="off">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url(app()->getLocale().'/dashboard') }}" class="nav-link {!! classActiveSegment(2, 'dashboard') !!}">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                          {{ trans('app.Dashboard') }}
                      </p>
                  </a>
              </li>

              <?php /*
              $tab_data = \App\tbl_tab::Where('status','=','1')->OrderBy('position','ASC')->get();
              foreach ($tab_data as $tabkey) {
                $user_login_check = \App\user::Where('id','=',Auth::id())->first();

                if($user_login_check['role_type'] == null)
                {
                  $show_tab = '1';
                }
                else
                {
                  $user_login_check = \App\tbl_tab_visible::Where('role_id','=',$user_login_check['role_type'])->Where('tab_id','=',$tabkey['id'])->first();
                  if(!empty($user_login_check))
                  {
                    if($user_login_check['visible'] == '1')
                    {
                      $show_tab = '1';
                    }
                    else
                    {
                      $show_tab = '0';
                    }

                  }
                  else
                  {
                    $show_tab = '0';
                  }
                }
                if($show_tab == '1'){
                ?>
               <li class="nav-item">
                <a href="{{ url(app()->getLocale().'/'.$tabkey['url']) }}" class="nav-link {!! classActiveSegment(2, $tabkey['url']) !!}">
                  <i class="nav-icon fa fa-{{ $tabkey['icon'] }}"></i>
                  <p>
                    {{ trans('app.'.$tabkey['name']) }}
                  </p>
                </a>
              </li>
              <?php }} ?> */ ?>



               <?php
              $tab_data = \App\Models\Tbl_tab::Where('status','=','1')->Where('type','=','0')->orWhere('type','=','1')->OrderBy('position','ASC')->get();
              foreach ($tab_data as $tabkey) {
                $user_login_check = \App\Models\User::Where('id','=',Auth::id())->first();
                if($user_login_check['role_type'] == null)
                {
                  $show_tab = '1';
                }else{
                  $user_login_check = \App\Models\Tbl_tab_visible::Where('role_id','=',$user_login_check['role_type'])->Where('tab_id','=',$tabkey['id'])->first();
                  if(!empty($user_login_check))
                  {
                    if($user_login_check['visible'] == '1')
                    {
                      $show_tab = '1';
                    }else{
                      $show_tab = '0';
                    }

                  }else{
                    $show_tab = '0';
                  }
                }
                if($show_tab == '1'){
                  if($tabkey['type'] == '0'){ ?>
                   <li class="nav-item">
                    <a href="{{ url(app()->getLocale().'/'.$tabkey['url']) }}" class="nav-link {!! classActiveSegment(2, $tabkey['url']) !!}">
                      <i class="nav-icon fa fa-{{ $tabkey['icon'] }}"></i>
                      <p>
                        {{ trans('app.'.$tabkey['name']) }}
                      </p>
                    </a>
                  </li>
                <?php }else{
                    $sub_tabs = \App\Models\Tbl_tab::Where('tab_id','=',$tabkey['id'])->get();
                    $data_url  = request()->segment(2);
                    $sub_tab_active = '';
                    $sub_tab_menu = '';
                    foreach ($sub_tabs as $key1) {
                      if($key1['url'] == $data_url)
                      {
                        $sub_tab_active = 'active';
                        $sub_tab_menu = 'menu-open';
                      }
                    }
                    ?>
                  <li class="nav-item has-treeview {{ $sub_tab_menu }}">
                    <a href="#" class="nav-link {{ $sub_tab_active }}">
                      <i class="nav-icon fa fa-{{ $tabkey['icon'] }}"></i>
                      <p>
                        {{ trans('app.'.$tabkey['name']) }}
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview" style="background-color: #676767;">
                      <?php foreach ($sub_tabs as $sub_tab) {
                        $user_login = \App\Models\User::Where('id','=',Auth::id())->first();
                        if ($user_login['role_type'] == NULL) { ?>
                        <li class="nav-item">
                          <a href="{{ url(app()->getLocale().'/'.$sub_tab['url']) }}" class="nav-link {!! classActiveSegment(2, $sub_tab['url']) !!}">
                            <i class="nav-icon fa fa-{{ $sub_tab['icon'] }}"></i>
                            <p>
                              {{ trans('app.'.$sub_tab['name']) }}
                            </p>
                          </a>
                        </li>
                      <?php }else{
                        $sub = \App\Models\Tbl_tab_visible::Where('role_id','=',$user_login['role_type'])->Where('tab_id','=',$sub_tab['id'])->first();
                        if (!empty($sub)) { ?>
                          <li class="nav-item">
                            <a href="{{ url(app()->getLocale().'/'.$sub_tab['url']) }}" class="nav-link {!! classActiveSegment(2, $sub_tab['url']) !!}">
                              <i class="nav-icon fa fa-{{ $sub_tab['icon'] }}"></i>
                              <p>
                                {{ trans('app.'.$sub_tab['name']) }}
                              </p>
                            </a>
                          </li>
                    <?php }}} ?>
                    </ul>
                  </li>
                <?php }}} ?>



          </ul>
      </nav>
  </div>
</aside>
