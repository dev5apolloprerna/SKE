<?php 
$roleid = auth()->user()->role_id;
?>
<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu"></span></li>
                 <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                    </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @if (request()->routeIs('admin.categories.*')) {{ 'active' }} @endif"
                       href="{{ route('admin.categories.index') }}">
                        <i class="fa fa-list"></i>
                        <span data-key="t-categories">Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}"
                       class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        Products
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.gallery-images.index') }}"
                       class="nav-link {{ request()->is('admin/gallery-images*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-images"></i>
                        Gallery Images
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.inquiries.index') }}"
                       class="nav-link {{ request()->is('admin/inquiries*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        Inquiries
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>