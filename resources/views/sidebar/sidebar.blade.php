<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo mb-3">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{asset('assets/img/logo/ekodus-logo.png')}}" alt="Ekodus Canada Logo" style="height:60px;">
            </span>
        </a>

        <a href="javascript:void(0);"
            class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ Request::segment(1) === 'dashboard' ? 'active' : '' }} ">
            <a href="{{route('admin.view.dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        <li class="menu-item {{ Request::segment(1) === 'blog' ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxl-blogger"></i>
                <div data-i18n="Layouts">Blogs</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ Request::segment(2) === 'allBlog' ? 'active' : '' }}">
                    <a href="{{route('admin.view.all.blog')}}" class="menu-link">
                        <div data-i18n="Without menu">All Blogs</div>
                    </a>
                </li>
                <li class="menu-item {{Request::segment(2) === 'add-new-blog-page' ? 'active' : ''}}">
                    <a href="{{route('admin.create.new.blog')}}" class="menu-link">
                        <div data-i18n="Without menu">Add New</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ Request::segment(1) === 'opening' ? 'active open' : '' }}" style="">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon bx bxs-briefcase-alt"></i>
                <div data-i18n="career">Openings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::segment(2) === 'add-new-opening-page' ? 'active' : '' }}">
                    <a href="{{route('admin.add.new.opening.page')}}" class="menu-link">
                        <div data-i18n="Accordion">Add New Opening</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::segment(2) === 'active-opening' ? 'active' : '' }}">
                    <a href="{{route('admin.active.opening')}}" class="menu-link">
                        <div data-i18n="Alerts">Active Openings</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::segment(2) === 'deActive-opening' ? 'active' : '' }}">
                    <a href="{{route('admin.deActive.opening')}}" class="menu-link">
                        <div data-i18n="Alerts">De-Active Openings</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ Request::segment(1) === 'candidate' ? 'active open' : '' }}" style="">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon bx bx-user-pin"></i>
                <div data-i18n="career">Candidates</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::segment(2) === 'all-candidates' ? 'active' : '' }}">
                    <a href="{{route('admin.all.candidates')}}" class="menu-link">
                        <div data-i18n="Accordion">All Candidates</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>