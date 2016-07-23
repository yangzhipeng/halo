<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image" />
      </div>
      <div class="pull-left info">
        <p>{{ Auth::getUser()->hasOneAdminInfo->admin_name }}</p>
        <!-- Status -->
        <a href="{{ URL::to('admin/logout') }}"><i class="fa fa-circle text-success"></i> [登出]</a>
        <a href="{{ URL::to('admin/admin/admininfo/update') }}">[修改]</a>
      </div>
    </div>

    <!-- search form (Optional) -->
    {{--<form action="#" method="get" class="sidebar-form">--}}
      {{--<div class="input-group">--}}
        {{--<input type="text" name="q" class="form-control" placeholder="Search..."/>--}}
        {{--<span class="input-group-btn">--}}
          {{--<button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>--}}
        {{--</span>--}}
      {{--</div>--}}
    {{--</form>--}}
    <!-- /.search form -->

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">Uni后台管理</li>
      <!-- Optionally, you can add icons to the links -->
      {{--<li class="@yield('index')"><a href="#"><i class="fa fa-files-o"></i><span>后台管理首页</span></a></li>--}}
      {{--<li><a href="#"><i class="fa fa-user"></i><span>Another Link</span></a></li>--}}
      {{--<li class="treeview">--}}
        {{--<a href="#"><i class="fa fa-users"></i><span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>--}}
        {{--<ul class="treeview-menu">--}}
          {{--<li><a href="#"><i class="fa fa-circle-o"></i>Link in level 2</a></li>--}}
          {{--<li><a href="#"><i class="fa fa-circle-o"></i>Link in level 2</a></li>--}}
        {{--</ul>--}}
      {{--</li>--}}
      <li class="@yield('dashboard')"><a href="/admin/dashboard"><i class="fa fa-dashboard"></i><span>数据报表</span></a></li>
      @if(Auth::getUser()->belongsToAdminLevel->level_value == 255)
      <li class="@yield('admin_index')"><a href="/admin/admin"><i class="fa fa-users"></i><span>管理员管理</span></a></li>
      @endif
      {{--<li class="@yield('user_index')"><a href="/admin/user"><i class="fa fa-user"></i><span>用户管理</span></a></li>--}}
      <li class="treeview @yield('user')">
        <a href="#">
          <i class="fa fa-pie-chart"></i>
          <span>用户管理</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="@yield('user_index')" ><a href="/admin/user"><i class="fa fa-circle-o"></i> 用户信息</a></li>
          <li class="@yield('user_push')" ><a href="/admin/user/inputmsg"><i class="fa fa-circle-o"></i> 消息推送</a></li>
          <li class="@yield('user_sms')" ><a href="/admin/user/inputsms"><i class="fa fa-circle-o"></i> sms推送</a></li>
        </ul>
      </li>
      <li class="treeview @yield('circleuser')">
        <a href="#">
          <i class="fa fa-pie-chart"></i>
          <span>圈圈管理</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="@yield('circleuser_index')" ><a href="/admin/circleuser"><i class="fa fa-circle-o"></i> 用户信息</a></li>
          <li class="@yield('circleuser_school')" ><a href="/admin/circleschool"><i class="fa fa-circle-o"></i> 学校展示</a></li>
        </ul>
      </li>
      <li class="@yield('school_index')"><a href="/admin/school"><i class="fa fa-hospital-o"></i><span>学校管理</span></a></li>
      <li class="treeview @yield('adv')">
        <a href="#">
          <i class="fa fa-pie-chart"></i>
          <span>全局设置</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="@yield('globalAdv_index')" ><a href="/admin/adv/topbanneradv"><i class="fa fa-circle-o"></i> 顶部Banner广告设置</a></li>
          <li class="@yield('multiAdv_index')" ><a href="/admin/adv/multiadv"><i class="fa fa-circle-o"></i> 多样式广告设置</a></li>
          <li class="@yield('vipcard_index')" ><a href="/admin/cardcategory/vipcard"><i class="fa fa-circle-o"></i> 会员卡分类设置</a></li>
          <li class="@yield('icon_index')" ><a href="/admin/adv/icon/iconset"><i class="fa fa-circle-o"></i> icon设置</a></li>
        </ul>
      </li>
      <li class="treeview @yield('account')">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>资金管理</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="@yield('account_balance')" ><a href="/admin/account/balance"><i class="fa fa-circle-o"></i> 账户余额</a></li>
            <li class="@yield('account_charge')" ><a href="/admin/account/charge"><i class="fa fa-circle-o"></i> 充值记录</a></li>
            <li class="@yield('account_cash')" ><a href="/admin/account/cash"><i class="fa fa-circle-o"></i> 提现记录</a></li>
            <li class="@yield('account_inline')"><a href="/admin/account/transaction_records"><i class="fa fa-circle-o"></i> 交易记录</a></li>
          </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-pie-chart"></i>
          <span>投诉管理</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="@yield('contact_complaint')" ><a href="/admin/complaint/p2pcomplaint"><i class="fa fa-circle-o"></i> 任务投诉</a></li>
        </ul>
      </li>
      <li class="treeview @yield('flashsale')">
        <a href="#">
          <i class="fa fa-pie-chart"></i>
          <span>秒杀管理</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="@yield('flashsale_product')" ><a href="/admin/flashsale/product/productindex"><i class="fa fa-circle-o"></i> 商品管理</a></li>
          <li class="@yield('flashsale_brand')" ><a href="/admin/flashsale/brand/brandindex"><i class="fa fa-circle-o"></i> 商品品牌管理</a></li>
          <li class="@yield('flashsale_category')" ><a href="/admin/flashsale/category/categoryindex"><i class="fa fa-circle-o"></i> 商品类别管理</a></li>
          <li class="@yield('flashsale_plan')" ><a href="/admin/flashsale/plan/planindex"><i class="fa fa-circle-o"></i> 商品计划管理</a></li>
          <li class="@yield('flashsale_brand')" ><a href="/admin/flashsale/order/orderDetail"><i class="fa fa-circle-o"></i> 商品订单管理</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-pie-chart"></i>
          <span>任务管理</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li class="" ><a href="/admin/school/usertask/index?cid=10000040"><i class="fa fa-circle-o"></i> 任务</a></li>
          <li class="" ><a href="/admin/school/usertask/getindex"><i class="fa fa-circle-o"></i> 发布任务</a></li>
          <li class="" ><a href="/admin/school/usertask/test"><i class="fa fa-circle-o"></i> 测试</a></li>
        </ul>
      </li>
    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>