<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        {!! Html::image('img/admin-lte/user2-160x160.jpg', 'User Image', ['class'=>'img-circle']) !!}

      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <!-- Status -->
        <a href="#"><i class="fa fa-circle text-success"></i>{{ Auth::user()->roles->first()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">NAVIGATION</li>
      <li {{{ (Request::is('home') ? 'class=active' : '') }}}>
        <a href="{{ URL::to('home') }}">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-cart-arrow-down"></i>
          <span>Purchase</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('purchase-order') }}"><i class="fa fa-circle-o"></i> Purchase Order</a></li>
          <li><a href="{{ url('purchase-order-invoice') }}"><i class="fa fa-circle-o"></i> Invoice</a></li>
          <li><a href="{{ url('purchase-return') }}"><i class="fa fa-circle-o"></i> Return</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i>
          <span>Sales</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('sales-order') }}"><i class="fa fa-circle-o"></i> Sales Order</a></li>
          <li><a href="{{ url('sales-order-invoice') }}"><i class="fa fa-circle-o"></i> Invoice</a></li>
          <li><a href="{{ url('sales-return') }}"><i class="fa fa-circle-o"></i> Return</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-cube"></i>
          <span>Inventory</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('main-product') }}"><i class="fa fa-circle-o"></i> Main Products</a></li>
          <!-- <li><a href="{{ url('product') }}"><i class="fa fa-circle-o"></i> Products</a></li> -->
          <li><a href="{{ url('stock_balance') }}"><i class="fa fa-circle-o"></i> Stock Balance</a></li>
          <li><a href="{{ url('family') }}"><i class="fa fa-circle-o"></i> Product Family</a></li>
          <li><a href="{{ url('category') }}"><i class="fa fa-circle-o"></i> Product Category</a></li>
          <li><a href="{{ url('unit') }}"><i class="fa fa-circle-o"></i> Product Unit</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-money"></i>
          <span>Finance</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('bank') }}"><i class="fa fa-circle-o"></i> Bank</a></li>
          <li><a href="{{ url('cash') }}"><i class="fa fa-circle-o"></i> Cash</a></li>
          <li><a href="{{ url('biaya-operasi') }}"><i class="fa fa-circle-o"></i> Biaya Operasi</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i> Ledger</a></li>
          <li><a href="{{ url('lost-profit') }}"><i class="fa fa-circle-o"></i> Loss &amp; Profit</a></li>
          <li><a href="{{ url('chart-account') }}"><i class="fa fa-circle-o"></i> Chart Account</a></li>
          <li><a href="{{ url('neraca') }}"><i class="fa fa-circle-o"></i> Neraca</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-database"></i>
          <span>Master Data</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('supplier') }}"><i class="fa fa-circle-o"></i> Suppliers</a></li>
          <li><a href="{{ url('customer') }}"><i class="fa fa-circle-o"></i> Customer</a></li>
          <li><a href="{{ url('invoice-term') }}"><i class="fa fa-circle-o"></i> Invoice Terms</a></li>
          <li><a href="{{ url('driver') }}"><i class="fa fa-circle-o"></i> Drivers</a></li>
          <li><a href="{{ url('vehicle') }}"><i class="fa fa-circle-o"></i> Vehicle</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Users</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('user') }}"><i class="fa fa-circle-o"></i> Users List</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-lock"></i>
          <span>Role and Permission</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('role') }}"><i class="fa fa-circle-o"></i> Role</a></li>
          <li><a href="{{ url('permission') }}"><i class="fa fa-circle-o"></i> Permission</a></li>
        </ul>
      </li>
    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
