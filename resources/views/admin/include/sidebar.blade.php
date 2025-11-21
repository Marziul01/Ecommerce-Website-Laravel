<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion newly-edit-navbar" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><img src="{{ asset($siteSettings->logo) }}" width="115px"></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Nav Item - Pages Collapse Menu -->

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrder"
           aria-expanded="true" aria-controls="collapseTwo">
           <i class="fa-solid fa-boxes-packing"></i>
            <span>Order Manage</span>
        </a>
        <div id="collapseOrder" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('ordersPending') }}">Pending Orders</a>
                <a class="collapse-item" href="{{ route('ordersProcessing') }}">Processing Orders</a>
                <a class="collapse-item" href="{{ route('ordersshiped') }}">Shipped Orders</a>
                <a class="collapse-item" href="{{ route('ordersComplete') }}">Delivered Orders</a>
                <a class="collapse-item" href="{{ route('ordersCancel') }}">Cancelled Orders</a>
                <a class="collapse-item" href="{{ route('ordersreturnrequesst') }}">Return Requested Orders</a>
                <a class="collapse-item" href="{{ route('ordersreturenen') }}">Returned & Refunded Orders</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrder2"
           aria-expanded="true" aria-controls="collapseTwo">
           <i class="fa-solid fa-table-list"></i>
            <span>Categories Manage</span>
        </a>
        <div id="collapseOrder2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('category.index') }}">Category</a>
                <a class="collapse-item" href="{{ route('subcategory.index') }}">Sub Categories</a>
            </div>
        </div>
    </li>


    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('brand.index') }}">
            <i class="fa-solid fa-shield-halved"></i>
            <span>Brand Manage</span>
        </a>

    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('product.index') }}">
            <i class="fa-solid fa-box"></i>
            <span>Product Manage</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVariation"
           aria-expanded="true" aria-controls="collapseTwo">
           <i class="fa-solid fa-list-check"></i>
            <span>Variation Manage</span>
        </a>
        <div id="collapseVariation" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('variations.index') }}">Colors</a>
                <a class="collapse-item" href="{{ route('variationSize') }}">Sizes</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('coupons.index') }}">
            <i class="fa-solid fa-ticket"></i>
            <span>Coupon Manage</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('shipping') }}">
            <i class="fa-solid fa-truck-arrow-right"></i>
            <span>Shipping Charge Manage</span>
        </a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('payment_methods.index') }}">
            <i class="fa-solid fa-money-check"></i>
            <span>Payment Methods Manage</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('sales_report') }}">
            <i class="fa-solid fa-money-bill-trend-up"></i>
            <span>Sales Report</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSite"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Site Settings</span>
        </a>
        <div id="collapseSite" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('headerSettings') }}">Header</a>
                <a class="collapse-item" href="{{ route('footerSettings') }}">Footer</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
           aria-expanded="true" aria-controls="collapseTwo">
           <i class="fa-solid fa-gears"></i>
            <span>Pages Manage</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('homeSettings') }}">Home</a>
                <a class="collapse-item" href="{{ route('aboutPage') }}">About</a>
                <a class="collapse-item" href="{{ route('contactPage') }}">Contact</a>
                <a class="collapse-item" href="{{ route('privacy_policy') }}">Privacy Policy</a>
                <a class="collapse-item" href="{{ route('terms_and_condition') }}">Terms & Condition</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('users.index') }}">
            <i class="fa-solid fa-users"></i>
            <span>Customers Manage</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('reviews') }}">
            <i class="fa-solid fa-file-pen"></i>
            <span>Reviews Manage</span>
        </a>
    </li>


</ul>

