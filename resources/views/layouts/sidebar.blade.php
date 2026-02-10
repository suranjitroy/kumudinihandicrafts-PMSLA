<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    
      {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <p class="text-lg">Kumudini Handicrafts</p>
      {{-- <p class="text-lg"><span class="fas fa-user"></span> {{ auth()->user()->name}}</p> --}}
      <p class="text-lg"><span class="fas fa-user"></span> User ID : {{ auth()->user()->user_name}}</p>
      {{-- <p class="text-lg"><span class="fas fa-user"></span> {{ $user->getRoleNames()-> }}</p> --}}

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> --}}

      <!-- SidebarSearch Form -->
      {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
         <!--Layout Option-->
          @role('super-admin')
          <li class="nav-header">Roles, Permissions & Users</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Manage Roles, Permission, Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('permission.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permissions</p>
                </a>
              </li>
             

              <li class="nav-item">
                <a href="{{ route('role.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roles</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users</p>
                </a>
              </li>
            </ul>
          </li>
          @endrole
          @role('Store Staff')
          {{-- <li class="nav-header">Manage Stores</li> --}}
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Store Setting
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('store.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Store</p>
                </a>
              </li>
              

              <li class="nav-item">
                <a href="{{ route('store-category.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Store Category</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('unit.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Unit</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="{{ route('material-setup.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Material Setup</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('supplier.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Supplier</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('section.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Section</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('master-info.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master Information Entry</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('worker-info.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Worker Information Entry</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="{{ route('artisan-group.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Artisan Group Entry</p>
                </a>
              </li>
            </ul>
            </li>
          @endrole
           @role('Store Staff|manager|admin')
          {{-- <li class="nav-header">Manage Purchase</li> --}}
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Manage Purchase
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('purchase-receive.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Receive (Material Item)</p>
                </a>
              </li>
              

              {{-- <li class="nav-item">
                <a href="{{ route('store-category.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Store Category</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('unit.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Unit</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="{{ route('material-setup.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Material Setup</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('supplier.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Supplier</p>
                </a>
              </li> --}}

            </ul>
            </li>
          @endrole

           @role('Store Staff|manager|admin')
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Manage Requsition
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Store Requsition</p>
                  <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('store-requsition.index') }}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Create New Requsition</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Pending Store Requsition</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Approval Store Requsition</p>
                    </a>
                  </li>
                </ul>
              </li>


            </ul>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Requsition</p>
                  <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('purchase-requsition.index') }}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Create New Requsition</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Pending Purchase Requsition</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Approval Purchase Requsition</p>
                    </a>
                  </li>
                </ul>
              </li>


            </ul>
            
            </li>
          @endrole


        @role('Store Staff|manager|super-admin')
          {{-- <li class="nav-header">Manage Consumption</li> --}}
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Manage Consumption
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item">
                <a href="{{ route('item.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Item</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('bahar.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bahar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('size.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Size</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="{{ route('consumption-setup.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Consumption Setup</p>
                </a>
              </li>

              

              {{-- <li class="nav-item">
                <a href="{{ route('store-category.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Store Category</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('unit.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Unit</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="{{ route('material-setup.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Material Setup</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('supplier.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Supplier</p>
                </a>
              </li> --}}

            </ul>
            </li>
        @endrole

        @role('Store Staff|manager|admin')
        <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Manage Work Order
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sample Order</p>
                  <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('sample-work-order.index') }}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Sample Order Sheet</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Pending Store Requsition</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Approval Store Requsition</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Production Order</p>
                  <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('production-work-order.index') }}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Production Order Sheet</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Pending Purchase Requsition</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Approval Purchase Requsition</p>
                    </a>
                  </li>
                </ul>
              </li>


            </ul>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Embroidery Orders</p>
                  <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('emb-order-sheet.index') }}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Embroidery Order</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Pending Purchase Requsition</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Approval Purchase Requsition</p>
                    </a>
                  </li>
                </ul>
              </li>


            </ul>
            
        </li>
          @endrole

        @role('Store Staff|manager|admin')
        <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                 Order Processing
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

            <li class="nav-item">
                <a href="{{ route('process-section.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Process Section Entry</p>
                </a>
            </li>

              

              <li class="nav-item">
                <a href="{{ route('order-processing.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Processing List</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('store-category.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Store Category</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('unit.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Unit</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="{{ route('material-setup.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Material Setup</p>
                </a>
              </li>

            </ul>
            </li>
          @endrole

        @role('Store Staff|manager|admin')
        <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Manage Order
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Assign</p>
                  <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('order-distribution.index') }}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Order Assign</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Recieved</p>
                  <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('order-receive.index') }}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Order Receive</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Pending Purchase Requsition</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Approval Purchase Requsition</p>
                    </a>
                  </li>
                </ul>
              </li>


            </ul>
            
        </li>
        @endrole
        

        @role('Store Staff|manager|admin')
        <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Product Setup
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('product-type.index') }}" class="nav-link">
                <i class="far fa-dot-circle nav-icon"></i>
                <p>Product Type</p>
              </a>
            </li>
            </ul>
        </li>
        @endrole

        @role('Store Staff|manager|admin')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Manage Stock
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('fabric.stock') }}" class="nav-link">
                <i class="far fa-dot-circle nav-icon"></i>
                <p>Fabric Stock</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('accessories.stock') }}" class="nav-link">
                <i class="far fa-dot-circle nav-icon"></i>
                <p>Accessories Stock</p>
              </a>
            </li>
            </ul>
        </li>
        @endrole

         @role('Store Staff|manager|admin')
          {{-- <li class="nav-header">Other Order Sheet Section</li> --}}
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Other Order Sheet
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('other-order-sheet.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Sheet</p>
                </a>
                <a href="{{ route('other-order-sheet-total.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Sheet Total</p>
                </a>
              </li>

            </ul>
          </li>
         @endrole

         @role('Store Staff|manager|admin')
          {{-- <li class="nav-header">Design Section</li> --}}
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Manage Design
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('design-info.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Design Entry</p>
                </a>
                <a href="{{ route('other-order-sheet-total.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Order Sheet Total</p>
                </a>
              </li>

            </ul>
          </li>
         @endrole

         @role('Store Staff|manager|admin')
          {{-- <li class="nav-header">Design Section</li> --}}
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Manage Challan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('production-challan.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Production Challan</p>
                </a>
                <a href="{{ route('other-order-sheet-total.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Other Challan</p>
                </a>
              </li>

            </ul>
          </li>
         @endrole

         @role('Store Staff|manager|admin')
          {{-- <li class="nav-header">Design Section</li> --}}
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Manage Embroidery
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                    <a href="{{ route('emb-order-sheet.index') }}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Embroidery Order</p>
                    </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('embroidery-receive.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                    <p>Embroidery Order Receive</p>
                </a>
                <a href="{{ route('embroidery-process.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Embroidery Order Process</p>
                </a>
              </li>



            </ul>
          </li>
         @endrole
         <!--Layout Option End-->

          <!--Layout Option-->
          {{-- <li class="nav-header">Roles, Permissions & Users</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Layout Options
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/layout/top-nav.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Top Navigation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Top Navigation + Sidebar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/boxed.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Boxed</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/fixed-sidebar.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fixed Sidebar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/fixed-sidebar-custom.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fixed Sidebar <small>+ Custom Area</small></p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/fixed-topnav.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fixed Navbar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/fixed-footer.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fixed Footer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/collapsed-sidebar.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Collapsed Sidebar</p>
                </a>
              </li>
            </ul>
          </li> --}}
         <!--Layout Option End-->

          <!--MULTI LEVEL EXAMPLE-->
          {{-- <li class="nav-header">MULTI LEVEL EXAMPLE</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>Level 1</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Level 1
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Level 2
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>Level 1</p>
            </a>
          </li> --}}
          <!--MULTI LEVEL EXAMPLE END-->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>