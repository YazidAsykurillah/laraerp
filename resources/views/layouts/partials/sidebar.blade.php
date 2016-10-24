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
        <a href="#"><i class="fa fa-circle text-success"></i>Online</a>
      </div>
    </div>

    <!-- search form (Optional) -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>
    <!-- /.search form -->

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">NAVIGATION</li>
      <li {{{ (Request::is('dashboard') ? 'class=active' : '') }}}>
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
          <li><a href="#"><i class="fa fa-circle-o"></i> Invoice</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i> Return</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i>
          <span>Sales</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="#"><i class="fa fa-circle-o"></i> Sales Order</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i> Invoice</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i> Return</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-cube"></i>
          <span>Inventory</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('product') }}"><i class="fa fa-circle-o"></i> Products</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i> Stock Balance</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-money"></i>
          <span>Finance</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="#"><i class="fa fa-circle-o"></i> Bank</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i> Ledger</a></li>
          <li><a href="#"><i class="fa fa-circle-o"></i> Loss &amp; Profit</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-database"></i>
          <span>Master Data</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('supplier') }}"><i class="fa fa-circle-o"></i> Suppliers</a></li>
          <li><a href="{{ url('category') }}"><i class="fa fa-circle-o"></i> Product Category</a></li>
        </ul>
      </li>
    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>