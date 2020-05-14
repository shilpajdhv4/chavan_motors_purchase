    
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="image" style="text-align: center;">
          <img src="{{ asset ('logo/Logo.png') }}" class="" alt="User Image">
        </div>
        <div class="pull-left info">
         
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="active">
            <a href="{{url('home')}}">
            <i class="fa fa-dashboard"></i> <span>Home
          </a>
        </li>
        <li class="treeview <?php if(Request::is('users') || Request::is('product_list') || Request::is('list-department') || Request::is('item_list') || Request::is('vendor_list') || Request::is('enq_location_list')){ ?> menu-open <?php } ?>">
          @can('user-list','list-department','product_list','item_list','vendor_list','enq_location_list')
          <a href="#">
            <i class="fa fa-list"></i> <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          @endcan
          <ul class="treeview-menu" <?php if(Request::is('users') || Request::is('product_list')|| Request::is('list-company') || Request::is('list-department') || Request::is('item_list') || Request::is('vendor_list') || Request::is('enq_location_list')){ ?> style="display:block" <?php } ?>>
              @can('list-company')
            <li <?php if(Request::is('list-company')) { ?>class="active" <?php } ?>><a href="{{url('list-company')}}"><i class="fa fa-circle-o"></i> <span>Company Master</span></a></li>
            @endcan
              @can('enq_location_list')
            <li <?php if(Request::is('enq_location_list')) { ?>class="active" <?php } ?>><a href="{{url('enq_location_list')}}"><i class="fa fa-circle-o"></i> <span>Location</span></a></li>
            @endcan
            @can('list-department')
            <li <?php if(Request::is('list-department')) { ?>class="active" <?php } ?>><a href="{{url('list-department')}}"><i class="fa fa-circle-o"></i> <span>Department</span></a></li>
            @endcan
            @can('user-list')
               <li <?php if(Request::is('users')) { ?>class="active" <?php } ?>><a href="{{route('users.index')}}"><i class="fa fa-circle-o"></i>Manage Users</a></li>
            @endcan
           
            @can('product_list')
            <li <?php if(Request::is('product_list')) { ?>class="active" <?php } ?>><a href="{{url('product_list')}}"><i class="fa fa-circle-o"></i> <span>Product List</span></a></li>
            @endcan
            @can('item_list')
            <li <?php if(Request::is('item_list')) { ?>class="active" <?php } ?>><a href="{{url('item_list')}}"><i class="fa fa-circle-o"></i> <span>Item List</span></a></li>
            @endcan
            @can('add_vendor')
            <!--<li><a href="{{url('add_vendor')}}"><i class="fa fa-circle-o"></i> <span>Add Vendor</span></a></li>-->
            <li <?php if(Request::is('vendor_list')) { ?>class="active" <?php } ?>><a href="{{url('vendor_list')}}"><i class="fa fa-circle-o"></i> <span>Vendor List</span></a></li>
            @endcan
            
          </ul>
        </li>
         <!--@can('create_purchase_form')-->
<!--        <li <?php if(Request::is('create_purchase_form')) { ?>class="active" <?php } ?>>
            <a href="{{url('create_purchase_form')}}">
                <i class="fa fa-circle-o"></i> <span>Create Purchase Form</span>
          </a>
        </li>-->
         <!--@endcan-->
         @can('vendor_to_po_dept')
        <li <?php if(Request::is('vendor_to_po_dept')) { ?>class="active" <?php } ?>>
            <a href="{{url('vendor_to_po_dept')}}">
                <i class="fa fa-circle-o"></i> <span>Vendor To Purchase Dept</span>
          </a>
        </li>
        @endcan
        @can('storage_list')
        <li <?php if(Request::is('storage_list')) { ?>class="active" <?php } ?>>
            <a href="{{url('storage_list')}}">
                <i class="fa fa-circle-o"></i> <span>Storage Location List</span>
          </a>
        </li>
        @endcan
        @can('storage_location')
        <li <?php if(Request::is('storage_location')) { ?>class="active" <?php } ?>>
            <a href="{{url('storage_location')}}">
                <i class="fa fa-circle-o"></i> <span>Storage Location</span>
          </a>
        </li>
        @endcan
        @can('order_list')
        <li <?php if(Request::is('order_list')) { ?>class="active" <?php } ?>>
            <a href="{{url('order_list')}}">
                <i class="fa fa-circle-o"></i> <span>Team Leader Request List</span>
          </a>
        </li>
        @endcan
        @can('order_form')
        <li <?php if(Request::is('order_form')) { ?>class="active" <?php } ?>>
            <a href="{{url('order_form')}}">
                <i class="fa fa-circle-o"></i> <span>Request Form</span>
          </a>
        </li>
        @endcan
        @can('order_list_to_tl')
        <li <?php if(Request::is('order_list_to_tl')) { ?>class="active" <?php } ?>>
            <a href="{{url('order_list_to_tl')}}">
                <i class="fa fa-circle-o"></i> <span>Request List</span>
          </a>
        </li>
        @endcan
        @can('order_utilize_form')
        <li <?php if(Request::is('order_utilize_form')) { ?>class="active" <?php } ?>>
            <a href="{{url('order_utilize_form')}}">
                <i class="fa fa-circle-o"></i> <span>Material Utilize</span>
          </a>
        </li>
        @endcan
         @can('nofi_page')
        <li <?php if(Request::is('nofi_page')) { ?>class="active" <?php } ?>>
            <a href="{{url('nofi_page')}}">
                <i class="fa fa-circle-o"></i> <span>Stock Quantity </span>
          </a>
        </li>
        @endcan
        
       
        
          @can('order_tl_today_dm')
        <li <?php if(Request::is('order_tl_today_dm')) { ?>class="active" <?php } ?>>
            <a href="{{url('order_tl_today_dm')}}">
                <i class="fa fa-circle-o"></i> <span>Today Order from TL</span>
          </a>
        </li>
        @endcan
         @can('order_tl_today_gm')
        <li <?php if(Request::is('order_tl_today_gm')) { ?>class="active" <?php } ?>>
            <a href="{{url('order_tl_today_gm')}}">
                <i class="fa fa-circle-o"></i> <span>Today Order from Manager</span>
          </a>
        </li>
        @endcan
        @can('checker_list')
        <li <?php if(Request::is('checker_list')) { ?>class="active" <?php } ?>>
            <a href="{{url('checker_list')}}">
                <i class="fa fa-circle-o"></i> <span>Return From User</span>
          </a>
        </li>
         @endcan
         @can('tl_check_list')
         <li <?php if(Request::is('tl_check_list')) { ?>class="active" <?php } ?>>
            <a href="{{url('tl_check_list')}}">
                <i class="fa fa-circle-o"></i> <span>Return From User</span>
          </a>
        </li>
        @endcan
        @can('gm_check_list')
         <li <?php if(Request::is('gm_check_list')) { ?>class="active" <?php } ?>>
            <a href="{{url('gm_check_list')}}">
                <i class="fa fa-circle-o"></i> <span>Return From User</span>
          </a>
        </li>
        @endcan
        @can('vendor_to_po_dept')
        <li <?php if(Request::is('get_report')) { ?>class="active" <?php } ?>>
            <a href="{{url('get_report')}}">
                <i class="fa fa-circle-o"></i> <span>Approved Order</span>
          </a>
        </li>
         @endcan
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>