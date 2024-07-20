     <!-- --------------------------------------------------- -->
     <!-- Sidebar -->
     <!-- --------------------------------------------------- -->
     <aside class="left-sidebar">
       <!-- Sidebar scroll-->
       <div>
         <div class="brand-logo d-flex align-items-center justify-content-center">
           <a href="{{ route('dashboard') }}" class="text-nowrap logo-img ">
             <img src="{{ asset('assets/images/logo.png') }}" class="dark-logo" width="115" alt="" />
             <img src="{{ asset('assets/images/logo.png') }}" class="light-logo" width="115" alt="" />
             <h5 class="fs-4 text-center"> Macidai</h5>
           </a>
           <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
             <i class="ti ti-x fs-8 text-muted"></i>
           </div>
         </div>
         <!-- Sidebar navigation-->
         <nav class="sidebar-nav scroll-sidebar" data-simplebar>
           <ul id="sidebarnav">
             <!-- ============================= -->
             <!-- Home -->
             <!-- ============================= -->
             <li class="nav-small-cap">
               <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
               <span class="hide-menu">Home</span>
             </li>
             <!-- =================== -->
             <!-- Dashboard -->
             <!-- =================== -->
             <li class="sidebar-item">
               <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                 <span>
                   <i class="ti ti-aperture"></i>
                 </span>
                 <span class="hide-menu">Dashboard</span>
               </a>
             </li>
             @if (Auth::user()->role == 'admin')
             <li class="nav-small-cap">
               <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
               <span class="hide-menu">Admin Utility</span>
             </li>
             <li class="sidebar-item">
               <a class="sidebar-link" href="{{ route('show_product_admin') }}" aria-expanded="false">
                 <span>
                   <i class="ti ti-crown"></i>
                 </span>
                 <span class="hide-menu">List Product</span>
               </a>
             </li>
             <li class="sidebar-item">
               <a class="sidebar-link" href="{{ route('create_product') }}" aria-expanded="false">
                 <span>
                   <i class="ti ti-pin"></i>
                 </span>
                 <span class="hide-menu">Add Product</span>
               </a>
             </li>
             <li class="sidebar-item">
               <a class="sidebar-link" href="{{ route('index_order') }}" aria-expanded="false">
                 <span>
                   <i class="ti ti-heart"></i>
                 </span>
                 <span class="hide-menu">Order Request</span>
               </a>
             </li>
             @endif

             <!-- =================== -->
             <!--  -->
             <!-- =================== -->
             <li class="nav-small-cap">
               <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
               <span class="hide-menu">Products Bar</span>
             </li>
             <li class="sidebar-item">
               <a class="sidebar-link" href="{{ route('show_products') }}" aria-expanded="false">
                 <span>
                   <i class="ti ti-menu"></i>
                 </span>
                 <span class="hide-menu">Products</span>
               </a>
             </li>
             @if (Auth::user()->role == 'admin')

             @else
             <li class="sidebar-item">
               <a class="sidebar-link" href="{{ route('show_cart') }}" aria-expanded="false">
                 <span>
                   <i class="ti ti-shopping-cart"></i>
                 </span>
                 <span class="hide-menu">Cart</span>
               </a>
             </li>
             @endif

             <!-- ============================= -->
             <!-- OTHER -->
             <!-- ============================= -->


             @if (Auth::user()->role == 'admin')
             @else
             <li class="nav-small-cap">
               <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
               <span class="hide-menu">Order</span>
             </li>

             <li class="sidebar-item">
               <a class="sidebar-link" href="{{ route('transaction_history')}}" aria-expanded="false">
                 <span class="d-flex">
                   <i class="ti ti-star"></i>
                 </span>
                 <div class="lh-base">
                   <span class="hide-menu">Order History</span>
                   <span class="hide-menu fs-2">Recent Purchases</span>
                 </div>
               </a>
             </li>
             @endif

           </ul>
         </nav>
         <!-- Signup -->
         <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
           <div class="hstack gap-3">
             <div class="john-img">
               <img src="../assets/images/profile/user-1.jpg" class="rounded-circle" width="40" height="40" alt="modernize-img" />
             </div>
             <div class="john-title">
               <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
               <span class="fs-2">Designer</span>
             </div>
             <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
               <i class="ti ti-power fs-6"></i>
             </button>
           </div>
         </div>

         <!-- ---------------------------------- -->
         <!-- Start Vertical Layout Sidebar -->
         <!-- ---------------------------------- -->
       </div>
       <!-- End Sidebar scroll-->

     </aside>