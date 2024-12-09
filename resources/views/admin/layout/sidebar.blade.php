<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
    <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <!--begin::Brand Image--> <img src="{{ asset('AdminLTE/dist/assets/img/AdminLTELogo.png') }}"
                alt="AdminLTE
                Logo" class="brand-image opacity-75 shadow"> <!--end::Brand Image-->
            <!--begin::Brand Text--> <span class="brand-text fw-light">Blogify</span> <!--end::Brand Text--> </a>
        <!--end::Brand Link-->
    </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item"> <a href="{{ route('admin.dashboard') }}" class="nav-link"> <i
                            class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-pencil-square"></i>
                        <p>
                            Blogs
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{ route('blog.index') }}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Index</p>
                            </a> </li>
                    </ul>
                </li>
                @role('super-admin')
                    <li class="nav-item"> <a href="#" class="nav-link"> <i
                                class="nav-icon bi bi-box-arrow-in-right"></i>
                            <p>
                                Roles
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"> <a href="{{ route('index.role') }}" class="nav-link"> <i
                                        class="nav-icon bi bi-circle"></i>
                                    <p>Index</p>
                                </a> </li>
                        </ul>
                    </li>
                    <li class="nav-item"> <a href="#" class="nav-link"> <i
                                class="nav-icon bi bi-box-arrow-in-right"></i>
                            <p>
                                Permissions
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item"> <a href="{{ route('index.permission') }}" class="nav-link"> <i
                                        class="nav-icon bi bi-circle"></i>
                                    <p>Index</p>
                                </a> </li>
                        </ul>
                    </li>
                @endrole
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon fa-solid fa-list"></i>
                        <p>
                            Categories
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{ route('category.index') }}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Index</p>
                            </a> </li>
                    </ul>
                </li>
                <li class="nav-item"> <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-tags"></i>
                        <p>
                            Tags
                        </p>
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{ route('tags.index') }}" class="nav-link"> <i
                                    class="nav-icon bi bi-circle"></i>
                                <p>Index</p>
                            </a> </li>
                    </ul>
                </li>
            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside> <!--end::Sidebar--> <!--begin::App Main-->
